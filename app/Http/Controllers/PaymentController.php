<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\RepairRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Show the payment method selection page.
     */
    public function create(RepairRequest $repair): View
    {
        abort_unless(
            $repair->user_id === auth()->id(),
            403
        );

        $repair->load('invoice');

        abort_unless(
            $repair->invoice,
            404
        );

        abort_unless(
            $repair->final_cost !== null,
            403
        );

        abort_unless(
            $repair->status === 'waiting_payment',
            403
        );

        abort_unless(
            $repair->invoice->status !== 'paid',
            403
        );

        return view('payments.create', compact('repair'));
    }


    /**
     * Store a payment.
     *
     * Legacy/direct payment endpoint.
     */
    public function store(
        Request $request,
        Invoice $invoice
    ): RedirectResponse {
        abort_unless(
            $invoice->repairRequest->user_id === auth()->id(),
            403
        );

        $repair = $invoice->repairRequest;

        if ($invoice->status === 'paid') {
            return back()->withErrors([
                'payment' => 'Invoice ini sudah dibayar.',
            ]);
        }

        if ($repair->final_cost === null) {
            return back()->withErrors([
                'payment' => 'Final cost belum ditentukan.',
            ]);
        }

        if ($repair->status !== 'waiting_payment') {
            return back()->withErrors([
                'payment' => 'Pembayaran belum tersedia untuk repair ini.',
            ]);
        }

        $validated = $request->validate([
            'payment_method' => [
                'required',
                'in:cash,bank_transfer,e_wallet',
            ],
        ]);

        Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $invoice->total_amount,
            'payment_method' => $validated['payment_method'],
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $repair->update([
            'status' => 'paid',
        ]);

        $repair->repairHistories()->create([
            'status' => 'paid',
            'note' => 'Payment received for invoice ' . $invoice->invoice_number . '.',
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('repairs.show', $repair)
            ->with('success', 'Pembayaran berhasil dicatat.');
    }


    /**
     * Show the QRIS payment page.
     */
    public function qris(RepairRequest $repair): View
    {
        abort_unless(
            $repair->user_id === auth()->id(),
            403
        );

        $repair->load('invoice');

        abort_unless(
            $repair->invoice,
            404
        );

        abort_unless(
            $repair->final_cost !== null,
            403
        );

        abort_unless(
            $repair->status === 'waiting_payment',
            403
        );

        abort_unless(
            $repair->invoice->status !== 'paid',
            403
        );

        return view('payments.qris', compact('repair'));
    }


    /**
     * Process simulated QRIS payment.
     */
    public function processQris(
        Request $request,
        Invoice $invoice
    ): RedirectResponse {
        abort_unless(
            $invoice->repairRequest->user_id === auth()->id(),
            403
        );

        $repair = $invoice->repairRequest;

        if ($invoice->status === 'paid') {
            return redirect()
                ->route('repairs.show', $repair)
                ->with('success', 'Invoice ini sudah dibayar.');
        }

        if ($repair->final_cost === null) {
            return back()->withErrors([
                'payment' => 'Final cost belum ditentukan.',
            ]);
        }

        if ($repair->status !== 'waiting_payment') {
            return back()->withErrors([
                'payment' => 'Pembayaran belum tersedia untuk repair ini.',
            ]);
        }

        Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $invoice->total_amount,
            'payment_method' => 'qris',
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $repair->update([
            'status' => 'paid',
        ]);

        $repair->repairHistories()->create([
            'status' => 'paid',
            'note' => 'QRIS payment received for invoice ' . $invoice->invoice_number . '.',
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('repairs.show', $repair)
            ->with('success', 'Pembayaran QRIS berhasil.');
    }

        /**
        * Show the bank transfer selection page.
        */
        public function bankTransfer(RepairRequest $repair): View
        {
        abort_unless(
            $repair->user_id === auth()->id(),
            403
        );

        $repair->load('invoice');

        abort_unless(
            $repair->invoice,
            404
        );

        abort_unless(
            $repair->final_cost !== null,
            403
        );

        abort_unless(
            $repair->status === 'waiting_payment',
            403
        );

        abort_unless(
            $repair->invoice->status !== 'paid',
            403
        );

        return view('payments.bank-transfer', compact('repair'));
    }  

    /**
    * Show bank account information.
    */
        public function bankAccount(
            RepairRequest $repair,
            string $bank
        ): View {
            abort_unless(
            $repair->user_id === auth()->id(),
            403
        );

        $repair->load('invoice');

        abort_unless(
            $repair->invoice,
            404
        );

        abort_unless(
            $repair->final_cost !== null,
            403
        );

        abort_unless(
            $repair->status === 'waiting_payment',
            403
        );

        abort_unless(
            $repair->invoice->status !== 'paid',
            403
        );

        $banks = [
            'bca' => [
                'name' => 'Bank Central Asia',
                'short_name' => 'BCA',
                'account_number' => '1234567890',
                'account_name' => 'PT FixIT Indonesia',
            ],

            'mandiri' => [
                'name' => 'Bank Mandiri',
                'short_name' => 'Mandiri',
                'account_number' => '9876543210',
                'account_name' => 'PT FixIT Indonesia',
            ],  

            'bni' => [
                'name' => 'Bank Negara Indonesia',
                'short_name' => 'BNI',
                'account_number' => '1122334455',
                'account_name' => 'PT FixIT Indonesia',
            ],
    ];

        abort_unless(
            isset($banks[$bank]),
            404
        );

        $selectedBank = $banks[$bank];

        return view('payments.bank-account', compact(
            'repair',
            'selectedBank',
            'bank'
        ));
    }
    /**
    * Show bank transfer verification page.
    */
        public function bankVerification(
            RepairRequest $repair,
            string $bank
    ): View {
        abort_unless(
            $repair->user_id === auth()->id(),
            403
        );

        $repair->load('invoice');

        abort_unless(
            $repair->invoice,
            404
        );

        abort_unless(
            $repair->final_cost !== null,
            403
        );

        abort_unless(
            $repair->status === 'waiting_payment',
            403
        );

        abort_unless(
            $repair->invoice->status !== 'paid',
            403
        );

        $banks = [
        'bca' => [
            'name' => 'Bank Central Asia',
            'short_name' => 'BCA',
        ],

        'mandiri' => [
            'name' => 'Bank Mandiri',
            'short_name' => 'Mandiri',
        ],

        'bni' => [
            'name' => 'Bank Negara Indonesia',
            'short_name' => 'BNI',
        ],
    ];

    abort_unless(
        isset($banks[$bank]),
        404
    );

    $selectedBank = $banks[$bank];

    return view('payments.bank-verification', compact(
        'repair',
        'selectedBank',
        'bank'
    ));
}

/**
 * Process simulated bank transfer payment.
 */
public function processBankTransfer(
    Request $request,
    Invoice $invoice
): RedirectResponse {
    abort_unless(
        $invoice->repairRequest->user_id === auth()->id(),
        403
    );

    $repair = $invoice->repairRequest;

    $bank = $request->validate([
        'bank' => [
            'required',
            'in:bca,mandiri,bni',
        ],
    ])['bank'];

    if ($invoice->status === 'paid') {
        return redirect()
            ->route('repairs.show', $repair)
            ->with('success', 'Invoice ini sudah dibayar.');
    }

    if ($repair->final_cost === null) {
        return back()->withErrors([
            'payment' => 'Final cost belum ditentukan.',
        ]);
    }

    if ($repair->status !== 'waiting_payment') {
        return back()->withErrors([
            'payment' => 'Pembayaran belum tersedia untuk repair ini.',
        ]);
    }

    Payment::create([
        'invoice_id' => $invoice->id,
        'amount' => $invoice->total_amount,
        'payment_method' => $bank,
        'status' => 'paid',
        'paid_at' => now(),
    ]);

    $invoice->update([
        'status' => 'paid',
        'paid_at' => now(),
    ]);

    $repair->update([
        'status' => 'paid',
    ]);

    $repair->repairHistories()->create([
        'status' => 'paid',
        'note' => strtoupper($bank)
            . ' bank transfer payment received for invoice '
            . $invoice->invoice_number
            . '.',
        'created_by' => auth()->id(),
    ]);

    return redirect()
        ->route('repairs.show', $repair)
        ->with('success', 'Pembayaran bank transfer berhasil.');
}
}