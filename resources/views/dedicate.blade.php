<!DOCTYPE html>
<html lang="en">
<head>
    <title>Send a Song Dedication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container">
        <h2 class="mb-4">💌 Send a Song Dedication</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- If editing, show edit form --}}
        @if (isset($editDedication))
            <form action="{{ url('/admin/dedicate/update/' . $editDedication->id . '?code=mysecret') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="alert alert-warning">✏️ You are editing a dedication</div>

                <input type="text" name="recipient" class="form-control mb-2" placeholder="To (recipient)" required value="{{ old('recipient', $editDedication->recipient) }}">
                <input type="text" name="song_title" class="form-control mb-2" placeholder="Song title" required value="{{ old('song_title', $editDedication->song_title) }}">
                <input type="text" name="song_link" class="form-control mb-2" placeholder="Spotify/YouTube link (optional)" value="{{ old('song_link', $editDedication->song_link) }}">
                <textarea name="message" class="form-control mb-2" placeholder="Your message" rows="9" required>{{ old('message', $editDedication->message) }}</textarea>
                <input type="text" name="sender" class="form-control mb-2" placeholder="From (optional)" value="{{ old('sender', $editDedication->sender) }}">
                <button class="btn btn-warning w-100">Update Dedication</button>
            </form>
        @else
            {{-- Original Add Form --}}
            <form action="{{ route('send.dedication', ['code' => 'mysecret']) }}" method="POST">
                @csrf
                <input type="text" name="recipient" class="form-control mb-2" placeholder="To (recipient)" required>
                <input type="text" name="song_title" class="form-control mb-2" placeholder="Song title" required>
                <input type="text" name="song_link" class="form-control mb-2" placeholder="Spotify/YouTube link (optional)">
                <textarea name="message" class="form-control mb-2" placeholder="Your message" rows="9" required></textarea>
                <input type="text" name="sender" class="form-control mb-2" placeholder="From (optional)">
                <button class="btn btn-primary w-100">Send Dedication</button>
            </form>
        @endif

        <hr class="my-5">

        {{-- List of all dedications --}}
        <h4 class="mb-3">📜 All Dedications</h4>
        @if ($dedications->count())
            <div class="list-group">
                @foreach ($dedications as $dedication)
                    <div class="list-group-item mb-2">
                        <h5 class="mb-1">🎶 {{ $dedication->song_title }}</h5>
                        @if ($dedication->song_link)
                            <p><a href="{{ $dedication->song_link }}" target="_blank">🔗 Listen</a></p>
                        @endif
                        <p class="mb-1">{{ $dedication->message }}</p>
                        <small>
                            <strong>To:</strong> {{ $dedication->recipient }} |
                            <strong>From:</strong> {{ $dedication->sender ?? 'Anonymous' }}
                        </small>

                        <div class="mt-2">
                            <a href="?code=mysecret&edit={{ $dedication->id }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">No dedications yet.</p>
        @endif
    </div>
</body>
</html>
