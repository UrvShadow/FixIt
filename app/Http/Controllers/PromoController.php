<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Promo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function apply(
        Request $request,
        Invoice $invoice
    ): RedirectResponse {
        // Pastikan invoice milik user yang sedang login.
        abort_unless(
            $invoice->repairRequest->user_id === auth()->id(),
            403
        );

        // Promo hanya bisa diterapkan sebelum pembayaran selesai.
        if ($invoice->status === 'paid') {
            return back()->withErrors([
                'promo' => 'Promo tidak dapat diterapkan pada invoice yang sudah dibayar.',
            ]);
        }

        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
            ],
        ]);

        $code = strtoupper(
            trim($validated['code'])
        );

        $promo = Promo::where('code', $code)->first();

        if (! $promo) {
            return back()->withErrors([
                'promo' => 'Kode promo tidak ditemukan.',
            ]);
        }

        if (! $promo->is_active) {
            return back()->withErrors([
                'promo' => 'Kode promo sudah tidak aktif.',
            ]);
        }

        if (
            $promo->expires_at !== null &&
            $promo->expires_at->isPast()
        ) {
            return back()->withErrors([
                'promo' => 'Kode promo sudah kedaluwarsa.',
            ]);
        }

        $subtotal = (float) $invoice->subtotal_amount;

        if (
            $subtotal < (float) $promo->minimum_transaction
        ) {
            return back()->withErrors([
                'promo' =>
                    'Minimum transaksi untuk promo ini adalah Rp' .
                    number_format(
                        $promo->minimum_transaction,
                        0,
                        ',',
                        '.'
                    ) .
                    '.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Calculate Discount
        |--------------------------------------------------------------------------
        */

        if ($promo->discount_type === 'percentage') {
            $discount = $subtotal
                * ((float) $promo->discount_value / 100);
        } else {
            $discount = (float) $promo->discount_value;
        }

        // Discount tidak boleh melebihi subtotal.
        $discount = min(
            $discount,
            $subtotal
        );

        $total = $subtotal - $discount;

        /*
        |--------------------------------------------------------------------------
        | Update Invoice
        |--------------------------------------------------------------------------
        */

        $invoice->update([
            'promo_id' => $promo->id,
            'promo_code' => $promo->code,
            'discount_amount' => $discount,
            'total_amount' => $total,
        ]);

        return back()->with(
            'success',
            'Promo ' . $promo->code . ' berhasil diterapkan.'
        );
    }
}