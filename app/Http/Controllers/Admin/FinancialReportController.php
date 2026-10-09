<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FinancialReportController extends Controller
{
    /**
     * Display financial reports and payment history.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
        ]);

        // Default period: the first day of this month through today.
        $fromDate = $validated['from']
            ?? now()->startOfMonth()->toDateString();

        $toDate = $validated['to']
            ?? now()->toDateString();

        $from = Carbon::parse($fromDate)->startOfDay();
        $to = Carbon::parse($toDate)->endOfDay();

        if ($from->greaterThan($to)) {
            return back()
                ->withErrors([
                    'to' => 'Tanggal akhir tidak boleh mendahului tanggal awal.',
                ])
                ->withInput();
        }

        /*
         * Only successful payments within the selected period
         * count as recorded revenue.
         */
        $buildQuery = static function () use ($from, $to) {
            return DB::table('payments as p')
                ->join('invoices as i', 'i.id', '=', 'p.invoice_id')
                ->join(
                    'repair_requests as r',
                    'r.id',
                    '=',
                    'i.repair_request_id'
                )
                ->join('users as u', 'u.id', '=', 'r.user_id')
                ->where('p.status', 'paid')
                ->whereNotNull('p.paid_at')
                ->whereBetween('p.paid_at', [$from, $to]);
        };

        $query = $buildQuery();

        // Summary cards.
        $totalRevenue = (clone $query)->sum('p.amount');

        $transactionCount = (clone $query)->count('p.id');

        $averageTransaction = $transactionCount > 0
            ? $totalRevenue / $transactionCount
            : 0;

        // Totals grouped by payment method.
        // Normalize payment methods for financial reporting.
        $paymentMethodExpression = "
            CASE
                WHEN LOWER(p.payment_method) IN (
                    'bca',
                    'mandiri',
                    'bni',
                    'bank_transfer'
                )
                THEN 'bank transfer'

                WHEN LOWER(p.payment_method) = 'qris'
                THEN 'qris'

                ELSE LOWER(p.payment_method)
            END
        ";

        $paymentBreakdown = (clone $query)
            ->selectRaw("
                {$paymentMethodExpression} AS payment_method,
                COUNT(p.id) AS transaction_count,
                SUM(p.amount) AS total_amount
            ")
            ->groupByRaw($paymentMethodExpression)
            ->orderByDesc('total_amount')
            ->get();
        // Detailed payment history.
        $transactions = (clone $query)
            ->select([
                'p.id',
                'p.amount',
                'p.status',
                'p.paid_at',
                'i.invoice_number',
                'u.name as customer_name',
                'u.email as customer_email',
            ])
            ->selectRaw("
                CASE
                    WHEN LOWER(p.payment_method) = 'qris'
                        THEN 'QRIS'

                    WHEN LOWER(p.payment_method) IN (
                        'bca',
                        'mandiri',
                        'bni'
                    )
                        THEN UPPER(p.payment_method)

                    WHEN LOWER(p.payment_method) = 'bank_transfer'
                        THEN 'BANK TRANSFER'

                    ELSE UPPER(p.payment_method)
                END AS payment_method
            ")
            ->orderByDesc('p.paid_at')
            ->orderByDesc('p.id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.financial-reports.index', [
            'fromDate' => $from->toDateString(),
            'toDate' => $to->toDateString(),
            'totalRevenue' => $totalRevenue,
            'transactionCount' => $transactionCount,
            'averageTransaction' => $averageTransaction,
            'paymentBreakdown' => $paymentBreakdown,
            'transactions' => $transactions,
        ]);
    }
}
