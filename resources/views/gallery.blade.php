<!DOCTYPE html>
<html lang="en">

<head>
    <title>Memory Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #fff1f2;
            /* Soft pink */
            overflow-x: hidden;
        }

        .firework {
            position: absolute;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: radial-gradient(circle, #f472b6 0%, transparent 70%);
            animation: explode 1.5s ease-out infinite;
            opacity: 0.8;
        }

        @keyframes explode {
            0% {
                transform: scale(0.5);
                opacity: 1;
            }

            100% {
                transform: scale(10);
                opacity: 0;
            }
        }

        .fireworks-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .fireworks-wrapper .firework:nth-child(1) {
            top: 20%;
            left: 25%;
            animation-delay: 0s;
        }

        .fireworks-wrapper .firework:nth-child(2) {
            top: 40%;
            left: 70%;
            animation-delay: 0.5s;
        }

        .fireworks-wrapper .firework:nth-child(3) {
            top: 10%;
            left: 50%;
            animation-delay: 1s;
        }

        .fireworks-wrapper .firework:nth-child(4) {
            top: 60%;
            left: 30%;
            animation-delay: 1.3s;
        }

        .fireworks-wrapper .firework:nth-child(5) {
            top: 80%;
            left: 80%;
            animation-delay: 1.2s;
        }

        .flower-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            pointer-events: none;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .flower {
            position: absolute;
            top: -50px;
            font-size: 24px;
            animation-name: fall;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
        }

        @keyframes fall {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
</head>

<body class="relative min-h-screen p-6">
    <a href="{{ route('dedication.search') }}"
        class="fixed top-4 left-4 z-50 bg-white text-pink-600 border border-pink-300 font-semibold px-4 py-2 rounded-xl shadow-lg hover:bg-pink-100 transition-all text-[13px]">
        <i class="fa-solid fa-arrow-left"></i> Back to Dedications
    </a>
    <!-- Fireworks -->
    <div class="fireworks-wrapper">
        <div class="firework"></div>
        <div class="firework"></div>
        <div class="firework"></div>
        <div class="firework"></div>
        <div class="firework"></div>
    </div>

    <!-- Falling Flowers -->
    <div class="flower-wrapper" id="flowerWrapper"></div>



    <!-- Content -->
    <div class="relative z-10 max-w-6xl mx-auto">
        <h2 class="text-4xl font-extrabold text-pink-600  text-center drop-shadow-lg">🌸Our Memory Gallery🌸</h2>
        <p class="text-[16px] font-extrabold text-pink-300 mb-10 drop-shadow-sm text-center">Posting random memory pics...</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($photos as $photo)
                <div
                    class="bg-white bg-opacity-80 backdrop-blur-md border-2 border-pink-200 hover:border-pink-400 rounded-[30px] overflow-hidden transition-transform transform hover:scale-105 shadow-[0_6px_20px_rgba(255,192,203,0.4)] hover:shadow-2xl duration-300 group">
                    <div class="overflow-hidden">
                        <img src="{{ $photo->base64_image }}" alt="Memory"
                            class="w-full h-64 object-cover transition duration-300 ease-in-out group-hover:scale-100">
                    </div>
                    @if ($photo->caption)
                        <div class="p-4">
                            <p class="text-sm text-gray-700 italic text-center group-hover:text-pink-500 transition">
                                {{ $photo->caption }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <script>
        const flowerWrapper = document.getElementById('flowerWrapper');
        const flowerCount = 50; 

        for (let i = 0; i < flowerCount; i++) {
            const flower = document.createElement('div');
            flower.classList.add('flower');
            flower.textContent = '🌸';

            
            flower.style.left = `${Math.random() * 100}vw`;

            
            flower.style.animationDuration = `${5 + Math.random() * 8}s`;

      
            flower.style.animationDelay = `${Math.random() * 10}s`;

           
            const scale = 0.8 + Math.random() * 1.2;
            flower.style.transform = `scale(${scale})`;

            flowerWrapper.appendChild(flower);
        }
    </script>

</body>

</html>
