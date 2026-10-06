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

    {{-- ========================================
         Navbar
         ======================================== --}}

    <header class="nav">

        <div class="container">

            <a href="{{ route('home') }}" class="brand">
                <span class="mark">FX</span>FixIT
            </a>

            <nav class="nav-links">

                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>

                <a href="{{ route('devices.index') }}">
                    Devices
                </a>

                <a href="{{ route('repairs.index') }}">
                    Repairs
                </a>

            </nav>

            <div class="nav-actions">

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button
                        type="submit"
                        class="btn -secondary -sm"
                    >
                        Log out
                    </button>

                </form>

            </div>

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

                        <div>
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

                        <div class="bank-transfer-amount">

                            <span>
                                Amount to Pay
                            </span>

                            <strong>
                                Rp {{ number_format($repair->invoice->total_amount, 0, ',', '.') }}
                            </strong>

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


                    {{-- Simulation Notice --}}
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
