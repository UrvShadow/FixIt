
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit {{ $promo->code }} — FixIT Admin</title>

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
                href="{{ route('admin.dashboard') }}"
                class="brand"
            >
                <span class="mark">FX</span>
                FixIT Admin
            </a>

            <nav class="nav-links" aria-label="Admin navigation">

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
                    aria-current="page"
                >
                    Promos
                </a>

                <a href="{{ route('admin.financial-reports') }}">
                    Financial Reports
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
         Edit Promo
         ======================================== --}}

    <main class="admin-promo-create-page">

        <div class="container">

            {{-- Back Navigation --}}
            <a
                href="{{ route('admin.promos.index') }}"
                class="admin-promo-create-back"
            >
                <span aria-hidden="true">←</span>
                Back to Promo Management
            </a>


            {{-- Page Heading --}}
            <div class="admin-promo-create-heading">

                <div>

                    <span class="section-tag">
                        PROMO MANAGEMENT / EDIT ENTRY
                    </span>

                    <h1>
                        Edit Promo
                    </h1>

                    <p>
                        Update the discount code, eligibility requirements,
                        and availability of this FixIT promotion.
                    </p>

                </div>

                <span class="admin-promo-create-code">
                    PROMO / {{ str_pad($promo->id, 4, '0', STR_PAD_LEFT) }}
                </span>

            </div>


            {{-- Validation Errors --}}
            @if ($errors->any())

                <div
                    class="admin-promo-create-errors"
                    role="alert"
                >

                    <div class="admin-promo-create-errors-title">

                        <span aria-hidden="true">!</span>

                        <strong>
                            Please review the following fields.
                        </strong>

                    </div>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            @endif


            @php
                $isActive = (bool) old(
                    'is_active',
                    $promo->is_active
                );
            @endphp


            {{-- Form Layout --}}
            <div class="admin-promo-create-layout">


                {{-- Main Form --}}
                <form
                    action="{{ route('admin.promos.update', $promo) }}"
                    method="POST"
                    class="admin-promo-create-form"
                >

                    @csrf
                    @method('PUT')


                    {{-- Discount Configuration --}}
                    <section class="admin-promo-create-panel">

                        <div class="admin-promo-create-panel-heading">

                            <div class="admin-promo-create-step">
                                01
                            </div>

                            <div>

                                <span class="section-tag">
                                    PROMO DETAILS
                                </span>

                                <h2>
                                    Discount Configuration
                                </h2>

                                <p>
                                    Update the code and discount
                                    customers can receive.
                                </p>

                            </div>

                        </div>


                        <div class="admin-promo-create-fields">


                            {{-- Promo Code --}}
                            <div class="admin-promo-create-field is-full-width">

                                <label for="code">
                                    Promo Code
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="code"
                                    name="code"
                                    value="{{ old('code', $promo->code) }}"
                                    maxlength="50"
                                    placeholder="e.g. WELCOME10"
                                    autocomplete="off"
                                    spellcheck="false"
                                    required
                                >

                                <small>
                                    Customers enter this code during checkout.
                                    The code must remain unique.
                                </small>

                                @error('code')
                                    <span class="admin-promo-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            {{-- Discount Type --}}
                            <div class="admin-promo-create-field">

                                <label for="discount_type">
                                    Discount Type
                                    <span>*</span>
                                </label>

                                <select
                                    id="discount_type"
                                    name="discount_type"
                                    required
                                >

                                    <option
                                        value="percentage"
                                        {{ old('discount_type', $promo->discount_type) === 'percentage' ? 'selected' : '' }}
                                    >
                                        Percentage (%)
                                    </option>

                                    <option
                                        value="fixed"
                                        {{ old('discount_type', $promo->discount_type) === 'fixed' ? 'selected' : '' }}
                                    >
                                        Fixed Amount (Rp)
                                    </option>

                                </select>

                                <small>
                                    Choose a percentage or fixed discount.
                                </small>

                                @error('discount_type')
                                    <span class="admin-promo-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            {{-- Discount Value --}}
                            <div class="admin-promo-create-field">

                                <label for="discount_value">
                                    Discount Value
                                    <span>*</span>
                                </label>

                                <input
                                    type="number"
                                    id="discount_value"
                                    name="discount_value"
                                    value="{{ old('discount_value', $promo->discount_value) }}"
                                    min="0"
                                    step="0.01"
                                    placeholder="e.g. 10"
                                    required
                                >

                                <small id="promo-discount-help">
                                    Enter the percentage discount.
                                </small>

                                @error('discount_value')
                                    <span class="admin-promo-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            {{-- Minimum Transaction --}}
                            <div class="admin-promo-create-field">

                                <label for="minimum_transaction">
                                    Minimum Transaction
                                    <span>*</span>
                                </label>

                                <div class="admin-promo-create-money-input">

                                    <span>Rp</span>

                                    <input
                                        type="number"
                                        id="minimum_transaction"
                                        name="minimum_transaction"
                                        value="{{ old('minimum_transaction', $promo->minimum_transaction) }}"
                                        min="0"
                                        step="0.01"
                                        placeholder="100000"
                                        required
                                    >

                                </div>

                                <small>
                                    Set to 0 if no minimum is required.
                                </small>

                                @error('minimum_transaction')
                                    <span class="admin-promo-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>


                            {{-- Expiration --}}
                            <div class="admin-promo-create-field">

                                <label for="expires_at">
                                    Expiration Date
                                </label>

                                <input
                                    type="datetime-local"
                                    id="expires_at"
                                    name="expires_at"
                                    value="{{ old(
                                        'expires_at',
                                        $promo->expires_at
                                            ? $promo->expires_at->format('Y-m-d\TH:i')
                                            : ''
                                    ) }}"
                                >

                                <small>
                                    Leave empty if the promo does not expire.
                                </small>

                                @error('expires_at')
                                    <span class="admin-promo-create-field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>

                    </section>


                    {{-- Publication Settings --}}
                    <section class="admin-promo-create-panel">

                        <div class="admin-promo-create-panel-heading">

                            <div class="admin-promo-create-step">
                                02
                            </div>

                            <div>

                                <span class="section-tag">
                                    AVAILABILITY
                                </span>

                                <h2>
                                    Publication Settings
                                </h2>

                                <p>
                                    Control whether this promotion
                                    can be used by customers.
                                </p>

                            </div>

                        </div>


                        <label
                            for="is_active"
                            class="admin-promo-create-visibility"
                        >

                            {{-- Submit 0 when checkbox is unchecked --}}
                            <input
                                type="hidden"
                                name="is_active"
                                value="0"
                            >

                            <input
                                type="checkbox"
                                id="is_active"
                                name="is_active"
                                value="1"
                                {{ $isActive ? 'checked' : '' }}
                            >

                            <span class="admin-promo-create-visibility-copy">

                                <strong>
                                    Keep this promo active
                                </strong>

                                <small>
                                    Allow customers to use this code
                                    when all eligibility requirements are met.
                                </small>

                            </span>

                            <span
                                id="promo-preview-status"
                                class="admin-promo-create-status {{ $isActive ? 'is-active' : 'is-inactive' }}"
                            >
                                {{ $isActive ? 'ACTIVE' : 'INACTIVE' }}
                            </span>

                        </label>

                        @error('is_active')
                            <span class="admin-promo-create-field-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </section>


                    {{-- Form Actions --}}
                    <div class="admin-promo-create-actions">

                        <a
                            href="{{ route('admin.promos.index') }}"
                            class="btn -secondary"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="btn -primary"
                        >
                            Save Changes
                            <span aria-hidden="true">→</span>
                        </button>

                    </div>

                </form>


                {{-- Sidebar --}}
                <aside class="admin-promo-create-aside">


                    {{-- Live Preview --}}
                    <section class="admin-promo-create-preview-panel">

                        <div class="admin-promo-create-preview-heading">

                            <div>

                                <span class="section-tag">
                                    LIVE PREVIEW
                                </span>

                                <h2>
                                    Promo Preview
                                </h2>

                            </div>

                            <span class="admin-promo-create-preview-indicator">
                                LIVE
                            </span>

                        </div>


                        <div class="admin-promo-create-ticket">

                            {{-- Ticket Header --}}
                            <div class="admin-promo-create-ticket-top">

                                <span class="admin-promo-create-ticket-brand">
                                    <span class="mark">FX</span>
                                    FixIT
                                </span>

                                <span class="admin-promo-create-ticket-label">
                                    PROMOTION
                                </span>

                            </div>


                            {{-- Discount Preview --}}
                            <div class="admin-promo-create-ticket-discount">

                                <span class="admin-promo-create-ticket-caption">
                                    YOUR DISCOUNT
                                </span>

                                <strong
                                    id="promo-preview-value"
                                    aria-live="polite"
                                >
                                    —
                                </strong>

                            </div>


                            {{-- Promo Code --}}
                            <div class="admin-promo-create-ticket-code">

                                <span>
                                    PROMO CODE
                                </span>

                                <strong id="promo-preview-code">
                                    {{ old('code', $promo->code) }}
                                </strong>

                            </div>


                            {{-- Requirements --}}
                            <div class="admin-promo-create-ticket-details">

                                <div>

                                    <span>
                                        MIN. SPEND
                                    </span>

                                    <strong id="promo-preview-minimum">
                                        Rp {{ number_format($promo->minimum_transaction, 0, ',', '.') }}
                                    </strong>

                                </div>

                                <div>

                                    <span>
                                        EXPIRES
                                    </span>

                                    <strong id="promo-preview-expiry">

                                        @if ($promo->expires_at)
                                            {{ $promo->expires_at->format('d M Y H:i') }}
                                        @else
                                            No expiration
                                        @endif

                                    </strong>

                                </div>

                            </div>


                            {{-- Preview Status --}}
                            <div
                                id="promo-preview-ticket-status"
                                class="admin-promo-create-ticket-status {{ $isActive ? 'is-active' : 'is-inactive' }}"
                            >
                                {{ $isActive ? 'ACTIVE PROMO' : 'INACTIVE PROMO' }}
                            </div>

                        </div>


                        <p class="admin-promo-create-preview-note">
                            Changes are previewed here before saving.
                            The saved promotion is updated only after
                            the form is submitted successfully.
                        </p>

                    </section>


                    {{-- Current Promo Overview --}}
                    <section class="admin-promo-create-guide">

                        <span class="section-tag">
                            CURRENT RECORD
                        </span>

                        <h2>
                            Promo Overview
                        </h2>


                        <div class="admin-promo-create-guide-item">

                            <span>01</span>

                            <div>

                                <strong>
                                    Promo ID
                                </strong>

                                <p>
                                    #{{ $promo->id }}
                                </p>

                            </div>

                        </div>


                        <div class="admin-promo-create-guide-item">

                            <span>02</span>

                            <div>

                                <strong>
                                    Current Discount
                                </strong>

                                <p>

                                    @if ($promo->discount_type === 'percentage')

                                        {{ rtrim(rtrim(number_format((float) $promo->discount_value, 2, '.', ''), '0'), '.') }}%

                                    @else

                                        Rp {{ number_format($promo->discount_value, 0, ',', '.') }}

                                    @endif

                                </p>

                            </div>

                        </div>


                        <div class="admin-promo-create-guide-item">

                            <span>03</span>

                            <div>

                                <strong>
                                    Current Status
                                </strong>

                                <p>
                                    {{ $promo->is_active ? 'Active' : 'Inactive' }}
                                </p>

                            </div>

                        </div>


                        <div class="admin-promo-create-guide-item">

                            <span>04</span>

                            <div>

                                <strong>
                                    Expiration
                                </strong>

                                <p>
                                    @if ($promo->expires_at)
                                        {{ $promo->expires_at->format('d M Y, H:i') }}
                                    @else
                                        No expiration date
                                    @endif
                                </p>

                            </div>

                        </div>

                    </section>


                    {{-- Admin Note --}}
                    <section class="admin-promo-create-note">

                        <span>
                            ADMIN NOTE
                        </span>

                        <p>
                            Updating a promo does not rewrite the
                            discount already recorded on existing invoices.
                            Review the promo validation rules before
                            changing how future checkouts use it.
                        </p>

                    </section>

                </aside>

            </div>

        </div>

    </main>


    {{-- ========================================
         Live Promo Preview
         ======================================== --}}

    <script>
        (() => {
            const codeInput = document.getElementById('code');
            const typeInput = document.getElementById('discount_type');
            const valueInput = document.getElementById('discount_value');
            const minimumInput = document.getElementById('minimum_transaction');
            const expiryInput = document.getElementById('expires_at');
            const activeInput = document.getElementById('is_active');

            const previewCode = document.getElementById('promo-preview-code');
            const previewValue = document.getElementById('promo-preview-value');
            const previewMinimum = document.getElementById('promo-preview-minimum');
            const previewExpiry = document.getElementById('promo-preview-expiry');
            const previewStatus = document.getElementById('promo-preview-status');
            const previewTicketStatus = document.getElementById('promo-preview-ticket-status');
            const discountHelp = document.getElementById('promo-discount-help');

            const numberFormatter = new Intl.NumberFormat('id-ID', {
                maximumFractionDigits: 2
            });

            const formatNumber = (value) => numberFormatter.format(value);

            const formatRupiah = (rawValue) => {
                if (String(rawValue).trim() === '') {
                    return 'Rp 0';
                }

                const value = Number(rawValue);

                if (!Number.isFinite(value)) {
                    return 'Rp 0';
                }

                return `Rp ${formatNumber(value)}`;
            };

            const formatExpiry = (rawValue) => {
                if (!rawValue) {
                    return 'No expiration';
                }

                const date = new Date(rawValue);

                if (Number.isNaN(date.getTime())) {
                    return 'Invalid date';
                }

                return new Intl.DateTimeFormat('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }).format(date);
            };

            const updatePreview = () => {
                const code = codeInput.value.trim().toUpperCase();
                const type = typeInput.value;
                const rawValue = valueInput.value.trim();
                const rawMinimum = minimumInput.value.trim();

                const value = Number(rawValue);
                const isActive = activeInput.checked;

                previewCode.textContent = code || 'PROMO';

                if (rawValue === '') {
                    previewValue.textContent = '—';
                } else if (Number.isFinite(value)) {
                    previewValue.textContent = type === 'percentage'
                        ? `${formatNumber(value)}% OFF`
                        : `${formatRupiah(rawValue)} OFF`;
                } else {
                    previewValue.textContent = '—';
                }

                previewMinimum.textContent =
                    formatRupiah(rawMinimum);

                previewExpiry.textContent =
                    formatExpiry(expiryInput.value);

                discountHelp.textContent = type === 'percentage'
                    ? 'Enter the percentage discount.'
                    : 'Enter the fixed discount amount in rupiah.';

                previewStatus.textContent =
                    isActive ? 'ACTIVE' : 'INACTIVE';

                previewStatus.classList.toggle(
                    'is-active',
                    isActive
                );

                previewStatus.classList.toggle(
                    'is-inactive',
                    !isActive
                );

                previewTicketStatus.textContent =
                    isActive ? 'ACTIVE PROMO' : 'INACTIVE PROMO';

                previewTicketStatus.classList.toggle(
                    'is-active',
                    isActive
                );

                previewTicketStatus.classList.toggle(
                    'is-inactive',
                    !isActive
                );
            };

            [
                codeInput,
                typeInput,
                valueInput,
                minimumInput,
                expiryInput
            ].forEach((input) => {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
            });

            activeInput.addEventListener('change', updatePreview);

            updatePreview();
        })();
    </script>

</body>
</html>