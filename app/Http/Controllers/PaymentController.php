<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\RepairRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Show the payment method selection page.
     */
    public function create(RepairRequest $repair): View
    {
        $this->ensurePaymentAvailable($repair, true);

        // Clean up an expired or inconsistent session.
        $this->clearInvalidOrExpiredPaymentSession(
            $repair->invoice
        );

        return view('payments.create', compact('repair'));
    }


    /**
     * Show the QRIS payment page.
     */
    public function qris(
        RepairRequest $repair
    ): View|RedirectResponse {
        $this->ensurePaymentAvailable($repair, true);

        // Do not silently restart an expired session on refresh.
        if (
            $this->clearInvalidOrExpiredPaymentSession(
                $repair->invoice
            )
        ) {
            return redirect()
                ->route('payments.create', $repair)
                ->with('payment_session_expired', true);
        }

        // QRIS sessions last 30 minutes.
        $this->startPaymentSession(
            $repair->invoice,
            'qris',
            30
        );

        // Send the server-side deadline to the Blade view.
        $paymentExpiresAt = $repair->invoice->payment_expires_at;

        return view(
            'payments.qris',
            compact('repair', 'paymentExpiresAt')
        );
    }


    /**
     * Process simulated QRIS payment.
     */
    public function processQris(
        Request $request,
        Invoice $invoice
    ): RedirectResponse {
        $invoice->loadMissing('repairRequest');

        $repair = $invoice->repairRequest;

        abort_unless(
            $repair !== null
            && $repair->user_id === auth()->id(),
            403
        );

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

        if (! $this->hasActivePaymentSession($invoice, 'qris')) {
            $this->clearInvalidOrExpiredPaymentSession($invoice);

            return redirect()
                ->route('payments.create', $repair)
                ->with('payment_session_expired', true);
        }

        $result = $this->completeSimulatedPayment(
            $invoice,
            'qris',
            'QRIS payment received for invoice '
                . $invoice->invoice_number
                . '.'
        );

        if ($result === 'already_paid') {
            return redirect()
                ->route('repairs.show', $repair)
                ->with('success', 'Invoice ini sudah dibayar.');
        }

        if ($result === 'expired') {
            $this->clearInvalidOrExpiredPaymentSession($invoice);

            return redirect()
                ->route('payments.create', $repair)
                ->with('payment_session_expired', true);
        }

        if ($result === 'unavailable') {
            return redirect()
                ->route('repairs.show', $repair)
                ->withErrors([
                    'payment' => 'Pembayaran belum tersedia untuk repair ini.',
                ]);
        }

        return redirect()
            ->route('repairs.show', $repair)
            ->with('success', 'Pembayaran QRIS berhasil.');
    }


    /**
     * Show the bank transfer selection page.
     *
     * Selecting a bank transfer method does not start the timer.
     * The 24-hour session starts on the bank account page.
     */
    public function bankTransfer(
        RepairRequest $repair
    ): View {
        $this->ensurePaymentAvailable($repair);

        $this->clearInvalidOrExpiredPaymentSession(
            $repair->invoice
        );

        return view('payments.bank-transfer', compact('repair'));
    }


    /**
     * Show bank account information.
     */
    public function bankAccount(
        RepairRequest $repair,
        string $bank
    ): View|RedirectResponse {
        $this->ensurePaymentAvailable($repair);

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

        abort_unless(isset($banks[$bank]), 404);

        // An expired session must go back through bank selection.
        if (
            $this->clearInvalidOrExpiredPaymentSession(
                $repair->invoice
            )
        ) {
            return redirect()
                ->route('payments.bank-transfer', $repair)
                ->with('payment_session_expired', true);
        }

        // Start or preserve the 24-hour bank transfer session.
        $this->startPaymentSession(
            $repair->invoice,
            'bank_transfer',
            24 * 60
        );

        $selectedBank = $banks[$bank];
        $paymentExpiresAt = $repair->invoice->payment_expires_at;

        return view(
            'payments.bank-account',
            compact(
                'repair',
                'selectedBank',
                'bank',
                'paymentExpiresAt'
            )
        );
    }


    /**
     * Show bank transfer verification page.
     *
     * This page must not start or reset a payment session.
     */
    public function bankVerification(
        RepairRequest $repair,
        string $bank
    ): View|RedirectResponse {
        $this->ensurePaymentAvailable($repair);

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

        abort_unless(isset($banks[$bank]), 404);

        // Verification is allowed only during an active bank session.
        if (
            ! $this->hasActivePaymentSession(
                $repair->invoice,
                'bank_transfer'
            )
        ) {
            $sessionExpired = $this->clearInvalidOrExpiredPaymentSession(
                $repair->invoice
            );

            $redirect = redirect()
                ->route('payments.bank-transfer', $repair);

            if ($sessionExpired) {
                return $redirect->with(
                    'payment_session_expired',
                    true
                );
            }

            return $redirect->withErrors([
                'payment' =>
                    'Please select a bank and open its account information before verification.',
            ]);
        }

        $selectedBank = $banks[$bank];

        return view(
            'payments.bank-verification',
            compact('repair', 'selectedBank', 'bank')
        );
    }


    /**
     * Process simulated bank transfer payment.
     */
    public function processBankTransfer(
        Request $request,
        Invoice $invoice
    ): RedirectResponse {
        $invoice->loadMissing('repairRequest');

        $repair = $invoice->repairRequest;

        abort_unless(
            $repair !== null
            && $repair->user_id === auth()->id(),
            403
        );

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

        $validated = $request->validate([
            'bank' => [
                'required',
                'in:bca,mandiri,bni',
            ],
        ]);

        if (
            ! $this->hasActivePaymentSession(
                $invoice,
                'bank_transfer'
            )
        ) {
            $this->clearInvalidOrExpiredPaymentSession($invoice);

            return redirect()
                ->route('payments.create', $repair)
                ->with('payment_session_expired', true);
        }

        $bank = $validated['bank'];

        $result = $this->completeSimulatedPayment(
            $invoice,
            $bank,
            strtoupper($bank)
                . ' bank transfer payment received for invoice '
                . $invoice->invoice_number
                . '.',
            'bank_transfer'
        );

        if ($result === 'already_paid') {
            return redirect()
                ->route('repairs.show', $repair)
                ->with('success', 'Invoice ini sudah dibayar.');
        }

        if ($result === 'expired') {
            $this->clearInvalidOrExpiredPaymentSession($invoice);

            return redirect()
                ->route('payments.create', $repair)
                ->with('payment_session_expired', true);
        }

        if ($result === 'unavailable') {
            return redirect()
                ->route('repairs.show', $repair)
                ->withErrors([
                    'payment' => 'Pembayaran belum tersedia untuk repair ini.',
                ]);
        }

        return redirect()
            ->route('repairs.show', $repair)
            ->with('success', 'Pembayaran bank transfer berhasil.');
    }


    /**
     * Confirm that the user owns the repair and its invoice is payable.
     */
    private function ensurePaymentAvailable(
        RepairRequest $repair,
        bool $loadDevice = false
    ): void {
        abort_unless(
            $repair->user_id === auth()->id(),
            403
        );

        if ($loadDevice) {
            $repair->load([
                'invoice',
                'device',
            ]);
        } else {
            $repair->load('invoice');
        }

        abort_unless($repair->invoice, 404);

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
    }


    /**
     * Start a payment session or preserve its existing deadline.
     *
     * Calling this method for the same active method never resets
     * the countdown. Expired sessions are handled by the caller.
     */
    private function startPaymentSession(
        Invoice $invoice,
        string $method,
        int $durationMinutes
    ): void {
        if (
            $invoice->payment_method_pending === $method
            && $invoice->payment_expires_at !== null
            && $invoice->payment_expires_at->isFuture()
        ) {
            return;
        }

        $invoice->forceFill([
            'payment_method_pending' => $method,
            'payment_expires_at' => now()->addMinutes($durationMinutes),
        ])->save();
    }


    /**
     * Check a session against the saved method and deadline.
     */
    private function hasActivePaymentSession(
        Invoice $invoice,
        string $method
    ): bool {
        return $invoice->payment_method_pending === $method
            && $invoice->payment_expires_at !== null
            && $invoice->payment_expires_at->isFuture();
    }


    /**
     * Clear expired, incomplete, or unrecognized session data.
     *
     * Valid session methods are "qris" and "bank_transfer".
     * Returns true when session data was cleared.
     */
    private function clearInvalidOrExpiredPaymentSession(
        Invoice $invoice
    ): bool {
        $method = $invoice->payment_method_pending;
        $expiresAt = $invoice->payment_expires_at;

        // There is no session data to clear.
        if ($method === null && $expiresAt === null) {
            return false;
        }

        $validMethods = [
            'qris',
            'bank_transfer',
        ];

        $sessionIsValid = in_array(
            $method,
            $validMethods,
            true
        )
            && $expiresAt !== null
            && $expiresAt->isFuture();

        if ($sessionIsValid) {
            return false;
        }

        $invoice->forceFill([
            'payment_method_pending' => null,
            'payment_expires_at' => null,
        ])->save();

        return true;
    }


    /**
     * Complete a simulated payment atomically.
     */
    private function completeSimulatedPayment(
        Invoice $invoice,
        string $method,
        string $historyNote,
        ?string $sessionMethod = null
    ): string {
        // QRIS defaults to the "qris" session.
        // Bank transfers explicitly pass "bank_transfer".
        $sessionMethod ??= $method;

        return DB::transaction(function () use (
            $invoice,
            $method,
            $historyNote,
            $sessionMethod
        ): string {
            $lockedInvoice = Invoice::query()
                ->whereKey($invoice->id)
                ->lockForUpdate()
                ->firstOrFail();

            $repair = $lockedInvoice->repairRequest()
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedInvoice->status === 'paid') {
                return 'already_paid';
            }

            if (
                $repair->final_cost === null
                || $repair->status !== 'waiting_payment'
            ) {
                return 'unavailable';
            }

            // Recheck the deadline inside the transaction.
            if (
                ! $this->hasActivePaymentSession(
                    $lockedInvoice,
                    $sessionMethod
                )
            ) {
                return 'expired';
            }

            $paidAt = now();

            // Store the actual payment method: qris, bca, mandiri, or bni.
            Payment::create([
                'invoice_id' => $lockedInvoice->id,
                'amount' => $lockedInvoice->total_amount,
                'payment_method' => $method,
                'status' => 'paid',
                'paid_at' => $paidAt,
            ]);

            $lockedInvoice->forceFill([
                'status' => 'paid',
                'paid_at' => $paidAt,
                'payment_method_pending' => null,
                'payment_expires_at' => null,
            ])->save();

            $repair->update([
                'status' => 'paid',
            ]);

            $repair->repairHistories()->create([
                'status' => 'paid',
                'note' => $historyNote,
                'created_by' => auth()->id(),
            ]);

            return 'completed';
        });
    }
}