<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Recognition System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;800&family=Outfit:wght@300;400;600;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            filter: blur(80px);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.15;
            animation: move 20s infinite alternate;
        }

        @keyframes move {
            from {
                transform: translate(-10%, -10%) scale(1);
            }

            to {
                transform: translate(20%, 20%) scale(1.2);
            }
        }

        .hero-text {
            background: linear-gradient(to right, #fff, var(--color-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="font-['Outfit'] overflow-hidden relative">
    <!-- Background Blobs -->
    <div class="blob top-[-10%] right-[-10%]" style="animation-delay: -5s;"></div>
    <div class="blob bottom-[-10%] left-[-10%]"></div>

    <div class="min-h-screen flex flex-col">
        <header class="p-6 flex justify-between items-center max-w-7xl mx-auto w-full">
            <div class="text-2xl font-bold tracking-tighter flex items-center gap-2">
                <div
                    class="w-8 h-8 rounded-lg bg-gradient-to-tr from-primary to-secondary flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
                <span>AG <span class="text-primary">AI</span></span>
            </div>

            <nav class="flex gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-premium-outline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 hover:text-primary transition-colors">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-premium">Get Started</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </header>

        <main class="flex-1 flex items-center justify-center px-6">
            <div class="max-w-4xl w-full text-center">
                <div
                    class="inline-block px-4 py-1.5 mb-8 glass-card border-accent/20 text-accent text-sm font-medium tracking-wide uppercase">
                    Advanced Face & Voice Recognition
                </div>

                <h1 class="text-6xl md:text-8xl font-extrabold mb-8 hero-text leading-tight">
                    Secure Intelligence <br> For The Future.
                </h1>

                <p class="text-xl text-gray-400 mb-12 max-w-2xl mx-auto leading-relaxed">
                    A high-performance AI integration project leveraging state-of-the-art neural networks for real-time
                    authentication and security.
                </p>

                <div class="flex flex-col sm:row gap-6 justify-center">
                    <button onclick="openScanner()" class="btn-premium !px-10 !py-4 text-lg">
                        Launch Neural Scanner
                    </button>
                    <a href="#" class="btn-premium-outline !px-10 !py-4 text-lg">
                        View Documentation
                    </a>
                </div>

                <!-- Floating Features -->
                <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="glass-card p-8 text-left hover:border-primary/50 transition-colors">
                        <div class="w-12 h-12 rounded-xl bg-primary/20 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Neural Encoding</h3>
                        <p class="text-gray-400">Deep learning models for high-precision face biometric encoding.</p>
                    </div>

                    <div class="glass-card p-8 text-left hover:border-secondary/50 transition-colors">
                        <div class="w-12 h-12 rounded-xl bg-secondary/20 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Voice Biometrics</h3>
                        <p class="text-gray-400">Integrated voice analysis for multi-factor authentication.</p>
                    </div>

                    <div class="glass-card p-8 text-left hover:border-accent/50 transition-colors">
                        <div class="w-12 h-12 rounded-xl bg-accent/20 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Real-time Inference</h3>
                        <p class="text-gray-400">Optimized Python endpoints for sub-second recognition latency.</p>
                    </div>
                </div>
            </div>
        </main>

        <footer class="p-8 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} AG AI Systems. All rights reserved.
        </footer>
    </div>

    <!-- Scanner Modal -->
    <div id="scannerModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6 sm:p-24 overflow-hidden">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-md" onclick="closeScanner()"></div>

        <div class="glass-card max-w-2xl w-full relative z-10 overflow-hidden flex flex-col p-1 top-accent">
            <div class="bg-surface-base/40 rounded-[calc(1rem-1px)] p-10 flex flex-col h-full">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-3xl font-bold hero-text">Identity Scanner</h2>
                        <p class="text-gray-400">Align face within the frame</p>
                    </div>
                    <button onclick="closeScanner()" class="p-2 hover:bg-white/10 rounded-full transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Video Container -->
                <div class="relative rounded-2xl overflow-hidden bg-black aspect-video border border-white/10 group">
                    <video id="video" class="w-full h-full object-cover grayscale-[0.2]" autoplay playsinline muted></video>

                    <!-- HUD Overlays -->
                    <div class="absolute inset-0 pointer-events-none">
                        <div
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 border-2 border-primary/20 rounded-full animate-ping">
                        </div>
                        <div
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 border-2 border-primary/40 rounded-full border-dashed">
                        </div>

                        <!-- Recognition Indicator -->
                        <div id="statusIndicator"
                            class="absolute bottom-6 left-1/2 -translate-x-1/2 px-4 py-1.5 rounded-full bg-black/60 backdrop-blur-sm border border-white/20 text-xs font-bold tracking-widest uppercase text-white/60">
                            System Ready
                        </div>
                    </div>

                    <!-- Scan Line -->
                    <div id="scanLine"
                        class="absolute top-0 left-0 w-full h-1 bg-primary/50 shadow-[0_0_15px_var(--color-primary)] hidden">
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button id="scanBtn" onclick="performScan()"
                        class="btn-premium flex-1 !py-4 flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Scan Identity
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Canvas -->
    <canvas id="canvas" class="hidden"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const modal = document.getElementById('scannerModal');
        const statusInd = document.getElementById('statusIndicator');
        const scanLine = document.getElementById('scanLine');
        const scanBtn = document.getElementById('scanBtn');
        let stream = null;

        async function openScanner() {
            // 1. Open UI immediately for better context
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            statusInd.textContent = "Initializing Camera...";

            // 2. Check for Secure Context
            if (!window.isSecureContext) {
                statusInd.textContent = "Security Error";
                alert("Camera access requires a Secure Context (HTTPS or localhost). Please access via http://localhost:8000 instead of 127.0.0.1 if possible.");
                return;
            }

            try {
                // 3. Request Camera
                const constraints = { 
                    video: { 
                        facingMode: 'user',
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    } 
                };

                console.log("Requesting camera with constraints:", constraints);
                stream = await navigator.mediaDevices.getUserMedia(constraints);
                console.log("Stream received:", stream);

                // 4. Bind to Video Element
                video.srcObject = stream;
                
                // 5. Handle Playback with fallback
                try {
                    await video.play();
                    console.log("Video playing successfully");
                } catch (playError) {
                    console.warn("Autoplay was prevented. User interaction might be required.", playError);
                    statusInd.textContent = "Click 'Scan' to start";
                }

                statusInd.textContent = "System Ready";
                speak("Biometric system online. Please align your face.");
            } catch (err) {
                console.error("Camera initialization failed:", err);
                statusInd.textContent = "Hardware Error";
                statusInd.classList.replace('text-white/60', 'text-red-400');
                
                let msg = "Camera access denied or unavailable.";
                if (err.name === 'NotAllowedError') msg = "Camera permission was denied.";
                if (err.name === 'NotFoundError') msg = "No camera hardware found.";
                
                alert(msg + " Reference: " + err.message);
            }
        }

        function closeScanner() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            statusInd.textContent = "System Ready";
            if (statusInd.classList.contains('text-primary')) statusInd.classList.replace('text-primary', 'text-white/60');
            if (statusInd.classList.contains('text-red-400')) statusInd.classList.replace('text-red-400', 'text-white/60');
        }

        async function performScan() {
            // Visual feedback
            scanLine.classList.remove('hidden');
            scanLine.animate([
                { top: '0%' },
                { top: '100%' }
            ], { duration: 1500, iterations: 1 });

            statusInd.textContent = "Processing...";
            scanBtn.disabled = true;
            scanBtn.classList.add('opacity-50');

            // Capture frame
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            const imageData = canvas.toDataURL('image/png');

            try {
                const response = await axios.post('/api/scan', { image: imageData });
                console.log("Scan Result:", response.data);

                if (response.data.status === 'success') {
                    const person = response.data;
                    statusInd.textContent = "Verified: " + person.name;
                    statusInd.classList.replace('text-white/60', 'text-primary');
                    speak("Access granted. Welcome, " + person.name + ". " + (person.details ? person.details : ""));
                } else {
                    const msg = response.data.message || "Unknown Identity";
                    statusInd.textContent = msg;
                    statusInd.classList.replace('text-white/60', 'text-red-400');
                    speak("Access denied. " + msg);
                }
            } catch (err) {
                console.error("Scan error details:", err);
                const errorDetail = err.response?.data?.message || err.message || "Neural link failure.";
                statusInd.textContent = "System Error";
                if(statusInd.classList.contains('text-white/60')) statusInd.classList.replace('text-white/60', 'text-red-400');
                
                speak("Attention. System error detected. " + errorDetail);
                alert("SYSTEM ERROR: " + errorDetail);
            } finally {
                setTimeout(() => {
                    scanLine.classList.add('hidden');
                    scanBtn.disabled = false;
                    scanBtn.classList.remove('opacity-50');
                }, 2000);
            }
        }

        function speak(text) {
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.rate = 0.9;
            utterance.pitch = 1.1;
            window.speechSynthesis.speak(utterance);
        }
    </script>
</body>

</html>