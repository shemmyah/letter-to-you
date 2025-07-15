<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome Back, My Love</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Quicksand:wght@400;600&display=swap"
        rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-image: linear-gradient(to bottom right, #ffe4e6, #fff1f2);
            animation: fadeIn 1.5s ease-out forwards;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeZoomIn {
            0% {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .fade-zoom {
            animation: fadeZoomIn 0.4s ease-out both;
        }

        @keyframes floatFade {

            0%,
            100% {
                opacity: 0;
                transform: translateY(0);
            }

            50% {
                opacity: 1;
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4 pt-20 relative">
    <!-- Music Toggle Button -->
    <button id="toggleMusicBtn"
        class="fixed bottom-4 right-4 z-50 bg-pink-500 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg hover:bg-pink-600 transition"
        title="Toggle Music">
        🔈
    </button>

    <!-- Floating Hearts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.createElement('div');
            container.style.position = 'absolute';
            container.style.top = 0;
            container.style.left = 0;
            container.style.width = '100%';
            container.style.height = document.body.scrollHeight + 'px';
            container.style.pointerEvents = 'none';
            container.style.zIndex = 0;

            for (let i = 0; i < 60; i++) {
                const heart = document.createElement('div');
                const size = Math.floor(Math.random() * 3) + 3;
                const pos = Math.random() * 100;
                const offsetTop = Math.random() * document.body.scrollHeight;
                const delay = Math.random() * 5;
                const emoji = ['💖', '💗', '💘'][Math.floor(Math.random() * 3)];

                heart.className = `absolute text-pink-300`;
                heart.style.left = `${pos}vw`;
                heart.style.top = `${offsetTop}px`;
                heart.style.fontSize = `${size * 0.5}rem`;
                heart.style.animation = `floatFade 6s ease-in-out ${delay}s infinite`;
                heart.textContent = emoji;

                container.appendChild(heart);
            }

            document.body.appendChild(container);
        });
    </script>

    <!-- Background Music -->
    <audio id="bgMusic" autoplay loop hidden>
        <source src="/audios/i-will.mp3" type="audio/mpeg">
    </audio>

    <div class="max-w-2xl w-full text-center space-y-8 z-10 animate-fade-letter">
        <h1 class="text-4xl font-bold text-pink-700 mt-10">
            @if (request('recipient'))
                Hi honey, here are your dedications 💌
            @else
                Welcome back, my love 💖
            @endif
        </h1>

        @if (request('recipient'))
            <p class="text-pink-600">These songs remind me of you, my love 💝</p>
        @else
            <p class="text-pink-600">Search to see the songs I've lovingly picked just for you.</p>
        @endif

        <form action="{{ route('dedication.search') }}" method="GET" class="mt-4 flex gap-2 justify-center">
            <input type="text" name="recipient"
                class="w-full sm:w-2/3 px-4 py-2 rounded-xl border border-pink-300 focus:ring-2 focus:ring-pink-500 outline-none"
                placeholder="Type your name..." required>
            <button class="bg-pink-500 text-white px-4 py-2 rounded-xl hover:bg-pink-600 transition">Search</button>
        </form>

        @foreach ($dedications as $dedication)
            <div class="bg-white rounded-3xl shadow-lg p-6 mb-6 border border-pink-100 animate-fade-letter cursor-pointer hover:shadow-pink-200 transition dedication-box"
                data-title="{{ $dedication->song_title }}" data-audio="{{ $dedication->audio_file ?? 'default.mp3' }}"
                data-message="{{ htmlentities($dedication->message, ENT_QUOTES) }}"
                data-spotify="{{ $dedication->song_link ?? '' }}">

                @if ($dedication->song_link && Str::contains($dedication->song_link, 'spotify.com'))
                    @php
                        preg_match(
                            '/spotify\.com\/(track|album|playlist)\/([a-zA-Z0-9]+)/',
                            $dedication->song_link,
                            $matches,
                        );
                        $type = $matches[1] ?? null;
                        $id = $matches[2] ?? null;
                    @endphp
                    @if ($type && $id)
                        <div class="my-3">
                            <iframe class="rounded-lg w-full"
                                src="https://open.spotify.com/embed/{{ $type }}/{{ $id }}"
                                height="80" frameborder="0"
                                allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                                loading="lazy">
                            </iframe>
                        </div>
                    @endif
                @elseif ($dedication->song_link)
                    <a href="{{ $dedication->song_link }}" target="_blank" class="text-pink-500 hover:underline">🎵
                        Listen</a>
                @endif

                <p class="mt-4 text-gray-700 italic leading-relaxed">"{{ $dedication->message }}"</p>
                <p class="text-sm text-gray-500 mt-3">— {{ $dedication->sender ?? 'Anonymous' }}</p>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div id="dedicationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
        <div
            class="bg-white max-w-md w-full max-h-[90vh] overflow-y-auto rounded-2xl p-6 relative shadow-xl text-center fade-zoom">
            <button onclick="closeModal()"
                class="absolute top-2 right-4 text-2xl text-pink-400 hover:text-pink-600">&times;</button>
            <h2 id="modalSongTitle" class="text-2xl font-bold text-pink-600 mb-4"></h2>
            <div id="modalSpotifyEmbed" class="mb-4"></div>
            <p id="modalMessage" class="text-gray-700 leading-relaxed mb-4 whitespace-pre-line text-sm"></p>
            <audio id="popupAudio" autoplay class="mx-auto mt-2 w-full">
                <source id="popupAudioSource" src="" type="audio/mpeg">
            </audio>
        </div>
    </div>

    <script>
        const modal = document.getElementById('dedicationModal');
        const modalMessage = document.getElementById('modalMessage');
        const popupAudio = document.getElementById('popupAudio');
        const popupAudioSource = document.getElementById('popupAudioSource');
        const modalSongTitle = document.getElementById('modalSongTitle');
        const modalSpotifyEmbed = document.getElementById('modalSpotifyEmbed');
        const audio = document.getElementById('bgMusic');
        const toggleBtn = document.getElementById('toggleMusicBtn');

        toggleBtn.addEventListener('click', () => {
            if (audio.paused) {
                audio.play();
                toggleBtn.textContent = '🔈';
            } else {
                audio.pause();
                toggleBtn.textContent = '🔇';
            }
        });

        function openModal(title, message, spotifyURL) {
            audio.pause();
            modalMessage.innerHTML = message;
            modalSongTitle.textContent = title;

            const audioFile = `${title.trim()}.mp3`.replaceAll(' ', '%20');
            popupAudioSource.src = `/audios/${audioFile}`;
            popupAudio.load();

            modalSpotifyEmbed.innerHTML = '';
            if (spotifyURL.includes('spotify.com')) {
                const matches = spotifyURL.match(/spotify\.com\/(track|album|playlist)\/([a-zA-Z0-9]+)/);
                if (matches) {
                    const type = matches[1];
                    const id = matches[2];
                    modalSpotifyEmbed.innerHTML = `
                    <iframe class="rounded-md w-full"
                        src="https://open.spotify.com/embed/${type}/${id}"
                        height="80" frameborder="0"
                        allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                        loading="lazy">
                    </iframe>
                `;
                }
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => popupAudio.play(), 100);
        }

        function closeModal() {
            popupAudio.pause();
            popupAudio.currentTime = 0;
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            audio.play();
        }

        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });

        document.querySelectorAll('.dedication-box').forEach(box => {
            box.addEventListener('click', () => {
                const title = box.dataset.title;
                const message = box.dataset.message;
                const spotifyURL = box.dataset.spotify;
                openModal(title, message, spotifyURL);
            });
        });

        let fallingConfetti;

        function startConfetti() {
            fallingConfetti = setInterval(() => {
                confetti({
                    particleCount: 15,
                    startVelocity: 0,
                    spread: 360,
                    ticks: 200,
                    origin: {
                        x: Math.random(),
                        y: -0.1
                    },
                    colors: ['#ffb6c1', '#ff69b4', '#ffc0cb', '#f48fb1'],
                    shapes: ['circle'],
                    scalar: 0.8
                });
            }, 300);
        }

        window.addEventListener('load', startConfetti);
    </script>

</body>

</html>
