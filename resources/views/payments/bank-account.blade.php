<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $selectedBank['short_name'] }} Transfer — FixIT</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    @php
        $paymentDeadline = $paymentExpiresAt ?? $repair->invoice->payment_expires_at;
    @endphp

    {{-- Minimal Secure Checkout Header --}}
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


    {{-- Account Information --}}
    <section class="bank-account-section">
        <div class="container">

            <div class="payment-page bank-account-page">

                {{-- Back --}}
                <a
                    href="{{ route('payments.bank-transfer', $repair) }}"
                    class="btn -ghost -sm bank-account-back"
                >
                    ← Choose Bank
                </a>


                {{-- Main Card --}}
                <div class="bank-account-card">

                    {{-- Header --}}
                    <div class="payment-page-head">

                        <div class="section-tag">
                            {{ $selectedBank['short_name'] }} TRANSFER
                        </div>

                        <h1>Account Information</h1>

                        <p>
                            Transfer the exact amount to the account below.
                        </p>

                    </div>


                    {{-- Payment Countdown --}}
                    <div
                        class="bank-account-countdown payment-countdown"
                        data-payment-countdown
                        data-expires-at="{{ $paymentDeadline?->timestamp ?? '' }}"
                        data-format="hours"
                        data-button-target="#bank-transfer-confirm"
                        data-warning-message="Less than five minutes remain. Please complete the simulation soon."
                        data-expired-message="This payment session has expired. Return to payment methods to start again."
                    >
                        <div class="bank-account-countdown-info">
                            <span class="bank-account-countdown-label">
                                TIME REMAINING
                            </span>

                            <p class="bank-account-countdown-description">
                                Complete this payment simulation before the session expires.
                            </p>
                        </div>

                        <strong
                            class="payment-countdown-value"
                            aria-live="polite"
                        >
                            --:--:--
                        </strong>

                        <p
                            class="payment-countdown-message"
                            aria-live="polite"
                        >
                            Your transfer session is active.
                        </p>
                    </div>


                    {{-- Bank Identity --}}
                    <div class="bank-account-identity">

                        <div class="bank-account-logo">
                            {{ $selectedBank['short_name'] }}
                        </div>

                        <div>
                            <h2>{{ $selectedBank['name'] }}</h2>
                            <p>Bank Transfer</p>
                        </div>

                    </div>


                    {{-- Account Details --}}
                    <div class="bank-account-details">

                        <div class="bank-account-detail">
                            <span>Account Number</span>

                            <strong>
                                {{ $selectedBank['account_number'] }}
                            </strong>
                        </div>

                        <div class="bank-account-detail">
                            <span>Account Name</span>

                            <strong>
                                {{ $selectedBank['account_name'] }}
                            </strong>
                        </div>

                    </div>


                    {{-- Payment Summary --}}
                    <div class="bank-account-payment-summary">

                        <div class="bank-account-summary-title">
                            Payment Summary
                        </div>

                        <div class="bank-account-summary-row">
                            <span>Subtotal</span>

                            <strong>
                                Rp {{ number_format($repair->invoice->subtotal_amount, 0, ',', '.') }}
                            </strong>
                        </div>

                        @if ($repair->invoice->promo_code)
                            <div class="bank-account-summary-row bank-account-promo">
                                <span>
                                    Promo {{ $repair->invoice->promo_code }}
                                </span>

                                <strong>
                                    -Rp {{ number_format($repair->invoice->discount_amount, 0, ',', '.') }}
                                </strong>
                            </div>
                        @endif

                        <div class="bank-account-summary-divider"></div>

                        <div class="bank-account-summary-row bank-account-total">
                            <span>Amount to Transfer</span>

                            <strong>
                                Rp {{ number_format($repair->invoice->total_amount, 0, ',', '.') }}
                            </strong>
                        </div>

                    </div>


                    {{-- Invoice --}}
                    <div class="bank-account-invoice">
                        <span>INVOICE</span>

                        <strong>
                            {{ $repair->invoice->invoice_number }}
                        </strong>
                    </div>


                    {{-- Actions --}}
                    <div class="bank-account-actions">

                        <a
                            id="bank-transfer-confirm"
                            href="{{ route('payments.bank-verification', [$repair, $bank]) }}"
                            class="btn -primary"
                        >
                            I've Made the Transfer
                        </a>

                        <a
                            href="{{ route('payments.bank-transfer', $repair) }}"
                            class="btn -ghost"
                        >
                            Choose Another Bank
                        </a>

                    </div>

                </div>


                {{-- Simulation Notice --}}
                <div class="payment-method-note">
                    <span>PAYMENT SIMULATION</span>

                    <p>
                        This account information is for simulation purposes only.
                        No real bank transfer will be processed.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <script src="{{ asset('js/payment-countdown.js') }}" defer></script>

</body>
</html>