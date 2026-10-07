<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Service Management — Admin — FixIT</title>

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

<header class="nav">
    <div class="container">

        <a href="{{ route('home') }}" class="brand">
            <span class="mark">FX</span>
            FixIT Admin
        </a>

        <nav class="nav-links">
            <a href="{{ route('admin.dashboard') }}">
                Dashboard
            </a>

            <a href="{{ route('admin.services.index') }}">
                Services
            </a>

            <a
                href="{{ route('admin.repairs.index') }}"
                class="active"
            >
                Repairs
            </a>
        </nav>

        <div class="nav-actions">

            <form
                action="{{ route('logout') }}"
                method="POST"
            >
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

<main>

<section class="admin-service-list">

    <div class="container">

        {{-- Header --}}

        <div class="admin-service-head">

            <div>

                <span class="section-tag">
                    ADMINISTRATION
                </span>

                <h1>
                    Service Management
                </h1>

                <p>
                    Manage the repair and maintenance services
                    offered through the FixIT platform.
                </p>

            </div>

            <a
                href="{{ route('admin.services.create') }}"
                class="btn -primary"
            >
                + Add Service
            </a>

        </div>

        {{-- Success Message --}}

        @if (session('success'))

            <div class="admin-service-success">
                {{ session('success') }}
            </div>

        @endif

        {{-- Service Grid --}}

        @if ($services->count())

            <div class="admin-service-grid">

                @foreach ($services as $service)

                    <article class="admin-service-card">

                        {{-- Card Header --}}

                        <div class="admin-service-card-head">

                            <div>

                                <span class="admin-service-category">
                                    {{ strtoupper($service->category) }}
                                </span>

                                <span class="admin-service-number">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </span>

                            </div>


<form
    action="{{ route('admin.services.toggle', $service) }}"
    method="POST"
    class="admin-service-status-form"
>
    @csrf
    @method('PATCH')

    @if ($service->is_active)

        <button
            type="submit"
            class="admin-service-status -active"
            title="Click to deactivate this service"
        >
            <i></i>
            ACTIVE
        </button>

    @else

        <button
            type="submit"
            class="admin-service-status -inactive"
            title="Click to activate this service"
        >
            <i></i>
            INACTIVE
        </button>

    @endif

</form>

                        </div>

                        {{-- Card Body --}}

                        <div class="admin-service-card-body">

                            <h2>
                                {{ $service->name }}
                            </h2>

                            <p>
                                {{ $service->description }}
                            </p>

                        </div>

                        {{-- Card Footer --}}

                        <div class="admin-service-card-footer">

                            <div class="admin-service-price">

                                <span>
                                    STARTING FROM
                                </span>

                                <strong>
                                    Rp {{ number_format($service->starting_price, 0, ',', '.') }}
                                </strong>

                            </div>

                            <a
                                href="{{ route('admin.services.edit', $service) }}"
                                class="admin-service-edit"
                            >
                                Edit
                                <span>→</span>
                            </a>

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            <div class="admin-service-empty">

                <span class="section-tag">
                    SERVICES
                </span>

                <h2>
                    No services available
                </h2>

                <p>
                    Create your first service to make it
                    available through the FixIT platform.
                </p>

                <a
                    href="{{ route('admin.services.create') }}"
                    class="btn -primary"
                >
                    Add First Service
                </a>

            </div>

        @endif

    </div>

</section>

</main>

</body>
</html>