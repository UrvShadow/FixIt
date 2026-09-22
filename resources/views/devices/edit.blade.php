<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Device - FixIT</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="container">

        <h1>Edit Device</h1>

        <p>
            Device Code: {{ $device->device_code }}
        </p>

        @if ($errors->any())
            <div>
                <strong>Please fix the following errors:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('devices.update', $device) }}" method="POST">

            @csrf
            @method('PUT')

            <div>
                <label for="name">Device Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $device->name) }}"
                    required
                >
            </div>

            <br>

            <div>
                <label for="category">Category</label>

                <input
                    type="text"
                    id="category"
                    name="category"
                    value="{{ old('category', $device->category) }}"
                    required
                >
            </div>

            <br>

            <div>
                <label for="brand">Brand</label>

                <input
                    type="text"
                    id="brand"
                    name="brand"
                    value="{{ old('brand', $device->brand) }}"
                    required
                >
            </div>

            <br>

            <div>
                <label for="model">Model</label>

                <input
                    type="text"
                    id="model"
                    name="model"
                    value="{{ old('model', $device->model) }}"
                >
            </div>

            <br>

            <div>
                <label for="serial_number">Serial Number</label>

                <input
                    type="text"
                    id="serial_number"
                    name="serial_number"
                    value="{{ old('serial_number', $device->serial_number) }}"
                >
            </div>

            <br>

            <div>
                <label for="description">Description</label>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                >{{ old('description', $device->description) }}</textarea>
            </div>

            <br>

            <button type="submit">
                Update Device
            </button>

        </form>

        <br>

        <a href="{{ route('devices.index') }}">
            ← Back to My Devices
        </a>

    </div>

</body>
</html>