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
    public function index(): View
    {
        $repairRequests = RepairRequest::with(['user', 'device', 'service'])
            ->latest()
            ->get();

        return view('admin.repairs.index', compact('repairRequests'));
    }

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

    public function updateStatus(
    Request $request,
    RepairRequest $repair
): RedirectResponse {
    $validated = $request->validate([
        'status' => [
            'required',
            'in:pending,confirmed,diagnosing,repairing,waiting_payment,paid,completed,rejected,cancelled',
        ],
        'note' => ['nullable', 'string', 'max:5000'],
        'estimated_cost' => ['nullable', 'numeric', 'min:0'],
        'final_cost' => ['nullable', 'numeric', 'min:0'],
    ]);

    $currentStatus = $repair->status;
    $newStatus = $validated['status'];

    $allowedTransitions = [
        'pending' => ['confirmed', 'rejected', 'cancelled'],
        'confirmed' => ['diagnosing', 'rejected', 'cancelled'],
        'diagnosing' => ['repairing', 'rejected', 'cancelled'],
        'repairing' => ['waiting_payment', 'rejected', 'cancelled'],
        'waiting_payment' => ['paid', 'rejected', 'cancelled'],
        'paid' => ['completed'],
        'completed' => [],
        'rejected' => [],
        'cancelled' => [],
    ];

    if (
        $newStatus !== $currentStatus &&
        ! in_array($newStatus, $allowedTransitions[$currentStatus] ?? [], true)
    ) {
        return back()->withErrors([
            'status' => "Status tidak dapat diubah dari {$currentStatus} menjadi {$newStatus}.",
        ]);
    }

    $repair->update([
        'status' => $newStatus,
        'estimated_cost' => $validated['estimated_cost'] ?? $repair->estimated_cost,
        'final_cost' => $validated['final_cost'] ?? $repair->final_cost,
    ]);

    $repair->repairHistories()->create([
        'status' => $newStatus,
        'note' => $validated['note'] ?? null,
        'created_by' => auth()->id(),
    ]);

    return redirect()
        ->route('admin.repairs.show', $repair)
        ->with('success', 'Repair status berhasil diperbarui.');

    }
    public function createInvoice(RepairRequest $repair): RedirectResponse
    {
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
        'invoice_number' => 'INV-' . now()->format('YmdHis') . '-' . $repair->id,
        'total_amount' => $repair->final_cost,
        'status' => 'unpaid',
        'issued_at' => now(),
    ]);

    return back()->with('success', 'Invoice berhasil dibuat.');
    }
}