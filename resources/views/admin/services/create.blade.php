<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Service — Admin — FixIT</title>

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

            <a href="{{ route('admin.repairs.index') }}">
                Repairs
            </a>

            <a
                href="{{ route('admin.services.index') }}"
                class="active"
            >
                Services
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
    <section>
        <div class="container">

            <a
                href="{{ route('admin.services.index') }}"
                style="display: inline-block; margin-bottom: 24px;"
            >
                ← Back to Services
            </a>

            <div class="section-head">

                <span class="section-tag">
                    SERVICE MANAGEMENT
                </span>

                <h1>
                    Add New Service
                </h1>

                <p>
                    Create a new repair or maintenance service
                    offered through the FixIT platform.
                </p>

            </div>

            @if ($errors->any())
                <div
                    style="
                        margin-bottom: 24px;
                        padding: 16px;
                        color: var(--accent);
                        background: var(--accent-dim);
                        border: 1px solid rgba(229, 57, 53, 0.2);
                        border-radius: var(--radius-sm);
                    "
                >
                    <strong>
                        Please check the following:
                    </strong>

                    <ul style="margin: 8px 0 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('admin.services.store') }}"
                method="POST"
                style="max-width: 760px;"
            >

                @csrf

                <div class="field">
                    <label for="name">
                        Service Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="e.g. Laptop Repair"
                        required
                    >
                </div>

                <div class="field">
                    <label for="slug">
                        Slug
                    </label>

                    <input
                        type="text"
                        id="slug"
                        name="slug"
                        value="{{ old('slug') }}"
                        placeholder="e.g. laptop-repair"
                        required
                    >

                    <small>
                        Used internally as the service identifier.
                    </small>
                </div>

                <div class="field">
                    <label for="category">
                        Category
                    </label>

                    <input
                        type="text"
                        id="category"
                        name="category"
                        value="{{ old('category') }}"
                        placeholder="e.g. Laptop"
                        required
                    >
                </div>

                <div class="field">
                    <label for="description">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Describe the service..."
                        required
                    >{{ old('description') }}</textarea>
                </div>

                <div class="field">
                    <label for="starting_price">
                        Starting Price
                    </label>

                    <input
                        type="number"
                        id="starting_price"
                        name="starting_price"
                        value="{{ old('starting_price') }}"
                        min="0"
                        step="1000"
                        placeholder="100000"
                        required
                    >
                </div>

                <div class="field">
                    <label>
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                        >

                        Active Service
                    </label>

                    <small>
                        Active services will appear in the public service catalog.
                    </small>
                </div>

                <div
                    style="
                        display: flex;
                        gap: 12px;
                        margin-top: 24px;
                    "
                >

                    <button
                        type="submit"
                        class="btn -primary"
                    >
                        Create Service
                    </button>

                    <a
                        href="{{ route('admin.services.index') }}"
                        class="btn -secondary"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>
    </section>
</main>

</body>
</html>