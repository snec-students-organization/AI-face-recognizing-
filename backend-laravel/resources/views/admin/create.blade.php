<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin – Add Person | AG AI</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;800&family=Outfit:wght@300;400;600;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-['Outfit'] min-h-screen flex items-center justify-center p-6 relative">
    <!-- Animated Background Elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-secondary/20 rounded-full blur-[120px]">
        </div>
    </div>

    <div class="max-w-2xl w-full">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h2 class="text-3xl font-bold hero-text">Neural Enrollment</h2>
                <p class="text-gray-400">Register new biometric identity to the system</p>
            </div>
            <div class="flex gap-4 w-full md:w-auto">
                <a href="{{ route('admin.person.index') }}" class="btn-premium-outline flex-1 md:flex-none text-center">
                    Manage Database
                </a>
                <a href="{{ url('/') }}" class="btn-premium-outline flex-1 md:flex-none text-center">
                    Home
                </a>
                <form action="{{ route('logout') }}" method="POST" class="flex-1 md:flex-none">
                    @csrf
                    <button type="submit"
                        class="btn-premium-outline !py-2 !px-4 text-sm flex items-center gap-2 group hover:!border-red-500/50 hover:!text-red-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="glass-card p-1 top-accent">
            <div class="bg-surface-base/40 rounded-[calc(1rem-1px)] p-10 relative overflow-hidden">
                <!-- Decorative Accent -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-accent/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>

                <div class="relative z-10">
                    <h2 class="text-3xl font-bold mb-2">Register Person</h2>
                    <p class="text-gray-400 mb-8 border-b border-white/10 pb-6">Add a new person to the neural database
                        for
                        recognition.</p>

                    @if(session('success'))
                        <div
                            class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/50 text-green-400 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div
                            class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/50 text-red-400 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/50 text-red-400">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/admin/person/store" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-300">Full Name</label>
                            <input type="text" name="name" required placeholder="Enter primary name"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/50 transition-all placeholder:text-gray-600">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-300">Facial Data (Photo)</label>
                            <div class="relative group">
                                <input type="file" name="photo" required
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                <div
                                    class="w-full bg-white/5 border border-dashed border-white/20 rounded-xl px-4 py-8 flex flex-col items-center justify-center group-hover:border-primary/50 transition-colors">
                                    <svg class="w-10 h-10 text-gray-500 mb-2 group-hover:text-primary transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="text-gray-400 group-hover:text-white transition-colors">Click or drag
                                        photo
                                        here</span>
                                    <span class="text-xs text-gray-500 mt-1 uppercase tracking-widest">JPG, PNG,
                                        WEBP</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-300">Biometric Details (Optional)</label>
                            <textarea name="details" rows="3" placeholder="Voice characteristics or metadata..."
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/50 transition-all placeholder:text-gray-600"></textarea>
                        </div>

                        <button type="submit" class="btn-premium w-full !rounded-xl !py-4 text-lg font-bold mt-4">
                            Initialize Neural Encoding
                        </button>
                    </form>
                </div>
            </div>

            <p class="text-center text-gray-500 text-xs mt-8 uppercase tracking-[0.2em]">
                Secured by AG AI Biometric Module v1.0
            </p>
        </div>
</body>

</html>