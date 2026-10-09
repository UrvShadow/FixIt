<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $service->name }} — FixIT</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    {{-- Navbar --}}
    <header class="nav">
        <div class="container">

            <a href="{{ route('home') }}" class="brand">
                <span class="mark">FX</span>
                FixIT
            </a>

            <nav class="nav-links">
                <a href="{{ route('home') }}">Home</a>

                <a href="{{ route('services.index') }}" class="active">
                    Services
                </a>

                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('devices.index') }}">Devices</a>
                    <a href="{{ route('repairs.index') }}">Repairs</a>
                @endauth
            </nav>

            <div class="nav-actions">

                @auth

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="btn -secondary -sm">
                            Log out
                        </button>
                    </form>

                @else

                    <a href="{{ route('login') }}" class="btn -secondary -sm">
                        Log in
                    </a>

                    <a href="{{ route('register') }}" class="btn -primary -sm">
                        Get Started
                    </a>

                @endauth

            </div>

        </div>
    </header>


    {{-- Service Detail --}}
    <main>

        <section class="service-detail">

            <div class="container">

                <a
                    href="{{ route('services.index') }}"
                    class="service-detail-back"
                >
                    <span aria-hidden="true">←</span>
                    All Services
                </a>


                <div class="service-detail-layout">

                    {{-- Main Content --}}
                    <div class="service-detail-main">

                        <span class="section-tag">
                            {{ strtoupper($service->category) }}
                        </span>

                        <h1>
                            {{ $service->name }}
                        </h1>

                        <p class="service-detail-description">
                            {{ $service->description }}
                        </p>


                        {{-- Service Information --}}
                        <div class="service-detail-section">

                            <span class="service-detail-label">
                                SERVICE INFORMATION
                            </span>

                            <div class="service-detail-info">

                                <div class="service-detail-info-row">
                                    <span>
                                        Category
                                    </span>

                                    <strong>
                                        {{ $service->category }}
                                    </strong>
                                </div>

                                <div class="service-detail-info-row">
                                    <span>
                                        Starting price
                                    </span>

                                    <strong>
                                        Rp {{ number_format($service->starting_price, 0, ',', '.') }}
                                    </strong>
                                </div>

                                <div class="service-detail-info-row">
                                    <span>
                                        Availability
                                    </span>

                                    <strong class="service-detail-available">
                                        Available
                                    </strong>
                                </div>

                            </div>

                        </div>


                        {{-- How It Works --}}
                        <div class="service-detail-section">

                            <span class="service-detail-label">
                                HOW IT WORKS
                            </span>

                            <div class="service-detail-steps">

                                <div class="service-detail-step">

                                    <span>
                                        01
                                    </span>

                                    <div>
                                        <strong>
                                            Submit Request
                                        </strong>

                                        <p>
                                            Choose your device and describe
                                            the issue you are experiencing.
                                        </p>
                                    </div>

                                </div>


                                <div class="service-detail-step">

                                    <span>
                                        02
                                    </span>

                                    <div>
                                        <strong>
                                            Diagnosis
                                        </strong>

                                        <p>
                                            Your repair request is reviewed
                                            and the reported issue is diagnosed.
                                        </p>
                                    </div>

                                </div>


                                <div class="service-detail-step">

                                    <span>
                                        03
                                    </span>

                                    <div>
                                        <strong>
                                            Repair
                                        </strong>

                                        <p>
                                            The repair process is carried out
                                            based on the diagnosis and service.
                                        </p>
                                    </div>

                                </div>


                                <div class="service-detail-step">

                                    <span>
                                        04
                                    </span>

                                    <div>
                                        <strong>
                                            Payment & Completion
                                        </strong>

                                        <p>
                                            Complete the payment process and
                                            track your repair until completion.
                                        </p>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Sidebar --}}
                    <aside class="service-detail-sidebar">

                        <div class="service-detail-card">

                            <span class="service-detail-label">
                                STARTING FROM
                            </span>

                            <strong class="service-detail-price">
                                Rp {{ number_format($service->starting_price, 0, ',', '.') }}
                            </strong>

                            <p>
                                Final cost may vary depending on the
                                diagnosis and required repair.
                            </p>


                            @auth

                                <a
                                    href="{{ route('repairs.create', ['service' => $service->slug]) }}"
                                    class="btn -primary service-detail-book"
                                >
                                    Book This Service
                                </a>

                            @else

                                <a
                                    href="{{ route('login') }}"
                                    class="btn -primary service-detail-book"
                                >
                                    Log in to Book
                                </a>

                                <p class="service-detail-login-note">
                                    Don't have an account?
                                    <a href="{{ route('register') }}">
                                        Create one
                                    </a>
                                </p>

                            @endauth

                        </div>


                        <div class="service-detail-note">

                            <span>
                                FIXIT SERVICE
                            </span>

                            <p>
                                All repair requests can be monitored
                                through your FixIT account.
                            </p>

                        </div>

                    </aside>

                </div>

            </div>

        </section>

    </main>

</body>

</html>