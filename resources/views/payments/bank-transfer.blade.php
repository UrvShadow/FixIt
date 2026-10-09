<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bank Transfer — FixIT</title>

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


    {{-- ========================================
         Bank Transfer Page
         ======================================== --}}

    <section>

        <div class="container">

            <div class="payment-page bank-transfer-page">


                {{-- Back --}}
                <a
                    href="{{ route('payments.create', $repair) }}"
                    class="btn -ghost -sm bank-transfer-back"
                >
                    ← Payment Methods
                </a>


                {{-- ========================================
                     Main Card
                     ======================================== --}}

                <div class="bank-transfer-card">


                    {{-- Header --}}
                    <div class="payment-page-head">

                        <div class="section-tag">
                            BANK TRANSFER
                        </div>

                        <h1>
                            Choose Your Bank
                        </h1>

                        <p>
                            Select the bank you want to use
                            for your payment.
                        </p>

                    </div>


                    {{-- ========================================
                         Invoice Summary
                         ======================================== --}}

                    <div class="bank-transfer-summary">

                        <div class="bank-transfer-repair-info">

                            <span class="ticket-code">
                                REPAIR #{{ $repair->id }}
                            </span>

                            <h2>
                                {{ $repair->device->name }}
                            </h2>

                            <p>
                                {{ $repair->invoice->invoice_number }}
                            </p>

                        </div>


                        {{-- ========================================
                             Payment Summary
                             ======================================== --}}

                        <div class="bank-transfer-price-breakdown">

                            <div class="bank-transfer-summary-title">
                                Payment Summary
                            </div>

                            <div class="bank-transfer-price-row">

                                <span>
                                    Subtotal
                                </span>

                                <strong>
                                    Rp {{ number_format($repair->invoice->subtotal_amount, 0, ',', '.') }}
                                </strong>

                            </div>


                            @if ($repair->invoice->promo_code)

                                <div class="bank-transfer-price-row bank-transfer-promo-row">

                                    <span>
                                        Promo {{ $repair->invoice->promo_code }}
                                    </span>

                                    <strong>
                                        -Rp {{ number_format($repair->invoice->discount_amount, 0, ',', '.') }}
                                    </strong>

                                </div>

                            @endif


                            <div class="bank-transfer-price-divider"></div>


                            <div class="bank-transfer-price-row bank-transfer-total-row">

                                <span>
                                    Amount to Pay
                                </span>

                                <strong>
                                    Rp {{ number_format($repair->invoice->total_amount, 0, ',', '.') }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- ========================================
                         Bank Options
                         ======================================== --}}

                    <div class="bank-transfer-section">

                        <h2>
                            Select Bank
                        </h2>

                        <div class="bank-transfer-grid">


                            {{-- BCA --}}
                            <a
                                href="{{ route('payments.bank-account', [$repair, 'bca']) }}"
                                class="bank-option"
                            >

                                <div class="bank-option-icon">
                                    BCA
                                </div>

                                <div class="bank-option-content">

                                    <h3>
                                        BCA
                                    </h3>

                                    <p>
                                        Transfer using BCA
                                    </p>

                                </div>

                                <span class="bank-option-arrow">
                                    →
                                </span>

                            </a>


                            {{-- Mandiri --}}
                            <a
                                href="{{ route('payments.bank-account', [$repair, 'mandiri']) }}"
                                class="bank-option"
                            >

                                <div class="bank-option-icon">
                                    M
                                </div>

                                <div class="bank-option-content">

                                    <h3>
                                        Mandiri
                                    </h3>

                                    <p>
                                        Transfer using Mandiri
                                    </p>

                                </div>

                                <span class="bank-option-arrow">
                                    →
                                </span>

                            </a>


                            {{-- BNI --}}
                            <a
                                href="{{ route('payments.bank-account', [$repair, 'bni']) }}"
                                class="bank-option"
                            >

                                <div class="bank-option-icon">
                                    BNI
                                </div>

                                <div class="bank-option-content">

                                    <h3>
                                        BNI
                                    </h3>

                                    <p>
                                        Transfer using BNI
                                    </p>

                                </div>

                                <span class="bank-option-arrow">
                                    →
                                </span>

                            </a>


                        </div>

                    </div>


                    {{-- ========================================
                         Simulation Notice
                         ======================================== --}}

                    <div class="payment-method-note">

                        <span>
                            PAYMENT SIMULATION
                        </span>

                        <p>
                            This bank transfer flow is simulated.
                            No real bank transaction will be processed.
                        </p>

                    </div>


                </div>

            </div>

        </div>

    </section>

</body>

</html>