<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MEDIA SYSTEM SMS API') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Add AOS library for scroll animations -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .floating { animation: float 6s ease-in-out infinite; }
        .gradient-text {
            background: linear-gradient(45deg, #3490dc, #6574cd);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .particle {
            position: absolute;
            border-radius: 50%;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-blue-100 to-indigo-200 dark:from-gray-800 dark:to-indigo-900">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Left section with animated background -->
        <div class="w-full md:w-1/2 bg-gradient-to-br from-blue-800 to-indigo-600 dark:from-blue-900 dark:to-indigo-900 relative overflow-hidden">
            <div class="absolute inset-0 opacity-20" id="particles"></div>
            <div class="flex items-center justify-center h-full relative z-10">
                <div class="text-white p-8 text-center" data-aos="fade-up">
                    <h2 class="text-4xl font-bold mb-6 gradient-text">Welcome to MEDIA SYSTEM SMS API</h2>
                    <p class="mb-4 text-lg">Revolutionize your communication with our cutting-edge SMS solutions.</p>
                    <p class="mb-6">Seamless integration, powerful features, and unparalleled reliability.</p>
                    <div class="mt-8 space-y-4">
                        <div class="flex items-center justify-center space-x-2" data-aos="fade-up" data-aos-delay="200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            <span>Lightning-fast delivery</span>
                        </div>
                        <div class="flex items-center justify-center space-x-2" data-aos="fade-up" data-aos-delay="400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <span>Bank-grade security</span>
                        </div>
                        <div class="flex items-center justify-center space-x-2" data-aos="fade-up" data-aos-delay="600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            <span>Real-time analytics</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right section for the form -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md bg-white dark:bg-gray-800 shadow-2xl rounded-lg overflow-hidden" data-aos="fade-left">
                <div class="p-8">
                    <!-- Animated logo -->
                    <div class="flex justify-center mb-6">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-24 h-24 floating" />
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
        });

        // Particle animation
        function createParticle() {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            const size = Math.random() * 5 + 2;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            particle.style.background = `hsl(${Math.random() * 60 + 200}, 100%, 70%)`;
            particle.style.left = `${Math.random() * 100}%`;
            particle.style.top = `${Math.random() * 100}%`;
            document.getElementById('particles').appendChild(particle);

            gsap.to(particle, {
                y: `${Math.random() * 200 - 100}%`,
                x: `${Math.random() * 200 - 100}%`,
                opacity: 0,
                duration: Math.random() * 3 + 2,
                ease: "power1.out",
                onComplete: () => {
                    particle.remove();
                    createParticle();
                }
            });
        }

        for (let i = 0; i < 50; i++) {
            createParticle();
        }
    </script>
</body>
</html>