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

        <form action="{{ route('send.dedication', ['code' => 'mysecret']) }}" method="POST">

            @csrf
            <input type="text" name="recipient" class="form-control mb-2" placeholder="To (recipient)" required>
            <input type="text" name="song_title" class="form-control mb-2" placeholder="Song title" required>
            <input type="text" name="song_link" class="form-control mb-2"
                placeholder="Spotify/YouTube link (optional)">
            <textarea name="message" class="form-control mb-2" placeholder="Your message" rows="9" required></textarea>
            <input type="text" name="sender" class="form-control mb-2" placeholder="From (optional)">
            <button class="btn btn-primary w-100">Send Dedication</button>
        </form>

        <hr class="my-4">

        
    </div>
</body>

</html>
