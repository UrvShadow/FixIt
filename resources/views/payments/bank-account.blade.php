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
         Account Information
         ======================================== --}}

    <section>

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

                        <h1>
                            Account Information
                        </h1>

                        <p>
                            Transfer the exact amount to the account below.
                        </p>

                    </div>


                    {{-- Bank Identity --}}
                    <div class="bank-account-identity">

                        <div class="bank-account-logo">
                            {{ $selectedBank['short_name'] }}
                        </div>

                        <div>

                            <h2>
                                {{ $selectedBank['name'] }}
                            </h2>

                            <p>
                                Bank Transfer
                            </p>

                        </div>

                    </div>


                    {{-- Account Details --}}
                    <div class="bank-account-details">

                        <div class="bank-account-detail">

                            <span>
                                Account Number
                            </span>

                            <strong>
                                {{ $selectedBank['account_number'] }}
                            </strong>

                        </div>


                        <div class="bank-account-detail">

                            <span>
                                Account Name
                            </span>

                            <strong>
                                {{ $selectedBank['account_name'] }}
                            </strong>

                        </div>


                        <div class="bank-account-detail">

                            <span>
                                Amount
                            </span>

                            <strong>
                                Rp {{ number_format($repair->invoice->total_amount, 0, ',', '.') }}
                            </strong>

                        </div>

                    </div>


                    {{-- Invoice --}}
                    <div class="bank-account-invoice">

                        <span>
                            INVOICE
                        </span>

                        <strong>
                            {{ $repair->invoice->invoice_number }}
                        </strong>

                    </div>


                    {{-- Action --}}
                    <div class="bank-account-actions">

                        <a
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

                    <span>
                        PAYMENT SIMULATION
                    </span>

                    <p>
                        This account information is for simulation purposes only.
                        No real bank transfer will be processed.
                    </p>

                </div>


            </div>

        </div>

    </section>

</body>

</html>