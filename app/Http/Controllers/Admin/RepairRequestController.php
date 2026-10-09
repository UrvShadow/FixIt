<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\RepairRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RepairRequestController extends Controller
{
    /**
     * Display, search, filter, sort, and paginate repair requests.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],

            'status' => [
                'nullable',
                'in:pending,confirmed,diagnosing,repairing,waiting_payment,paid,completed,rejected,cancelled',
            ],

            'sort' => [
                'nullable',
                'in:newest,oldest,preferred_soon,preferred_late,status,cost_high,cost_low',
            ],
        ]);

        $search = trim($validated['search'] ?? '');
        $status = $validated['status'] ?? '';
        $sort = $validated['sort'] ?? 'newest';

        $query = RepairRequest::query()
            ->with([
                'user',
                'device',
                'service',
            ]);

        /*
         * Search by repair ID, customer name/email,
         * device name/code, service name, or reported issue.
         */
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $term = '%' . $search . '%';

                if (ctype_digit($search)) {
                    $q->orWhere('id', (int) $search);
                }

                $q->orWhereHas('user', function ($userQuery) use ($term) {
                    $userQuery
                        ->where('name', 'like', $term)
                        ->orWhere('email', 'like', $term);
                });

                $q->orWhereHas('device', function ($deviceQuery) use ($term) {
                    $deviceQuery
                        ->where('name', 'like', $term)
                        ->orWhere('device_code', 'like', $term);
                });

                $q->orWhereHas('service', function ($serviceQuery) use ($term) {
                    $serviceQuery
                        ->where('name', 'like', $term);
                });

                $q->orWhere('issue', 'like', $term);
            });
        }

        /*
         * Filter by repair status.
         */
        if ($status !== '') {
            $query->where('status', $status);
        }

        /*
         * Sorting options.
         */
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at')
                    ->orderBy('id');
                break;

            case 'preferred_soon':
                $query->orderByRaw(
                    'CASE WHEN preferred_date IS NULL THEN 1 ELSE 0 END'
                )
                    ->orderBy('preferred_date')
                    ->orderByDesc('created_at');
                break;

            case 'preferred_late':
                $query->orderByRaw(
                    'CASE WHEN preferred_date IS NULL THEN 1 ELSE 0 END'
                )
                    ->orderByDesc('preferred_date')
                    ->orderByDesc('created_at');
                break;

            case 'status':
                $query->orderByRaw("
                    CASE status
                        WHEN 'pending' THEN 1
                        WHEN 'confirmed' THEN 2
                        WHEN 'diagnosing' THEN 3
                        WHEN 'repairing' THEN 4
                        WHEN 'waiting_payment' THEN 5
                        WHEN 'paid' THEN 6
                        WHEN 'completed' THEN 7
                        WHEN 'rejected' THEN 8
                        WHEN 'cancelled' THEN 9
                        ELSE 10
                    END
                ")
                    ->orderByDesc('created_at');
                break;

            case 'cost_high':
                $query->orderByRaw(
                    'CASE WHEN final_cost IS NULL THEN 1 ELSE 0 END'
                )
                    ->orderByDesc('final_cost')
                    ->orderByDesc('created_at');
                break;

            case 'cost_low':
                $query->orderByRaw(
                    'CASE WHEN final_cost IS NULL THEN 1 ELSE 0 END'
                )
                    ->orderBy('final_cost')
                    ->orderByDesc('created_at');
                break;

            case 'newest':
            default:
                $query->orderByDesc('created_at')
                    ->orderByDesc('id');
                break;
        }

        $repairRequests = $query
            ->paginate(12)
            ->withQueryString();

        return view('admin.repairs.index', compact(
            'repairRequests',
            'search',
            'status',
            'sort'
        ));
    }


    /**
     * Show repair details.
     */
    public function show(RepairRequest $repair): View
    {
        $repair->load([
            'user',
            'device',
            'service',
            'repairHistories.createdBy',
        ]);

        return view('admin.repairs.show', compact('repair'));
    }


    /**
     * Update repair status and record its history.
     */
    public function updateStatus(
        Request $request,
        RepairRequest $repair
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,confirmed,diagnosing,repairing,waiting_payment,paid,completed,rejected,cancelled',
            ],

            'note' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'estimated_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'final_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ]);

        $currentStatus = $repair->status;
        $newStatus = $validated['status'];

        $allowedTransitions = [
            'pending' => [
                'confirmed',
                'rejected',
                'cancelled',
            ],

            'confirmed' => [
                'diagnosing',
                'rejected',
                'cancelled',
            ],

            'diagnosing' => [
                'repairing',
                'rejected',
                'cancelled',
            ],

            'repairing' => [
                'waiting_payment',
                'rejected',
                'cancelled',
            ],

            'waiting_payment' => [
                'paid',
                'rejected',
                'cancelled',
            ],

            'paid' => [
                'completed',
            ],

            'completed' => [],
            'rejected' => [],
            'cancelled' => [],
        ];

        if (
            $newStatus !== $currentStatus
            && ! in_array(
                $newStatus,
                $allowedTransitions[$currentStatus] ?? [],
                true
            )
        ) {
            return back()->withErrors([
                'status' => "Status tidak dapat diubah dari {$currentStatus} menjadi {$newStatus}.",
            ]);
        }

        $repair->update([
            'status' => $newStatus,

            'estimated_cost' =>
                $validated['estimated_cost']
                ?? $repair->estimated_cost,

            'final_cost' =>
                $validated['final_cost']
                ?? $repair->final_cost,
        ]);

        $repair->repairHistories()->create([
            'status' => $newStatus,
            'note' => $validated['note'] ?? null,
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.repairs.show', $repair)
            ->with(
                'success',
                'Repair status berhasil diperbarui.'
            );
    }


    /**
     * Create an invoice for a repair.
     */
    public function createInvoice(
        RepairRequest $repair
    ): RedirectResponse {
        if ($repair->final_cost === null) {
            return back()->withErrors([
                'invoice' => 'Final cost belum ditentukan.',
            ]);
        }

        if ($repair->invoice()->exists()) {
            return back()->withErrors([
                'invoice' => 'Invoice untuk repair ini sudah dibuat.',
            ]);
        }

        Invoice::create([
            'repair_request_id' => $repair->id,

            'invoice_number' =>
                'INV-'
                . now()->format('YmdHis')
                . '-'
                . $repair->id,

            'subtotal_amount' => $repair->final_cost,
            'discount_amount' => 0,
            'total_amount' => $repair->final_cost,
            'status' => 'unpaid',
            'issued_at' => now(),
        ]);

        return back()->with(
            'success',
            'Invoice berhasil dibuat.'
        );
    }
}