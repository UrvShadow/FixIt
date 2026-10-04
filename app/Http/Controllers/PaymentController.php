<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Invoice $invoice): RedirectResponse
    {
        abort_unless(
            $invoice->repairRequest->user_id === auth()->id(),
            403
        );

        if ($invoice->status === 'paid') {
            return back()->withErrors([
                'payment' => 'Invoice ini sudah dibayar.',
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

$invoice->repairRequest->update([
    'status' => 'paid',
]);

$invoice->repairRequest->repairHistories()->create([
    'status' => 'paid',
    'note' => 'Payment received for invoice ' . $invoice->invoice_number . '.',
    'created_by' => auth()->id(),
]);

        return back()->with('success', 'Pembayaran berhasil dicatat.');
    }
}