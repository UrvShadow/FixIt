<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FixIT — Repair Made Simple</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    {{-- =========================================================
         NAVBAR
    ========================================================== --}}
    <header class="nav">

        <div class="container">

            <a href="{{ route('home') }}" class="brand">
                <span class="mark">FX</span>
                FixIT
            </a>

            <nav class="nav-links">

                <a href="{{ route('home') }}#home">
                    Home
                </a>

                {{-- Scroll to homepage service catalog --}}
                <a href="{{ route('home') }}#services">
                    Services
                </a>

                <a href="{{ route('home') }}#how-it-works">
                    How It Works
                </a>

                <a href="{{ route('home') }}#tracking">
                    Tracking
                </a>

                <a href="{{ route('home') }}#promo">
                    Promo
                </a>

            </nav>

            <div class="nav-actions">

                @auth

                    <a
                        href="{{ route('dashboard') }}"
                        class="btn -secondary -sm"
                    >
                        Dashboard
                    </a>

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="btn -primary -sm"
                        >
                            Log out
                        </button>
                    </form>

                @else

                    <a
                        href="{{ route('login') }}"
                        class="btn -secondary -sm"
                    >
                        Log in
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="btn -primary -sm"
                    >
                        Get Started
                    </a>

                @endauth

            </div>

            <button
                type="button"
                class="nav-toggle"
                aria-label="Open menu"
                aria-expanded="false"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>

        {{-- Mobile Navigation --}}
        <div class="nav-mobile">

            <a href="{{ route('home') }}#home">
                Home
            </a>

            {{-- Same destination as desktop --}}
            <a href="{{ route('home') }}#services">
                Services
            </a>

            <a href="{{ route('home') }}#how-it-works">
                How It Works
            </a>

            <a href="{{ route('home') }}#tracking">
                Tracking
            </a>

            <a href="{{ route('home') }}#promo">
                Promo
            </a>

            @auth

                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>

                <a href="{{ route('repairs.index') }}">
                    Repairs
                </a>

            @endauth

            <div class="nav-mobile-actions">

                @auth

                    <a
                        href="{{ route('dashboard') }}"
                        class="btn -secondary -sm -block"
                    >
                        Dashboard
                    </a>

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="btn -primary -sm -block"
                        >
                            Log out
                        </button>
                    </form>

                @else

                    <a
                        href="{{ route('login') }}"
                        class="btn -secondary -sm -block"
                    >
                        Log in
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="btn -primary -sm -block"
                    >
                        Get Started
                    </a>

                @endauth

            </div>

        </div>

    </header>


    <main>

        {{-- =====================================================
             HERO
        ====================================================== --}}
        <section class="hero" id="home">

            <div class="container">

                <div class="hero-copy">

                    <span class="section-tag">
                        DIGITAL REPAIR PLATFORM
                    </span>

                    <h1>
                        Repair made simple.
                    </h1>

                    <p>
                        Find the right repair service, submit your request,
                        track its progress, and manage your payment in one place.
                    </p>

                    <div class="hero-actions">

                        <a
                            href="{{ route('home') }}#services"
                            class="btn -primary"
                        >
                            Explore Services
                        </a>

                        @auth

                            <a
                                href="{{ route('repairs.create') }}"
                                class="btn -secondary"
                            >
                                Submit a Repair
                            </a>

                        @else

                            <a
                                href="{{ route('register') }}"
                                class="btn -secondary"
                            >
                                Get Started
                            </a>

                        @endauth

                    </div>

                    <div class="hero-trust">

                        <div class="item">
                            <strong>01</strong>
                            <span>Browse services</span>
                        </div>

                        <div class="item">
                            <strong>02</strong>
                            <span>Submit a request</span>
                        </div>

                        <div class="item">
                            <strong>03</strong>
                            <span>Track progress</span>
                        </div>

                    </div>

                </div>


                {{-- Repair Status Preview --}}
                <div class="ticket">

                    <div class="ticket-top">

                        <div>

                            <div class="label">
                                REPAIR REQUEST
                            </div>

                            <div class="value">
                                #FX-2026-001
                            </div>

                        </div>

                        <span class="stamp -active">
                            <span class="dot"></span>
                            In progress
                        </span>

                    </div>

                    <div class="ticket-device">
                        ASUS Laptop — Screen Repair
                    </div>

                    <div class="ticket-issue">
                        Device repair request currently being processed.
                    </div>

                    <div class="ticket-steps">

                        <div class="tstep -done">
                            <div class="node"></div>
                            <span>Request submitted</span>
                        </div>

                        <div class="tstep -done">
                            <div class="node"></div>
                            <span>Request confirmed</span>
                        </div>

                        <div class="tstep -done">
                            <div class="node"></div>
                            <span>Diagnosis</span>
                        </div>

                        <div class="tstep -active">
                            <div class="node"></div>
                            <span>Repair in progress</span>
                        </div>

                        <div class="tstep -todo">
                            <div class="node"></div>
                            <span>Payment & completion</span>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             SERVICES
        ====================================================== --}}
        <section id="services">

            <div class="container">

                <div class="section-head">

                    <div class="section-tag">
                        SERVICE CATALOG
                    </div>

                    <h2>
                        Find the right repair service
                    </h2>

                    <p>
                        Browse available services, review starting prices,
                        and choose the service that matches your device.
                    </p>

                </div>

                @if ($services->count())

                    <div class="grid-4">

                        @foreach ($services as $service)

                            <article class="svc-card">

                                <div class="svc-icon" aria-hidden="true">

                                    @if (strtolower($service->category) === 'smartphone')

                                        <svg
                                            width="20"
                                            height="20"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                        >
                                            <rect
                                                x="7"
                                                y="2"
                                                width="10"
                                                height="20"
                                                rx="2"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                            />
                                            <line
                                                x1="10"
                                                y1="19"
                                                x2="14"
                                                y2="19"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                            />
                                        </svg>

                                    @elseif (strtolower($service->category) === 'laptop')

                                        <svg
                                            width="20"
                                            height="20"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                        >
                                            <rect
                                                x="3"
                                                y="4"
                                                width="18"
                                                height="12"
                                                rx="1.5"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                            />
                                            <line
                                                x1="2"
                                                y1="19"
                                                x2="22"
                                                y2="19"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                            />
                                        </svg>

                                    @else

                                        <svg
                                            width="20"
                                            height="20"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                        >
                                            <rect
                                                x="4"
                                                y="4"
                                                width="16"
                                                height="16"
                                                rx="2"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                            />
                                            <path
                                                d="M8 9h8M8 13h5"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                                stroke-linecap="round"
                                            />
                                        </svg>

                                    @endif

                                </div>

                                <h3>
                                    {{ $service->name }}
                                </h3>

                                <p>
                                    {{ $service->description }}
                                </p>

                                <div class="svc-meta">

                                    <span class="price">
                                        From Rp {{ number_format($service->starting_price, 0, ',', '.') }}
                                    </span>

                                    <a
                                        href="{{ route('services.show', $service) }}"
                                        class="service-card-link"
                                    >
                                        View
                                        <span aria-hidden="true">→</span>
                                    </a>

                                </div>

                            </article>

                        @endforeach

                    </div>

                    <div class="section-action">

                        <a
                            href="{{ route('services.index') }}"
                            class="btn -secondary"
                        >
                            View All Services
                        </a>

                    </div>

                @else

                    <div class="service-empty">

                        <span class="section-tag">
                            SERVICES
                        </span>

                        <h3>
                            No services available
                        </h3>

                        <p>
                            Our service catalog is currently being updated.
                        </p>

                    </div>

                @endif

            </div>

        </section>


        {{-- =====================================================
             WHY FIXIT
        ====================================================== --}}
        <section id="why-fixit">

            <div class="container">

                <div class="section-head">

                    <div class="section-tag">
                        WHY FIXIT
                    </div>

                    <h2>
                        A clearer way to manage repairs
                    </h2>

                    <p>
                        Keep your devices, repair requests, and payments
                        organized through one platform.
                    </p>

                </div>

                <div class="grid-4">

                    <div class="benefit">

                        <span class="num">
                            01
                        </span>

                        <div>

                            <h3>
                                Easy to use
                            </h3>

                            <p>
                                Browse services and submit a repair request
                                through a straightforward digital process.
                            </p>

                        </div>

                    </div>

                    <div class="benefit">

                        <span class="num">
                            02
                        </span>

                        <div>

                            <h3>
                                Transparent process
                            </h3>

                            <p>
                                Follow your repair request through each
                                stage from confirmation to completion.
                            </p>

                        </div>

                    </div>

                    <div class="benefit">

                        <span class="num">
                            03
                        </span>

                        <div>

                            <h3>
                                Organized records
                            </h3>

                            <p>
                                Keep your devices, repair history, invoices,
                                and payment records in one account.
                            </p>

                        </div>

                    </div>

                    <div class="benefit">

                        <span class="num">
                            04
                        </span>

                        <div>

                            <h3>
                                Convenient
                            </h3>

                            <p>
                                Manage your repair requests and payments
                                without relying on separate records.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             HOW IT WORKS
        ====================================================== --}}
        <section id="how-it-works">

            <div class="container">

                <div class="section-head">

                    <div class="section-tag">
                        PROCESS
                    </div>

                    <h2>
                        How it works
                    </h2>

                    <p>
                        From choosing a service to completing your repair,
                        everything stays in one workflow.
                    </p>

                </div>

                <div class="steps">

                    <div class="step">

                        <div class="step-code">
                            01
                        </div>

                        <h3>
                            Choose a service
                        </h3>

                        <p>
                            Browse the service catalog and choose the repair
                            service that matches your device.
                        </p>

                    </div>

                    <div class="step">

                        <div class="step-code">
                            02
                        </div>

                        <h3>
                            Submit your request
                        </h3>

                        <p>
                            Select your device, describe the issue,
                            and choose your preferred date.
                        </p>

                    </div>

                    <div class="step">

                        <div class="step-code">
                            03
                        </div>

                        <h3>
                            Follow the repair
                        </h3>

                        <p>
                            Track your request as it moves through
                            confirmation, diagnosis, and repair.
                        </p>

                    </div>

                    <div class="step">

                        <div class="step-code">
                            04
                        </div>

                        <h3>
                            Pay & complete
                        </h3>

                        <p>
                            Review the final invoice, complete the payment,
                            and follow the request until completion.
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             TRACKING PREVIEW
        ====================================================== --}}
        <section id="tracking">

            <div class="container">

                <div class="section-head">

                    <div class="section-tag">
                        REPAIR TRACKING
                    </div>

                    <h2>
                        Know where your repair stands
                    </h2>

                    <p>
                        Your repair request moves through a clear status
                        timeline that you can review from your account.
                    </p>

                </div>

                <div class="track-panel">

                    <div class="track-info">

                        <div class="label">
                            REPAIR REQUEST
                        </div>

                        <div class="id">
                            #FX-2026-001
                        </div>

                        <div class="device">
                            ASUS Laptop — Screen Repair
                        </div>

                        <span class="stamp -active">
                            <span class="dot"></span>
                            Repair in progress
                        </span>

                        <div class="track-info-action">

                            @auth

                                <a
                                    href="{{ route('repairs.index') }}"
                                    class="btn -primary"
                                >
                                    View Your Repairs
                                </a>

                            @else

                                <a
                                    href="{{ route('login') }}"
                                    class="btn -primary"
                                >
                                    Log In to Track
                                </a>

                            @endauth

                        </div>

                    </div>

                    <div class="progress-rail">

                        <div class="prow -done">
                            Request submitted
                        </div>

                        <div class="prow -done">
                            Request confirmed
                        </div>

                        <div class="prow -done">
                            Diagnosis
                        </div>

                        <div class="prow -active">
                            Repair in progress
                        </div>

                        <div class="prow -todo">
                            Waiting for payment
                        </div>

                        <div class="prow -todo">
                            Completed
                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             ACCOUNT CTA
        ====================================================== --}}
        <section id="promo">

            <div class="container">

                <div class="promo-banner">

                    <div class="promo-copy">

                        <div class="tag">
                            Limited-time offer
                        </div>

                        <h2>
                            Get 20% off your first repair request
                        </h2>

                        <p>
                            New to FixIT? Your first repair request comes with a free inspection and 20% off the service cost
                        </p>

                    </div>

                    
                  <div class="promo-cta">
                  @auth
                    <a
                        href="{{ route('services.index') }}"
                        class="btn -primary"
                    >
                        Claim Promo
                    </a>
                  @else
                    <a
                        href="{{ route('login') }}"
                        class="btn -primary"
                    >
                        Claim Promo
                    </a>
                  @endauth
                </div>
                </div>

            </div>

        </section>


        {{-- =====================================================
             FINAL CTA
        ====================================================== --}}
        <section class="final-cta">

            <div class="container">

                <h2>
                    Need something fixed?
                </h2>

                <p>
                    Find the right service and manage your repair
                    from request to completion with FixIT.
                </p>

                <div class="hero-actions">

                    <a
                        href="{{ route('services.index') }}"
                        class="btn -primary"
                    >
                        Explore Services
                    </a>

                    @auth

                        <a
                            href="{{ route('repairs.create') }}"
                            class="btn -secondary"
                        >
                            Submit a Repair
                        </a>

                    @else

                        <a
                            href="{{ route('register') }}"
                            class="btn -secondary"
                        >
                            Create an Account
                        </a>

                    @endauth

                </div>

            </div>

        </section>

    </main>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}
    <footer class="footer">

        <div class="container">

            <div class="footer-top">

                <div class="footer-brand">

                    <a
                        href="{{ route('home') }}"
                        class="brand"
                    >
                        <span class="mark">FX</span>
                        FixIT
                    </a>

                    <p>
                        Making repair services simpler,
                        clearer, and easier to manage.
                    </p>

                </div>

                <div class="footer-col">

                    <h4>
                        Navigation
                    </h4>

                    <a href="{{ route('home') }}#home">
                        Home
                    </a>

                    <a href="{{ route('home') }}#services">
                        Services
                    </a>

                    <a href="{{ route('home') }}#how-it-works">
                        How It Works
                    </a>

                    <a href="{{ route('home') }}#tracking">
                        Tracking
                    </a>

                    <a href="{{ route('home') }}#promo">
                        Promo
                    </a>

                    @auth

                        <a href="{{ route('dashboard') }}">
                            Dashboard
                        </a>

                        <a href="{{ route('repairs.index') }}">
                            Repairs
                        </a>

                    @endauth

                </div>

                <div class="footer-col">

                    <h4>
                        Account
                    </h4>

                    @auth

                        <a href="{{ route('dashboard') }}">
                            Dashboard
                        </a>

                        <a href="{{ route('repairs.index') }}">
                            My Repairs
                        </a>

                    @else

                        <a href="{{ route('login') }}">
                            Log in
                        </a>

                        <a href="{{ route('register') }}">
                            Register
                        </a>

                    @endauth

                </div>

                <div class="footer-col">

                    <h4>
                        Contact
                    </h4>

                    <span>
                        support@fixit.app
                    </span>

                    <span>
                        +62 888-0190-2244
                    </span>

                    <span>
                        @fixit.app
                    </span>

                </div>

            </div>

            <div class="footer-bottom">

                <span>
                    © {{ date('Y') }} FixIT. All rights reserved.
                </span>

                <span>
                    Repair Made Simple
                </span>

            </div>

        </div>

    </footer>


    <script src="{{ asset('js/script.js') }}"></script>

</body>

</html>