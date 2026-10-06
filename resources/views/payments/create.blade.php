<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Choose Payment — FixIT</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    {{-- Navbar --}}
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
                            Rp {{ number_format($repair->final_cost, 0, ',', '.') }}
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
