<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Payment Verification — FixIT</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

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


    <section>

        <div class="container">

            <div class="payment-page bank-verification-page">

                <div class="bank-verification-card">


                    {{-- Status --}}
                    <div class="bank-verification-status">

                        <div class="bank-verification-spinner">
                            <span></span>
                        </div>

                        <div class="section-tag">
                            PAYMENT VERIFICATION
                        </div>

                    </div>


                    {{-- Header --}}
                    <div class="payment-page-head">

                        <h1>
                            Verifying Your Payment
                        </h1>

                        <p>
                            We're verifying your
                            {{ $selectedBank['short_name'] }}
                            bank transfer.
                        </p>

                    </div>


                    {{-- Payment Information --}}
                    <div class="bank-verification-info">

                        <div>

                            <span>
                                INVOICE
                            </span>

                            <strong>
                                {{ $repair->invoice->invoice_number }}
                            </strong>

                        </div>

                        <div>

                            <span>
                                PAYMENT METHOD
                            </span>

                            <strong>
                                {{ $selectedBank['short_name'] }} Bank Transfer
                            </strong>

                        </div>

                        <div>

                            <span>
                                AMOUNT
                            </span>

                            <strong>
                                Rp {{ number_format($repair->invoice->total_amount, 0, ',', '.') }}
                            </strong>

                        </div>

                    </div>


                    {{-- Verification Form --}}
                    <form
                        action="{{ route('payments.bank-transfer.verify', $repair->invoice) }}"
                        method="POST"
                        class="bank-verification-form"
                    >

                        @csrf

                        <input
                            type="hidden"
                            name="bank"
                            value="{{ $bank }}"
                        >

                        <p>
                            Click the button below to complete the
                            simulated verification process.
                        </p>

                        <button
                            type="submit"
                            class="btn -primary"
                        >
                            Complete Verification
                        </button>

                    </form>


                    <div class="payment-method-note">

                        <span>
                            PAYMENT SIMULATION
                        </span>

                        <p>
                            No real bank transaction is being verified.
                            This step simulates successful payment verification.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

</body>

</html>