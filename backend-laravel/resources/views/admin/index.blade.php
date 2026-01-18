<x-app-layout>
    <div class="max-w-7xl mx-auto py-12 px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
            <div>
                <h1 class="text-5xl font-extrabold hero-text mb-4">Neural Database</h1>
                <p class="text-gray-400 text-lg">Manage registered biometric identities</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.person.create') }}" class="btn-premium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Enroll New identity
                </a>
                <a href="{{ url('/') }}" class="btn-premium-outline">Home</a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 rounded-xl bg-primary/10 border border-primary/20 text-primary animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($people as $person)
                <div class="glass-card group overflow-hidden flex flex-col p-1 top-accent">
                    <div class="bg-surface-base/40 rounded-[calc(1rem-1px)] p-6 flex flex-col h-full">
                        <div class="relative w-full aspect-square rounded-xl overflow-hidden mb-6 border border-white/10">
                            <img src="{{ asset('storage/' . $person->photo) }}" alt="{{ $person->name }}"
                                class="w-full h-full object-cover grayscale-[0.3] group-hover:grayscale-0 transition-all duration-500">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-60">
                            </div>
                            <div class="absolute bottom-4 left-4">
                                <span
                                    class="px-3 py-1 bg-primary/20 backdrop-blur-md border border-primary/30 rounded-full text-[10px] font-bold tracking-widest uppercase text-primary">Biometric
                                    Active</span>
                            </div>
                        </div>

                        <h3 class="text-2xl font-bold mb-2 capitalize">{{ $person->name }}</h3>
                        <p class="text-gray-400 text-sm mb-6 flex-1">
                            {{ $person->details ?: 'No additional neural data recorded.' }}
                        </p>

                        <div class="flex gap-3">
                            <form action="{{ route('admin.person.destroy', $person) }}" method="POST" class="flex-1"
                                onsubmit="return confirm('WARNING: This will permanently delete this identity and its biometric signature. Proceed?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full py-3 rounded-xl border border-red-500/30 text-red-400 hover:bg-red-500/10 transition-colors text-sm font-bold tracking-wide uppercase">
                                    Terminate Record
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-24 text-center glass-card border-dashed">
                    <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">No Identities Found</h3>
                    <p class="text-gray-400 mb-8">The neural database is currently empty.</p>
                    <a href="{{ route('admin.person.create') }}" class="btn-premium">Start Enrollment</a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>