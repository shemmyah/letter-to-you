<!DOCTYPE html>
<html lang="en">

<head>
    <title>Upload Memory Photo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-pink-50 min-h-screen p-6">

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-6">
        <h2 class="text-2xl font-bold text-pink-600 mb-4">📸 Upload Memory Photo</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/admin/gallery/store?code=mysecret') }}" enctype="multipart/form-data"
            class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium text-sm text-gray-700">Choose Photo</label>
                <input type="file" name="image" required
                    class="block w-full text-sm file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-pink-100 file:text-pink-700
                    hover:file:bg-pink-200" />
            </div>

            <div>
                <label class="block mb-1 font-medium text-sm text-gray-700">Caption (optional)</label>
                <input type="text" name="caption" placeholder="Write a sweet caption..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-pink-300 focus:border-pink-400 text-sm">
            </div>

            <button type="submit"
                class="bg-pink-500 text-white font-semibold px-5 py-2 rounded hover:bg-pink-600 transition">
                Upload
            </button>
        </form>
    </div>

    <div class="max-w-6xl mx-auto mt-10">
        <h4 class="text-xl font-bold text-pink-600 mb-4">🖼 Uploaded Photos</h4>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($photos as $photo)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <img src="{{ $photo->base64_image }}" alt="Memory" class="w-full h-64 object-cover">

                    <div class="p-4 space-y-2">
                        @if ($photo->caption)
                            <p class="text-sm text-gray-600 italic">{{ $photo->caption }}</p>
                        @endif

                        <!-- Edit Toggle (Optional: JS needed for dynamic toggle) -->
                        <details class="border-t pt-2">
                            <summary class="text-pink-500 text-sm cursor-pointer hover:underline">✏️ Edit</summary>

                            <form method="POST"
                                action="{{ url('/admin/gallery/update/' . $photo->id . '?code=mysecret') }}"
                                enctype="multipart/form-data" class="mt-3 space-y-2">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block text-xs text-gray-500">Change Image</label>
                                    <input type="file" name="image"
                                        class="block w-full text-sm file:mr-4 file:py-1 file:px-3
                            file:rounded-full file:border-0
                            file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200" />
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500">Edit Caption</label>
                                    <input type="text" name="caption" value="{{ $photo->caption }}"
                                        class="w-full px-3 py-1 border border-gray-300 rounded-md text-sm focus:ring-pink-300 focus:border-pink-400">
                                </div>

                                <button type="submit"
                                    class="bg-pink-500 text-white text-sm px-3 py-1 rounded hover:bg-pink-600 transition">
                                    Save
                                </button>
                            </form>
                        </details>
                    </div>
            </div>
            @endforeach

        </div>
    </div>

</body>

</html>
