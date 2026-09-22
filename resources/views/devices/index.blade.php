<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Devices - FixIT</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="container">

        <h1>My Devices</h1>

        <p>
            Welcome, {{ auth()->user()->name }}
        </p>

        @if (session('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('devices.create') }}">
            + Add Device
        </a>

        <hr>

        @forelse ($devices as $device)

            <div>
                <h2>{{ $device->name }}</h2>

                <p>
                    Device Code: {{ $device->device_code }}
                </p>

                <p>
                    Category: {{ $device->category }}
                </p>

                <p>
                    Brand: {{ $device->brand }}
                </p>

                @if ($device->model)
                    <p>
                        Model: {{ $device->model }}
                    </p>
                @endif

                @if ($device->serial_number)
                    <p>
                        Serial Number: {{ $device->serial_number }}
                    </p>
                @endif

                @if ($device->description)
                    <p>
                        Description: {{ $device->description }}
                    </p>
                @endif
            </div>
        <a href="{{ route('devices.edit', $device) }}">
            Edit
        </a>

        </form
            action="{{ route('devices.destroy', $device) }}"
            method="POST"
            style="display: inline;"
            onsubmit="return confirm('Are you sure you want to delete this device?')"
        >
            @csrf
            @method('DELETE')

    <button type="submit">
        Delete
    </button>
</form>
            <hr>

        @empty

            <p>
                You don't have any registered devices yet.
            </p>

        @endforelse

        <a href="{{ route('dashboard') }}">
            ← Back to Dashboard
        </a>

    </div>

</body>
</html>