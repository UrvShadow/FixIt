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
         QRIS Payment Page
         ======================================== --}}

    <section>

        <div class="container">

            <div class="payment-page payment-qris-page">


                {{-- Back --}}
                <a
                    href="{{ route('payments.create', $repair) }}"
                    class="btn -ghost -sm qris-back"
                >
                    ← Payment Methods
                </a>


                {{-- ========================================
                     QRIS Payment Card
                     ======================================== --}}

                <div class="qris-payment-card">


                    {{-- Payment Header --}}
                    <div class="payment-page-head">

                        <div class="section-tag">
                            QRIS
                        </div>

                        <h1>
                            Scan to Pay
                        </h1>

                        <p>
                            Scan the QR code below using your preferred
                            banking or e-wallet application.
                        </p>

                    </div>


                    {{-- ========================================
                         Repair / Invoice Information
                         ======================================== --}}

                    <div class="qris-payment-info">

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
                         QR Code
                         ======================================== --}}

                    <div class="qris-code-wrapper">

                        <div class="qris-code">

                            <div class="qris-pattern">

                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>

                            </div>

                        </div>

                        <span class="qris-simulated">
                            SIMULATED QRIS
                        </span>

                    </div>


                    {{-- ========================================
                         Amount
                         ======================================== --}}

                    <div class="qris-amount">

                        <span>
                            Amount to Pay
                        </span>

                        <strong>
                            Rp {{ number_format($repair->invoice->total_amount, 0, ',', '.') }}
                        </strong>

                    </div>


                    {{-- ========================================
                         Actions
                         ======================================== --}}

                    <div class="qris-actions">

                        <form
                            action="{{ route('payments.qris.process', $repair->invoice) }}"
                            method="POST"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="btn -primary"
                            >
                                I've Paid
                            </button>

                        </form>

                        <a
                            href="{{ route('payments.create', $repair) }}"
                            class="btn -ghost"
                        >
                            Choose Another Method
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
                        This QR code is a simulated payment reference.
                        No real QRIS transaction will be processed.
                    </p>

                </div>

            </div>

        </div>

    </section>

</body>

</html>