<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    /**
     * Generate invoice PDF.
     */
    public function download(Invoice $invoice): Response
    {
        $invoice->load([
            'repairRequest.user',
            'repairRequest.device',
            'payments',
            'promo',
        ]);

        abort_unless(
            $invoice->repairRequest->user_id === auth()->id(),
            403
        );

        abort_unless(
            $invoice->status === 'paid',
            403
        );

        $pdf = Pdf::loadView(
            'invoices.pdf',
            compact('invoice')
        );

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download(
            $invoice->invoice_number . '.pdf'
        );
    }
}