<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Services — FixIT</title>

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
                <a href="{{ route('services.index') }}" class="active">Services</a>

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


    {{-- Service Catalog --}}
    <main>

        <section class="service-catalog">

            <div class="container">

                <div class="service-catalog-head">

                    <div>

                        <span class="section-tag">
                            OUR SERVICES
                        </span>

                        <h1>
                            Professional Repair<br>
                            Services for Your Devices
                        </h1>

                        <p>
                            Get reliable repair and maintenance services
                            for your laptop, PC, smartphone, and other devices.
                        </p>

                    </div>

                </div>


                {{-- Service Search --}}
                <form
                    action="{{ route('services.index') }}"
                    method="GET"
                    class="service-search"
                >

                    <label for="service-search">
                        Search services
                    </label>

                    <div class="service-search-row">

                        <input
                            type="search"
                            id="service-search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search by service, category, or keyword..."
                            autocomplete="off"
                        >

                        <button type="submit" class="btn -primary">
                            Search
                        </button>

                        @if ($search !== '')
                            <a
                                href="{{ route('services.index') }}"
                                class="btn -secondary"
                            >
                                Clear
                            </a>
                        @endif

                    </div>

                </form>


                @if ($search !== '')

                    <div class="service-search-result">

                        <span class="section-tag">
                            SEARCH RESULTS
                        </span>

                        <p>
                            Showing results for
                            <strong>"{{ $search }}"</strong>
                        </p>

                    </div>

                @endif


                @if ($services->count())

                    <div class="service-catalog-grid">

                        @foreach ($services as $service)

                            <article class="service-card">

                                <div class="service-card-top">

                                    <span class="service-card-category">
                                        {{ strtoupper($service->category) }}
                                    </span>

                                    <span
                                        class="service-card-number"
                                        aria-hidden="true"
                                    >
                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                    </span>

                                </div>


                                <div class="service-card-body">

                                    <h2>
                                        {{ $service->name }}
                                    </h2>

                                    <p>
                                        {{ $service->description }}
                                    </p>

                                </div>


                                <div class="service-card-footer">

                                    <div class="service-card-price">

                                        <span>
                                            Starting from
                                        </span>

                                        <strong>
                                            Rp {{ number_format($service->starting_price, 0, ',', '.') }}
                                        </strong>

                                    </div>

                                    <a
                                        href="{{ route('services.show', $service) }}"
                                        class="service-card-link"
                                    >
                                        View Service
                                        <span aria-hidden="true">→</span>
                                    </a>

                                </div>

                            </article>

                        @endforeach

                    </div>

                @else

                    <div class="service-empty">

                        <span class="section-tag">
                            @if ($search !== '')
                                NO RESULTS
                            @else
                                SERVICES
                            @endif
                        </span>

                        <h2>
                            @if ($search !== '')
                                No matching services found
                            @else
                                No services available
                            @endif
                        </h2>

                        <p>
                            @if ($search !== '')
                                We couldn't find a service matching
                                <strong>"{{ $search }}"</strong>.
                                Try another keyword or browse the full catalog.
                            @else
                                Our service catalog is currently being updated.
                            @endif
                        </p>

                        @if ($search !== '')

                            <a
                                href="{{ route('services.index') }}"
                                class="btn -secondary"
                            >
                                Browse All Services
                            </a>

                        @endif

                    </div>

                @endif

            </div>

        </section>

    </main>

</body>

</html>