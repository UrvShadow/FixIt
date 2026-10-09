<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Promo Management — FixIT</title>

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

            <a
                href="{{ route('home') }}"
                class="brand"
            >
                <span class="mark">FX</span>FixIT
            </a>

            <nav class="nav-links">

                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.services.index') }}">
                    Services
                </a>

                <a href="{{ route('admin.repairs.index') }}">
                    Repairs
                </a>

                <a
                    href="{{ route('admin.promos.index') }}"
                    class="active"
                >
                    Promos
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

        <section class="admin-promo-list">

            <div class="container">

                <div class="admin-promo-list-head">

                    <div>

                        <div class="section-tag">
                            ADMINISTRATION
                        </div>

                        <h1>
                            Promo Management
                        </h1>

                        <p>
                            Manage promotional offers and discount codes
                            available to FixIT customers.
                        </p>

                    </div>

                    <a
                        href="{{ route('admin.promos.create') }}"
                        class="btn -primary"
                    >
                        + Add Promo
                    </a>

                </div>

                @if (session('success'))

                    <div class="admin-promo-success">
                        {{ session('success') }}
                    </div>

                @endif

                @if ($promos->count())

                    <div class="admin-promo-list-grid">

                        @foreach ($promos as $index => $promo)

                            <article class="admin-promo-card">

                                <div class="admin-promo-card-head">

                                    <div>

                                        <div class="admin-promo-card-meta">

                                            <span class="promo-code">
                                                PROMO #{{ $index + 1 }}
                                            </span>

                                            <span class="promo-type">
                                                {{ strtoupper($promo->discount_type) }}
                                            </span>

                                        </div>

                                        <h2>
                                            {{ $promo->code }}
                                        </h2>

                                    </div>

                                    <form
                                        action="{{ route('admin.promos.toggle', $promo) }}"
                                        method="POST"
                                        class="admin-promo-status-form"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        @if ($promo->is_active)

                                            <button
                                                type="submit"
                                                class="admin-promo-status -active"
                                                title="Click to deactivate this promo"
                                            >
                                                <i></i>
                                                ACTIVE
                                            </button>

                                        @else

                                            <button
                                                type="submit"
                                                class="admin-promo-status -inactive"
                                                title="Click to activate this promo"
                                            >
                                                <i></i>
                                                INACTIVE
                                            </button>

                                        @endif

                                    </form>

                                </div>

                                <div class="admin-promo-discount">

                                    @if ($promo->discount_type === 'percentage')

                                        <strong>
                                            {{ rtrim(rtrim(number_format($promo->discount_value, 2, ',', '.'), '0'), ',') }}%
                                        </strong>

                                        <span>
                                            DISCOUNT
                                        </span>

                                    @else

                                        <strong>
                                            Rp {{ number_format($promo->discount_value, 0, ',', '.') }}
                                        </strong>

                                        <span>
                                            DISCOUNT
                                        </span>

                                    @endif

                                </div>

                                <div class="admin-promo-info">

                                    <div>

                                        <span>
                                            MINIMUM TRANSACTION
                                        </span>

                                        <strong>
                                            @if ($promo->minimum_transaction > 0)
                                                Rp {{ number_format($promo->minimum_transaction, 0, ',', '.') }}
                                            @else
                                                No minimum
                                            @endif
                                        </strong>

                                    </div>

                                    <div>

                                        <span>
                                            EXPIRES
                                        </span>

                                        <strong>

                                            @if ($promo->expires_at)

                                                {{ $promo->expires_at->format('d M Y H:i') }}

                                            @else

                                                No expiration

                                            @endif

                                        </strong>

                                    </div>

                                </div>

                                <div class="admin-promo-footer">

                                    <div>

                                        <span>
                                            STATUS
                                        </span>

                                        <strong>
                                            {{ $promo->is_active ? 'Available for customers' : 'Not available' }}
                                        </strong>

                                    </div>

                                    <a
                                        href="{{ route('admin.promos.edit', $promo) }}"
                                        class="admin-promo-edit"
                                    >
                                        Edit
                                        <span>→</span>
                                    </a>

                                </div>

                            </article>

                        @endforeach

                    </div>

                @else

                    <div class="admin-promo-empty">

                        <div class="section-tag">
                            PROMOTIONS
                        </div>

                        <h2>
                            No promos yet
                        </h2>

                        <p>
                            Create your first promotional code to offer
                            discounts to FixIT customers.
                        </p>

                        <a
                            href="{{ route('admin.promos.create') }}"
                            class="btn -primary"
                        >
                            Create First Promo
                        </a>

                    </div>

                @endif

            </div>

        </section>

    </main>

</body>

</html>