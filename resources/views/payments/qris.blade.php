<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>QRIS Payment — FixIT</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    {{-- Minimal Payment Header --}}
    <header class="nav payment-nav">
        <div class="container">

            <div class="brand" aria-label="FixIT">
                <span class="mark" aria-hidden="true">FX</span>FixIT
            </div>

            <span class="payment-nav-context">
                SECURE CHECKOUT
            </span>

        </div>
    </header>


    {{-- QRIS Payment Page --}}
    <main class="payment-qris-page">

        <div class="container">

            {{-- Back --}}
            <a
                href="{{ route('payments.create', $repair) }}"
                class="btn -ghost -sm qris-back"
            >
                ← Payment Methods
            </a>


            @php
                $invoice = $repair->invoice;
                $paymentExpiresAt = $invoice->payment_expires_at;

                $qrisSessionActive =
                    $invoice->payment_method_pending === 'qris'
                    && $paymentExpiresAt !== null
                    && $paymentExpiresAt->isFuture();
            @endphp


            {{-- QRIS Payment Card --}}
            <section class="qris-payment-card">

                {{-- Header --}}
                <div class="payment-page-head">

                    <div class="section-tag">
                        QRIS PAYMENT
                    </div>

                    <h1>Scan to Pay</h1>

                    <p>
                        Use your preferred banking or e-wallet application
                        to scan the simulated payment code.
                    </p>

                </div>


                {{-- Repair / Invoice Information --}}
                <div class="qris-payment-info">

                    <div class="qris-payment-reference">
                        <span class="ticket-code">
                            REPAIR #{{ $repair->id }}
                        </span>

                        <span class="qris-invoice-label">
                            {{ $invoice->invoice_number }}
                        </span>
                    </div>

                    <h2>{{ $repair->device->name }}</h2>

                    <p>
                        Device code: {{ $repair->device->device_code }}
                    </p>

                </div>


                {{-- Payment Session Countdown --}}
                @if ($errors->has('payment'))
                    <div class="payment-session-error" role="alert">
                        {{ $errors->first('payment') }}
                    </div>
                @endif

                <div
                    class="payment-countdown {{ $qrisSessionActive ? '' : 'is-expired' }}"
                    data-payment-countdown
                    data-expires-at="{{ $paymentExpiresAt?->timestamp ?? '' }}"
                    data-format="minutes"
                    data-button-target="#qris-paid-button"
                    data-warning-message="Less than five minutes remain."
                    data-expired-message="This QRIS session has expired. Return to Payment Methods to start a new session."
                    role="status"
                    aria-live="polite"
                >
                    <div class="payment-countdown-copy">

                        <span>TIME LEFT TO PAY</span>

                        <p
                            class="payment-countdown-message"
                            data-countdown-message
                        >
                            @if ($qrisSessionActive)
                                Complete the payment before this session expires.
                            @else
                                This payment session has expired. Return to Payment Methods to start a new session.
                            @endif
                        </p>

                    </div>

                    <strong
                    class="payment-countdown-value"
                    data-countdown-value
                >
                    {{ $qrisSessionActive ? '--:--' : '00:00' }}
                </strong>

                </div>


                {{-- Simulated QR Code --}}
                <div class="qris-code-wrapper">

                    <div
                        class="qris-code"
                        role="img"
                        aria-label="Decorative simulated QR pattern. This is not a scannable payment code."
                    >

                        <div class="qris-pattern" aria-hidden="true">

                            @for ($row = 0; $row < 21; $row++)
                                @for ($col = 0; $col < 21; $col++)

                                    @php
                                        $inTopLeft = $row < 7 && $col < 7;
                                        $inTopRight = $row < 7 && $col >= 14;
                                        $inBottomLeft = $row >= 14 && $col < 7;

                                        $inFinder = $inTopLeft || $inTopRight || $inBottomLeft;

                                        if ($inFinder) {
                                            $finderRow = $row >= 14 ? $row - 14 : $row;
                                            $finderCol = $col >= 14 ? $col - 14 : $col;

                                            $moduleIsFilled =
                                                $finderRow === 0
                                                || $finderRow === 6
                                                || $finderCol === 0
                                                || $finderCol === 6
                                                || (
                                                    $finderRow >= 2
                                                    && $finderRow <= 4
                                                    && $finderCol >= 2
                                                    && $finderCol <= 4
                                                );
                                        } else {
                                            $moduleIsFilled =
                                                (($row * 7 + $col * 11 + $row * $col * 3) % 13) < 6;
                                        }
                                    @endphp

                                    <span class="{{ $moduleIsFilled ? 'is-filled' : '' }}"></span>

                                @endfor
                            @endfor

                        </div>

                    </div>

                    <span class="qris-simulated">
                        SIMULATED QRIS · NOT SCANNABLE
                    </span>

                    <p class="qris-code-caption">
                        Payment reference for demonstration purposes only.
                    </p>

                </div>


                {{-- Price Breakdown --}}
                <div class="qris-price-breakdown">

                    <div class="qris-price-row">

                        <span>Subtotal</span>

                        <strong>
                            Rp {{ number_format($invoice->subtotal_amount, 0, ',', '.') }}
                        </strong>

                    </div>

                    @if ($invoice->promo_code)

                        <div class="qris-price-row qris-promo-row">

                            <span>
                                Promo {{ $invoice->promo_code }}
                            </span>

                            <strong>
                                −Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}
                            </strong>

                        </div>

                    @endif

                    <div class="qris-price-divider"></div>

                    <div class="qris-price-row qris-total-row">

                        <span>Amount to Pay</span>

                        <strong>
                            Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}
                        </strong>

                    </div>

                </div>


                {{-- Simulation Notice --}}
                <div class="payment-method-note qris-simulation-notice">

                    <span>PAYMENT SIMULATION</span>

                    <p>
                        This is a simulated payment flow for FixIT.
                        No real QRIS transaction will be processed.
                    </p>

                </div>


                {{-- Confirmation --}}
                <form
                    action="{{ route('payments.qris.process', $invoice) }}"
                    method="POST"
                    class="qris-confirmation-form"
                >
                    @csrf

                    <button
                        type="submit"
                        id="qris-paid-button"
                        class="btn -primary qris-paid-button"
                        {{ $qrisSessionActive ? '' : 'disabled' }}
                    >
                        Confirm Simulated Payment
                    </button>

                    <p class="qris-confirmation-help">
                        Confirmation will mark this invoice as paid
                        in the demonstration system.
                    </p>

                </form>

            </section>

        </div>

    </main>


    {{-- Payment Countdown --}}
    <script src="{{ asset('js/payment-countdown.js') }}" defer></script>

</body>
</html>