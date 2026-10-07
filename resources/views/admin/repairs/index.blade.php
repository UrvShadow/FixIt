<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Repair Requests — Admin — FixIT</title>

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

    {{-- Navbar --}}
    <header class="nav">

        <div class="container">

            <a
                href="{{ route('home') }}"
                class="brand"
            >
                <span class="mark">FX</span>FixIT Admin
            </a>

            <nav class="nav-links">

                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>

                <a
                    href="{{ route('admin.services.index') }}"
                    class="active"
                >
                    Services
                </a>

                <a href="{{ route('admin.repairs.index') }}">
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

        <section class="admin-repair-list">

            <div class="container">


                {{-- Header --}}
                <div class="admin-repair-list-head">

                    <div>

                        <span class="section-tag">
                            ADMINISTRATION
                        </span>

                        <h1>
                            Repair Requests
                        </h1>

                        <p>
                            Review customer repair requests and manage
                            their service progress.
                        </p>

                    </div>

                    <div class="admin-repair-count">

                        <span>
                            TOTAL REQUESTS
                        </span>

                        <strong>
                            {{ $repairRequests->count() }}
                        </strong>

                    </div>

                </div>


                {{-- Repair List --}}
                @if ($repairRequests->count())

                    <div class="admin-repair-list-grid">

                        @foreach ($repairRequests as $repair)

                            <article class="admin-repair-list-card">


                                {{-- Card Header --}}
                                <div class="admin-repair-list-card-head">

                                    <div>

                                        <div class="admin-repair-card-meta">

                                            <span class="ticket-code">
                                                REPAIR #{{ $repair->id }}
                                            </span>

                                            <span class="admin-repair-card-device-code">
                                                {{ $repair->device->device_code }}
                                            </span>

                                        </div>

                                        <h2>
                                            {{ $repair->device->name }}
                                        </h2>

                                    </div>

                                    <span
                                        class="status-badge status-{{ $repair->status }}"
                                    >
                                        {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                                    </span>

                                </div>


                                {{-- Customer + Service --}}
                                <div class="admin-repair-list-info">

                                    <div>

                                        <span>
                                            CUSTOMER
                                        </span>

                                        <strong>
                                            {{ $repair->user->name }}
                                        </strong>

                                    </div>

                                    <div>

                                        <span>
                                            SERVICE
                                        </span>

                                        <strong>
                                            {{ $repair->service?->name ?? 'General Repair' }}
                                        </strong>

                                    </div>

                                </div>


                                {{-- Preferred Date --}}
                                <div class="admin-repair-list-date">

                                    <span>
                                        PREFERRED DATE
                                    </span>

                                    <strong>

                                        @if ($repair->preferred_date)

                                            {{ $repair->preferred_date->format('d M Y') }}

                                        @else

                                            —

                                        @endif

                                    </strong>

                                </div>


                                {{-- Issue --}}
                                <div class="admin-repair-list-issue">

                                    <span>
                                        REPORTED ISSUE
                                    </span>

                                    <p>
                                        {{ \Illuminate\Support\Str::limit($repair->issue, 120) }}
                                    </p>

                                </div>


                                {{-- Footer --}}
                                <div class="admin-repair-list-footer">

                                    <div>

                                        <span>
                                            SUBMITTED
                                        </span>

                                        <strong>
                                            {{ $repair->created_at->format('d M Y, H:i') }}
                                        </strong>

                                    </div>

                                    <a
                                        href="{{ route('admin.repairs.show', $repair) }}"
                                        class="admin-repair-view"
                                    >
                                        Manage
                                        <span>→</span>
                                    </a>

                                </div>


                            </article>

                        @endforeach

                    </div>

                @else

                    {{-- Empty State --}}
                    <div class="admin-repair-list-empty">

                        <span class="section-tag">
                            REPAIR REQUESTS
                        </span>

                        <h2>
                            No repair requests yet
                        </h2>

                        <p>
                            Customer repair requests will appear here
                            once they submit a service request.
                        </p>

                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="btn -secondary"
                        >
                            ← Admin Dashboard
                        </a>

                    </div>

                @endif


            </div>

        </section>

    </main>

</body>

</html>