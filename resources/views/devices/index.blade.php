<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Devices — FixIT</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    {{-- Navbar --}}
    <header class="nav">
        <div class="container">

            <a href="{{ route('home') }}" class="brand">
                <span class="mark">FX</span>FixIT
            </a>

            <nav class="nav-links">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('devices.index') }}">Devices</a>
                <a href="{{ route('repairs.index') }}">Repairs</a>
            </nav>

            <div class="nav-actions">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="btn -secondary -sm">
                        Log out
                    </button>
                </form>
            </div>

        </div>
    </header>


    {{-- Devices --}}
    <section>
        <div class="container">

            {{-- Page Header --}}
            <div class="section-head">

                <div>
                    <div class="section-tag">
                        Device Management
                    </div>

                    <h1>
                        My Devices
                    </h1>

                    <p>
                        Manage your registered devices and their repair
                        identification.
                    </p>
                </div>

                <a
                    href="{{ route('devices.create') }}"
                    class="btn -primary"
                >
                    + Add Device
                </a>

            </div>


            {{-- Success Message --}}
            @if (session('success'))

                <div class="success-message">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Device List --}}
            <div class="device-grid">

                @forelse ($devices as $device)

                    <article class="device-card">

                        {{-- Device Information --}}
                        <div class="device-info">

                            <div class="section-tag">
                                {{ $device->category }}
                            </div>

                            <h2>
                                {{ $device->name }}
                            </h2>

                            <span class="ticket-code">
                                {{ $device->device_code }}
                            </span>

                            <div class="device-details">

                                <p>
                                    <strong>Brand</strong>
                                    {{ $device->brand }}
                                </p>

                                @if ($device->model)
                                    <p>
                                        <strong>Model</strong>
                                        {{ $device->model }}
                                    </p>
                                @endif

                                @if ($device->serial_number)
                                    <p>
                                        <strong>Serial Number</strong>
                                        {{ $device->serial_number }}
                                    </p>
                                @endif

                                @if ($device->description)
                                    <p>
                                        <strong>Description</strong>
                                        {{ $device->description }}
                                    </p>
                                @endif

                            </div>

                        </div>


                        {{-- QR Code --}}
                        <div class="device-qr">

                            <div class="section-tag">
                                Device QR
                            </div>

                            <div class="qr-box">
                                {!! QrCode::size(180)->generate(
                                    route(
                                        'devices.public-show',
                                        $device->device_code
                                    )
                                ) !!}
                            </div>

                            <p>
                                Scan this QR code to view device
                                information and repair history.
                            </p>

                        </div>


                        {{-- Actions --}}
                        <div class="device-actions">

                            <a
                                href="{{ route('devices.edit', $device) }}"
                                class="btn -secondary -sm"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('devices.destroy', $device) }}"
                                method="POST"
                                onsubmit="return confirm(
                                    'Are you sure you want to delete this device?'
                                )"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn -ghost -sm"
                                >
                                    Delete
                                </button>
                            </form>

                        </div>

                    </article>

                @empty

                    {{-- Empty State --}}
                    <div class="empty-state">

                        <h2>
                            No devices registered yet.
                        </h2>

                        <p>
                            Add your first device to start managing
                            repairs and QR-based device tracking.
                        </p>

                        <a
                            href="{{ route('devices.create') }}"
                            class="btn -primary"
                        >
                            Add Your First Device
                        </a>

                    </div>

                @endforelse

            </div>

        </div>
    </section>

</body>
</html>