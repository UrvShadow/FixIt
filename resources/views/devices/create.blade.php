<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Device - FixIT</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="container">

        <h1>Add Device</h1>

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

        <form action="{{ route('devices.store') }}" method="POST">

            @csrf

            <div>
                <label for="name">Device Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. ASUS ROG Laptop"
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
                    value="{{ old('category') }}"
                    placeholder="e.g. Laptop"
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
                    value="{{ old('brand') }}"
                    placeholder="e.g. ASUS"
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
                    value="{{ old('model') }}"
                    placeholder="e.g. ROG Strix G15"
                >
            </div>

            <br>

            <div>
                <label for="serial_number">Serial Number</label>
                <input
                    type="text"
                    id="serial_number"
                    name="serial_number"
                    value="{{ old('serial_number') }}"
                    placeholder="Optional"
                >
            </div>

            <br>

            <div>
                <label for="description">Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    placeholder="Additional information about the device..."
                >{{ old('description') }}</textarea>
            </div>

            <br>

            <button type="submit">
                Save Device
            </button>

        </form>

        <br>

        <a href="{{ route('devices.index') }}">
            ← Back to My Devices
        </a>

    </div>

</body>
</html>