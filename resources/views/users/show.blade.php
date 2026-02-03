<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 dark:from-[#0f0f0e] dark:to-[#1a1a18] py-8 px-4">
        <div class="max-w-4xl mx-auto">
            
            <!-- Bouton Retour au Dashboard -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200 group">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-200" 
                         fill="none" 
                         stroke="currentColor" 
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" 
                              stroke-linejoin="round" 
                              stroke-width="2" 
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="font-medium">Retour au dashboard</span>
                </a>
            </div>

            <!-- Header avec effet de profondeur -->
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10 dark:from-blue-500/5 dark:to-purple-500/5 rounded-2xl blur-xl"></div>
                
                <div class="relative bg-white/80 dark:bg-[#161615]/90 backdrop-blur-sm rounded-2xl p-8 shadow-2xl shadow-blue-500/5 dark:shadow-black/30 border border-white/20 dark:border-white/5">
                    
                    <!-- Avatar avec animation au hover -->
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full blur opacity-25 group-hover:opacity-75 transition duration-500"></div>
                            <div class="relative w-24 h-24 rounded-full overflow-hidden ring-4 ring-white dark:ring-[#161615]">
                                @if($user->profile_photo)
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                        <span class="text-3xl font-bold text-white">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            @if($user->is_verified)
                                <div class="absolute bottom-2 right-2 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Informations utilisateur -->
                        <div class="flex-1 text-center md:text-left">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div>
                                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                        <br>
                                        @if($user->pseudo)
                                            <span class="text-blue-500 dark:text-blue-400 font-medium ml-2">
                                                {{ $user->pseudo }}
                                            </span>
                                        @endif
                                    </h1>
                                </div>
                                
                                <!-- Boutons d'action -->
                                <div class="flex gap-3 justify-center md:justify-end">
                                    @if(auth()->id() === $user->id)
                                        <a href="{{ route('profile.edit') }}"
                                        class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg">
                                            Modifier
                                        </a>
                                    @elseif(auth()->user()->isFriendWith($user))
                                        <span class="px-4 py-2 bg-green-500 text-white rounded-lg">
                                            ✔ Ami
                                        </span>

                                        <a href="{{ route('messages.create', $user) }}"
                                        class="px-4 py-2 border border-blue-500 text-blue-500 rounded-lg">
                                            Message
                                        </a>
                                        <form method="POST" action="{{ route('friends.remove', $user) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                                Supprimer Ami
                                            </button>
                                        </form>
                                    @elseif(auth()->user()->hasPendingRequestTo($user))
                                        <span class="px-4 py-2 bg-yellow-400 text-white rounded-lg">
                                            Demande envoyée
                                        </span>
                                    @else
                                        <form method="POST" action="{{ route('friends.request', $user) }}">
                                            @csrf
                                            <button
                                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                                Ajouter en ami
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="flex justify-center md:justify-start gap-6 mt-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->friends()->count() }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">amis</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">1.2K</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">posts</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bio -->
                    <div class="mt-8 pt-8 border-t border-gray-100 dark:border-gray-800">
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">
                            À propos
                        </h3>
                        <div class="prose prose-blue dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
                                {{ $user->bio ?? 'Cet utilisateur n\'a pas encore rédigé de bio.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section de contenu -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <div class="bg-white/80 dark:bg-[#161615]/90 backdrop-blur-sm rounded-2xl p-6 shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Publications récentes</h3>
                        
                    </div>
                </div>
                
                <div>
                    <div class="bg-white/80 dark:bg-[#161615]/90 backdrop-blur-sm rounded-2xl p-6 shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Intérêts</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>