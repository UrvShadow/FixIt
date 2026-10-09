<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Choose Payment — FixIT</title>

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('favicon.png') }}"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/style.css') }}"
    >
</head>

<body>


    {{-- Minimal Payment Header --}}
    <header class="nav payment-nav">
        <div class="container">

            {{-- Static Brand: No Navigation Link --}}
            <div class="brand" aria-label="FixIT">
                <span class="mark" aria-hidden="true">FX</span>FixIT
            </div>

            <span class="payment-nav-context">
                PAYMENT
            </span>

        </div>
    </header>



    {{-- Payment --}}
    <section>

        <div class="container">

            <div class="payment-page">


                {{-- Header --}}
                <div class="payment-page-head">

                    <a
                        href="{{ route('repairs.show', $repair) }}"
                        class="btn -ghost -sm"
                    >
                        ← Back to Repair
                    </a>

                    <div class="section-tag">
                        Payment
                    </div>

                    <h1>
                        Choose Payment Method
                    </h1>

                    <p>
                        Select how you would like to pay for your repair service.
                    </p>

                </div>


                {{-- Invoice Summary --}}
                <div class="payment-summary">

                    <div>

                        <span class="ticket-code">
                            REPAIR #{{ $repair->id }}
                        </span>

                        <h2>
                            {{ $repair->device->name }}
                        </h2>

                        <p>
                            {{ $repair->device->device_code }}
                        </p>

                    </div>

                    <div class="payment-summary-amount">

                        <span>
                            Amount Due
                        </span>

                        <strong>
                            Rp {{ number_format($repair->invoice->total_amount, 0, ',', '.') }}
                        </strong>

                    </div>

                </div>


                {{-- Promo --}}
                <div class="payment-promo-section">

                    <div class="section-tag">
                        Promotion
                    </div>

                    <h2>
                        Have a promo code?
                    </h2>

                    <p class="payment-promo-description">
                        Apply an eligible promo code before continuing to payment.
                    </p>


                    @if ($errors->has('promo'))

                        <div class="payment-promo-error">
                            {{ $errors->first('promo') }}
                        </div>

                    @endif


                    @if (session('success'))

                        <div class="payment-promo-success">
                            {{ session('success') }}
                        </div>

                    @endif


                    <form
                        action="{{ route('invoices.promo.apply', $repair->invoice) }}"
                        method="POST"
                        class="payment-promo-form"
                    >
                        @csrf

                        <input
                            type="text"
                            name="code"
                            value="{{ old('code') }}"
                            placeholder="Enter promo code"
                            maxlength="50"
                            autocomplete="off"
                            required
                        >

                        <button
                            type="submit"
                            class="btn -primary"
                        >
                            Apply
                        </button>

                    </form>

                </div>


                {{-- Price Breakdown --}}
                <div class="payment-price-breakdown">

                    <div class="payment-price-row">

                        <span>
                            Subtotal
                        </span>

                        <strong>
                            Rp {{ number_format($repair->invoice->subtotal_amount, 0, ',', '.') }}
                        </strong>

                    </div>


                    @if ($repair->invoice->promo_code)

                        <div class="payment-price-row payment-promo-row">

                            <span>
                                Promo
                                <strong>
                                    {{ $repair->invoice->promo_code }}
                                </strong>
                            </span>

                            <strong>
                                -Rp {{ number_format($repair->invoice->discount_amount, 0, ',', '.') }}
                            </strong>

                        </div>

                    @endif


                    <div class="payment-price-divider"></div>


                    <div class="payment-price-row payment-total-row">

                        <span>
                            Total
                        </span>

                        <strong>
                            Rp {{ number_format($repair->invoice->total_amount, 0, ',', '.') }}
                        </strong>

                    </div>

                </div>


                {{-- Payment Methods --}}
                <div class="payment-method-section">

                    <div class="section-tag">
                        Available Methods
                    </div>

                    <h2>
                        Select a payment method
                    </h2>


                    <div class="payment-method-grid">


                        {{-- QRIS --}}
                        <a
                            href="{{ route('payments.qris', $repair) }}"
                            class="payment-method-card"
                        >

                            <div class="payment-method-icon">
                                QR
                            </div>

                            <div class="payment-method-content">

                                <h3>
                                    QRIS
                                </h3>

                                <p>
                                    Scan a QR code using your mobile banking or
                                    supported e-wallet application.
                                </p>

                            </div>

                            <span class="payment-method-arrow">
                                →
                            </span>

                        </a>


                        {{-- Bank Transfer --}}
                        <a
                            href="{{ route('payments.bank-transfer', $repair) }}"
                            class="payment-method-card"
                        >

                            <div class="payment-method-icon">
                                BT
                            </div>

                            <div class="payment-method-content">

                                <h3>
                                    Bank Transfer
                                </h3>

                                <p>
                                    Transfer the payment through one of our
                                    supported bank accounts.
                                </p>

                            </div>

                            <span class="payment-method-arrow">
                                →
                            </span>

                        </a>


                    </div>


                    {{-- Notice --}}
                    <div class="payment-method-note">

                        <span>
                            PAYMENT SIMULATION
                        </span>

                        <p>
                            This payment process is a simulation for the FixIT
                            service system. No real financial transaction will
                            be processed.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

</body>

</html>