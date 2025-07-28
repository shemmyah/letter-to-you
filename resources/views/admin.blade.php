<!DOCTYPE html>
<html lang="en">
<head>
    <title>Lyrics Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 p-6">

<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-6">
    <h2 class="text-2xl font-bold text-pink-600 mb-4">🎶 Add a New Lyric</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ url('/admin/lyrics/store?code=mysecret') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" required class="w-full border px-4 py-2 rounded" />
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Lyrics</label>
            <textarea name="body" required rows="5" class="w-full border px-4 py-2 rounded"></textarea>
        </div>

        <button type="submit"
            class="bg-pink-500 text-white font-semibold px-5 py-2 rounded hover:bg-pink-600 transition">
            Add Lyric
        </button>
    </form>
</div>

<div class="max-w-4xl mx-auto mt-10 space-y-6">
    <h4 class="text-xl font-bold text-pink-600 mb-4">🎧 Existing Lyrics</h4>

    @foreach ($lyrics as $lyric)
        <div class="bg-white p-4 rounded-xl shadow space-y-2">
            <h5 class="text-lg font-semibold text-gray-800">{{ $lyric->title }}</h5>
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $lyric->body }}</p>

            <details class="border-t pt-2">
                <summary class="text-sm text-pink-500 cursor-pointer hover:underline">✏️ Edit</summary>
                <form method="POST" action="{{ url('/admin/lyrics/update/' . $lyric->id . '?code=mysecret') }}" class="mt-3 space-y-2">
                    @csrf
                    @method('PUT')
                    <input type="text" name="title" value="{{ $lyric->title }}" class="w-full border px-3 py-1 rounded" />
                    <textarea name="body" rows="4" class="w-full border px-3 py-1 rounded">{{ $lyric->body }}</textarea>
                    <button type="submit" class="bg-pink-500 text-white text-sm px-3 py-1 rounded hover:bg-pink-600">
                        Save
                    </button>
                </form>
            </details>
        </div>
    @endforeach
</div>

</body>
</html>
