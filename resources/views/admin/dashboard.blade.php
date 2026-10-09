<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Dashboard — FixIT</title>

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

    {{-- ========================================
         Admin Navigation
         ======================================== --}}

    <header class="nav">

        <div class="container">

            <a
                class="brand"
            >
                <span class="mark">FX</span>
                FixIT Admin
            </a>

            <nav class="nav-links">

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="active"
                    aria-current="page"
                >
                    Dashboard
                </a>

                <a href="{{ route('admin.services.index') }}">
                    Services
                </a>

                <a href="{{ route('admin.repairs.index') }}">
                    Repairs
                </a>

                <a href="{{ route('admin.promos.index') }}">
                    Promos
                </a>

                <a href="{{ route('admin.financial-reports') }}">
                    Financial Reports
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


    {{-- ========================================
         Dashboard
         ======================================== --}}

    <main>

        <section class="admin-dashboard">

            <div class="container">


                {{-- ========================================
                     Hero
                     ======================================== --}}

                <div class="admin-dashboard-hero">

                    <div>

                        <span class="section-tag">
                            ADMINISTRATION
                        </span>

                        <h1>
                            Welcome back,<br>
                            {{ auth()->user()->name }}.
                        </h1>

                        <p>
                            Manage services, monitor customer repair requests,
                            track service progress, and oversee transaction
                            activity from your FixIT administration panel.
                        </p>

                    </div>

                    <div class="admin-dashboard-status">

                        <span class="admin-dashboard-status-dot"></span>

                        <div>

                            <strong>
                                SYSTEM ONLINE
                            </strong>

                            <small>
                                FixIT Service Platform
                            </small>

                        </div>

                    </div>

                </div>


                {{-- ========================================
                     Platform Statistics
                     ======================================== --}}

                <div class="admin-dashboard-stats">

                    {{-- Users --}}
                    <article class="admin-stat-card">

                        <div class="admin-stat-top">

                            <span>USERS</span>

                            <span class="admin-stat-index">
                                01
                            </span>

                        </div>

                        <strong class="admin-stat-value">
                            {{ $totalUsers }}
                        </strong>

                        <p>
                            Registered customers
                        </p>

                    </article>


                    {{-- Services --}}
                    <article class="admin-stat-card">

                        <div class="admin-stat-top">

                            <span>SERVICES</span>

                            <span class="admin-stat-index">
                                02
                            </span>

                        </div>

                        <strong class="admin-stat-value">
                            {{ $activeServices }}
                        </strong>

                        <p>
                            Active services in catalog
                        </p>

                    </article>


                    {{-- Active Repairs --}}
                    <article class="admin-stat-card admin-stat-active">

                        <div class="admin-stat-top">

                            <span>ACTIVE REPAIRS</span>

                            <span class="admin-stat-index">
                                03
                            </span>

                        </div>

                        <strong class="admin-stat-value">
                            {{ $activeRepairs }}
                        </strong>

                        <p>
                            Repairs currently in progress
                        </p>

                    </article>


                    {{-- Completed --}}
                    <article class="admin-stat-card">

                        <div class="admin-stat-top">

                            <span>COMPLETED</span>

                            <span class="admin-stat-index">
                                04
                            </span>

                        </div>

                        <strong class="admin-stat-value">
                            {{ $completedRepairs }}
                        </strong>

                        <p>
                            Successfully completed repairs
                        </p>

                    </article>


                    {{-- Transactions --}}
                    <article class="admin-stat-card">

                        <div class="admin-stat-top">

                            <span>TRANSACTIONS</span>

                            <span class="admin-stat-index">
                                05
                            </span>

                        </div>

                        <strong class="admin-stat-value">
                            {{ $totalTransactions }}
                        </strong>

                        <p>
                            Recorded paid transactions
                        </p>

                    </article>

                </div>


                {{-- ========================================
                     Financial Summary
                     ======================================== --}}

                <section class="admin-dashboard-financial">

                    <div class="admin-financial-heading">

                        <div>

                            <span class="section-tag">
                                FINANCIAL OVERVIEW
                            </span>

                            <h2>
                                Financial Summary
                            </h2>

                            <p>
                                An overview of recorded payments
                                for the current month.
                            </p>

                        </div>

                        <span class="admin-financial-period">
                            {{ now()->format('F Y') }}
                        </span>

                    </div>


                    <div class="admin-financial-content">

                        {{-- Monthly Revenue --}}
                        <div class="admin-financial-metric">

                            <span class="admin-financial-label">
                                REVENUE THIS MONTH
                            </span>

                            <strong class="admin-financial-value">
                                Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}
                            </strong>

                            <p>
                                Successful payments recorded this month
                            </p>

                        </div>


                        {{-- Monthly Transactions --}}
                        <div class="admin-financial-metric">

                            <span class="admin-financial-label">
                                SUCCESSFUL PAYMENTS
                            </span>

                            <strong class="admin-financial-value">
                                {{ number_format($monthlyTransactions, 0, ',', '.') }}
                            </strong>

                            <p>
                                Transactions marked as paid
                            </p>

                        </div>


                        {{-- Financial Report Link --}}
                        <a
                            href="{{ route('admin.financial-reports') }}"
                            class="admin-financial-link"
                        >

                            <span>

                                <strong>
                                    View Financial Report
                                </strong>

                                <small>
                                    Explore transaction history
                                    and payment details.
                                </small>

                            </span>

                            <span
                                class="admin-financial-arrow"
                                aria-hidden="true"
                            >
                                →
                            </span>

                        </a>

                    </div>


                    <p class="admin-financial-disclaimer">
                        SIMULATED PAYMENT DATA — This summary reflects
                        recorded payment activity in FixIT and does not
                        represent verified bank deposits.
                    </p>

                </section>


                {{-- ========================================
                     Operations
                     ======================================== --}}

                <div class="admin-dashboard-grid">


                    {{-- Operations Panel --}}
                    <article
                        class="admin-dashboard-panel admin-dashboard-panel-main"
                    >

                        <div class="admin-dashboard-panel-head">

                            <div>

                                <span class="section-tag">
                                    OPERATIONS
                                </span>

                                <h2>
                                    Platform Management
                                </h2>

                            </div>

                            <span class="admin-panel-code">
                                FIXIT / OPS
                            </span>

                        </div>


                        {{-- Service Management --}}
                        <div class="admin-dashboard-operation">

                            <div class="admin-operation-number">
                                01
                            </div>

                            <div class="admin-operation-content">

                                <h3>
                                    Service Management
                                </h3>

                                <p>
                                    Create, edit, and control the availability
                                    of repair and maintenance services offered
                                    through the FixIT platform.
                                </p>

                            </div>

                            <a
                                href="{{ route('admin.services.index') }}"
                                class="admin-operation-link"
                            >
                                Manage
                                <span>→</span>
                            </a>

                        </div>


                        {{-- Repair Requests --}}
                        <div class="admin-dashboard-operation">

                            <div class="admin-operation-number">
                                02
                            </div>

                            <div class="admin-operation-content">

                                <h3>
                                    Repair Requests
                                </h3>

                                <p>
                                    Review incoming customer requests,
                                    inspect device information, and manage
                                    repair submissions.
                                </p>

                            </div>

                            <a
                                href="{{ route('admin.repairs.index') }}"
                                class="admin-operation-link"
                            >
                                Open
                                <span>→</span>
                            </a>

                        </div>


                        {{-- Service Workflow --}}
                        <div class="admin-dashboard-operation">

                            <div class="admin-operation-number">
                                03
                            </div>

                            <div class="admin-operation-content">

                                <h3>
                                    Service Workflow
                                </h3>

                                <p>
                                    Manage repairs from confirmation and
                                    diagnosis through repair, payment,
                                    and completion.
                                </p>

                            </div>

                            <a
                                href="{{ route('admin.repairs.index') }}"
                                class="admin-operation-link"
                            >
                                Manage
                                <span>→</span>
                            </a>

                        </div>


                        {{-- Invoice & Payment --}}
                        <div class="admin-dashboard-operation">

                            <div class="admin-operation-number">
                                04
                            </div>

                            <div class="admin-operation-content">

                                <h3>
                                    Invoice & Payment
                                </h3>

                                <p>
                                    Generate invoices after the final repair
                                    cost is determined and monitor recorded
                                    payment status.
                                </p>

                            </div>

                            <a
                                href="{{ route('admin.repairs.index') }}"
                                class="admin-operation-link"
                            >
                                Review
                                <span>→</span>
                            </a>

                        </div>

                    </article>


                    {{-- Platform Information --}}
                    <aside
                        class="admin-dashboard-panel admin-dashboard-side"
                    >

                        <div class="admin-dashboard-panel-head">

                            <div>

                                <span class="section-tag">
                                    PLATFORM
                                </span>

                                <h2>
                                    FixIT
                                </h2>

                            </div>

                        </div>


                        {{-- Service Model --}}
                        <div class="admin-platform-block">

                            <span>
                                SERVICE MODEL
                            </span>

                            <strong>
                                Digital Repair Platform
                            </strong>

                            <p>
                                FixIT connects customers with electronic
                                device repair services through digital
                                service discovery, booking, repair tracking,
                                invoicing, and payment records.
                            </p>

                        </div>


                        {{-- Customer Flow --}}
                        <div class="admin-platform-block">

                            <span>
                                CUSTOMER FLOW
                            </span>

                            <div class="admin-workflow">

                                <span>CATALOG</span>
                                <b>→</b>
                                <span>BOOK</span>
                                <b>→</b>
                                <span>REPAIR</span>
                                <b>→</b>
                                <span>PAY</span>

                            </div>

                        </div>


                        {{-- Service Status --}}
                        <div class="admin-platform-block">

                            <span>
                                SERVICE STATUS
                            </span>

                            <div class="admin-workflow">

                                <span>REQUEST</span>
                                <b>→</b>
                                <span>DIAGNOSE</span>
                                <b>→</b>
                                <span>REPAIR</span>
                                <b>→</b>
                                <span>COMPLETE</span>

                            </div>

                        </div>


                        {{-- Admin Note --}}
                        <div class="admin-dashboard-note">

                            <span>
                                ADMIN NOTE
                            </span>

                            <p>
                                Keep service information, repair status,
                                and final cost updated so customers receive
                                accurate information throughout their
                                service journey.
                            </p>

                        </div>

                    </aside>

                </div>


                {{-- ========================================
                     Quick Access
                     ======================================== --}}

                <div class="admin-dashboard-cta">

                    <div>

                        <span class="section-tag">
                            QUICK ACCESS
                        </span>

                        <h2>
                            Manage your FixIT service catalog
                        </h2>

                    </div>

                    <div class="admin-dashboard-cta-actions">

                        <a
                            href="{{ route('admin.services.index') }}"
                            class="btn -secondary"
                        >
                            Manage Services
                        </a>

                        <a
                            href="{{ route('admin.repairs.index') }}"
                            class="btn -primary"
                        >
                            View Repairs →
                        </a>

                    </div>

                </div>

            </div>

        </section>

    </main>

</body>
</html>