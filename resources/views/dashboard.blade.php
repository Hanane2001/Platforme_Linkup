<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-[#1b1b18] dark:text-[#EDEDEC] leading-tight">
                    {{ __('Tableau de Bord') }}
                </h2>
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mt-1">
                    Bienvenue sur LINKUP - Connectez, partagez, découvrez
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    {{ now()->format('d M Y - H:i') }}
                </span>
                <div class="flex items-center text-sm text-green-600 dark:text-green-400">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                    Connecté
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Grille principale -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Colonne gauche - Carte profil -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Carte de bienvenue avec statistiques -->
                    <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.08)] dark:shadow-[inset_0px_0px_0px_1px_#3E3E3A] rounded-xl overflow-hidden">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                                <!-- Avatar et informations -->
                                <div class="flex-shrink-0">
                                    <div class="relative">
                                        @if(auth()->user()->profile_photo)
                                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                                 class="w-20 h-20 rounded-full object-cover shadow-lg border-2 border-white dark:border-[#161615]"
                                                 alt="{{ auth()->user()->name }}">
                                        @else
                                            <div class="w-20 h-20 bg-gradient-to-br from-[#4361EE] to-[#3A0CA3] dark:from-[#7209B7] dark:to-[#4361EE] rounded-full flex items-center justify-center shadow-lg">
                                                <span class="text-white text-2xl font-bold">
                                                    {{ substr(auth()->user()->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white dark:border-[#161615]"></div>
                                    </div>
                                </div>

                                <div class="flex-1 text-center md:text-left">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                                        <div>
                                            <h3 class="text-xl font-bold text-[#1b1b18] dark:text-white">
                                                Bonjour, {{ auth()->user()->name }} 👋
                                            </h3>
                                            @if(auth()->user()->pseudo)
                                                <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">
                                                    {{ auth()->user()->pseudo }}
                                                </p>
                                            @endif
                                            <p class="text-[#706f6c] dark:text-[#A1A09A] mt-2">
                                                @if(auth()->user()->bio)
                                                    {{ auth()->user()->bio }}
                                                @else
                                                    <span class="italic">Ajoutez une bio pour personnaliser votre profil</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Statistiques rapides -->
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                                        <div class="text-center p-3 bg-[#F8F9FA] dark:bg-[#1C1C1B] rounded-lg">
                                            <div class="text-2xl font-bold text-[#1b1b18] dark:text-white">
                                                {{ auth()->user()->friends()->count()}}
                                            </div>
                                            <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Amis</div>
                                        </div>
                                        <div class="text-center p-3 bg-[#F8F9FA] dark:bg-[#1C1C1B] rounded-lg">
                                            <div class="text-2xl font-bold text-[#1b1b18] dark:text-white">0</div>
                                            <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Messages</div>
                                        </div>
                                        <div class="text-center p-3 bg-[#F8F9FA] dark:bg-[#1C1C1B] rounded-lg">
                                            <div class="text-2xl font-bold text-[#1b1b18] dark:text-white">
                                                {{ auth()->user()->created_at->format('d/m') }}
                                            </div>
                                            <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Inscrit le</div>
                                        </div>
                                        <div class="text-center p-3 bg-[#F8F9FA] dark:bg-[#1C1C1B] rounded-lg">
                                            <div class="text-2xl font-bold text-[#1b1b18] dark:text-white">
                                                {{ auth()->user()->posts()->count() }}
                                            </div>
                                            <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Posts</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('posts._create')
                    <div class="space-y-4">
                        @foreach($posts as $post)
                            @include('posts._post', ['post' => $post])
                        @endforeach
                    </div>
                    <!-- Recherche rapide -->
                    <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.08)] dark:shadow-[inset_0px_0px_0px_1px_#3E3E3A] rounded-xl overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-white">
                                    🔍 Rechercher des membres
                                </h3>
                                <span class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                    Trouvez et connectez-vous
                                </span>
                            </div>
                            
                            <!-- Si vous avez une route pour la recherche -->
                            <form action="{{ route('dashboard') }}" method="GET" class="space-y-4">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-[#706f6c] dark:text-[#A1A09A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <input 
                                        type="search" 
                                        name="search"
                                        class="block w-full pl-10 pr-4 py-3 border-0 bg-[#F8F9FA] dark:bg-[#1C1C1B] text-[#1b1b18] dark:text-white placeholder-[#A1A09A] rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Rechercher par pseudo, nom ou email..."
                                        value="{{ request('search') }}"
                                    >
                                </div>
                                <div class="flex justify-end space-x-3">
                                    @if(request('search'))
                                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                            Annuler
                                        </a>
                                    @endif
                                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] hover:from-[#3A0CA3] hover:to-[#4361EE] text-white font-medium rounded-lg transition-all duration-200 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        Rechercher
                                    </button>
                                </div>
                            </form>

                            <!-- Résultats de recherche (conditionnel) -->
                            @if(request('search'))
                                <div class="mt-6">
                                    <h4 class="font-medium text-[#1b1b18] dark:text-white mb-3">
                                        Résultats pour "{{ request('search') }}"
                                    </h4>
                                    <div class="space-y-3">
                                        @if($users && $users->count() > 0)
                                            @foreach($users->take(3) as $user)
                                                <div class="flex items-center p-3 bg-[#F8F9FA] dark:bg-[#1C1C1B] rounded-lg">
                                                    @if($user->profile_photo)
                                                        <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                                             class="w-10 h-10 rounded-full object-cover mr-3"
                                                             alt="{{ $user->name }}">
                                                    @else
                                                        <div class="w-10 h-10 bg-gradient-to-br from-[#4361EE] to-[#3A0CA3] rounded-full flex items-center justify-center mr-3">
                                                            <span class="text-white text-sm font-bold">
                                                                {{ substr($user->name, 0, 1) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    <div class="flex-1">
                                                        <div class="font-medium text-[#1b1b18] dark:text-white">
                                                            {{ $user->name }}
                                                            @if($user->pseudo)
                                                                <span class="text-sm text-blue-600 dark:text-blue-400 ml-2">
                                                                    {{ $user->pseudo }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                                            {{ $user->email }}
                                                        </div>
                                                    </div>
                                                    @if($user->id !== auth()->id())
                                                        <form method="POST" action="{{ route('friends.send', $user) }}">
                                                            @csrf
                                                            <button
                                                                class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-lg hover:bg-green-200">
                                                                Ajouter en ami
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @endforeach
                                            @if($users->count() > 3)
                                                <div class="text-center">
                                                    <a href="#" class="text-blue-600 dark:text-blue-400 text-sm hover:underline">
                                                        Voir les {{ $users->count() - 3 }} autres résultats →
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-center py-4 text-[#706f6c] dark:text-[#A1A09A]">
                                                Aucun utilisateur trouvé
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Colonne droite - Actions rapides -->
                <div class="space-y-6">
                    <!-- Actions rapides -->
                    <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.08)] dark:shadow-[inset_0px_0px_0px_1px_#3E3E3A] rounded-xl overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-white mb-4">
                                ⚡ Actions rapides
                            </h3>
                            <div class="space-y-3">
                                <a href="{{ route('profile.edit') }}" class="flex items-center p-3 hover:bg-[#F8F9FA] dark:hover:bg-[#1C1C1B] rounded-lg transition-colors group">
                                    <div class="w-10 h-10 flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-medium text-[#1b1b18] dark:text-white">Modifier le profil</div>
                                        <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Photo, bio, informations</div>
                                    </div>
                                    <svg class="w-5 h-5 text-[#706f6c] dark:text-[#A1A09A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                                <!-- Lien pour voir tous les utilisateurs (si vous avez cette route) -->
                                @if(Route::has('users.index'))
                                    <a href="{{ route('users.index') }}" class="flex items-center p-3 hover:bg-[#F8F9FA] dark:hover:bg-[#1C1C1B] rounded-lg transition-colors group">
                                        <div class="w-10 h-10 flex items-center justify-center bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13-7.25a10.001 10.001 0 01-7.916 9.799"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-medium text-[#1b1b18] dark:text-white">Tous les membres</div>
                                            <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Voir la communauté</div>
                                        </div>
                                        <svg class="w-5 h-5 text-[#706f6c] dark:text-[#A1A09A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->receiveFriendRequests->where('status','pending')->count())
                        <div class="bg-white dark:bg-[#161615] rounded-xl shadow p-6 text-white">
                                <h3 class="text-lg font-semibold mb-4"> Demandes d’amis</h3>

                                <div class="space-y-3">
                                    @foreach(auth()->user()->receiveFriendRequests->where('status','pending') as $request)
                                        <div class="flex items-center justify-between p-3 bg-[#F8F9FA] dark:bg-[#1C1C1B] rounded-lg">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center">
                                                    {{ substr($request->sender->name, 0, 1) }}
                                                </div>
                                                <span class="font-medium">
                                                    {{ $request->sender->name }}
                                                </span>
                                            </div>

                                            <div class="flex gap-2">
                                                <form method="POST" action="{{ route('friends.accept', $request->id) }}">
                                                    @csrf
                                                    <button class="px-2 py-1 text-sm bg-green-100 text-green-700 rounded">
                                                        Accepter
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('friends.reject', $request->id) }}">
                                                    @csrf
                                                    <button class="px-2 py-1 text-sm bg-red-100 text-red-700 rounded">
                                                        Refuser
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    @if(auth()->user()->friends()->count())
                        <div class="bg-white dark:bg-[#161615] rounded-xl shadow p-6 text-white overflow-y-auto">
                            <h3 class="text-lg font-semibold mb-4">👥 Mes amis ({{ auth()->user()->friends()->count() }})</h3>

                            <div class="space-y-3">
                                @foreach(auth()->user()->friends() as $friend)
                                    <div class="flex items-center gap-3 p-3 bg-[#F8F9FA] dark:bg-[#1C1C1B] rounded-lg">
                                        <div class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center bg-blue-500 text-white">
                                            @if($friend->profile_photo)
                                                <img src="{{ asset('storage/' . $friend->profile_photo) }}" class="w-full h-full object-cover">
                                            @else
                                                {{ strtoupper(substr($friend->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-medium text-[#1b1b18] dark:text-white">
                                                {{ $friend->name }}
                                            </p>
                                            @if($friend->pseudo)
                                                <p class="text-sm text-blue-500">{{ $friend->pseudo }}</p>
                                            @endif
                                        </div>
                                        <a href="{{ route('users.show', $friend->id) }}" class="ml-auto px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
                                            Voir profil
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Progression du profil -->
                    <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.08)] dark:shadow-[inset_0px_0px_0px_1px_#3E3E3A] rounded-xl overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-white mb-4">
                                📊 Progression du profil
                            </h3>
                            <div class="space-y-4">
                                @php
                                    $completion = 0;
                                    $totalItems = 4;
                                    
                                    // Calcul du pourcentage de complétion
                                    if(auth()->user()->profile_photo) $completion += 20;
                                    if(auth()->user()->bio) $completion += 20;
                                    if(auth()->user()->pseudo) $completion += 20;
                                    if(auth()->user()->name && auth()->user()->email) $completion += 40;
                                @endphp
                                
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-[#1b1b18] dark:text-white">Complétude</span>
                                        <span class="font-medium text-blue-600 dark:text-blue-400">{{ $completion }}%</span>
                                    </div>
                                    <div class="w-full bg-[#F8F9FA] dark:bg-[#1C1C1B] rounded-full h-2">
                                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full" style="width: {{ $completion }}%"></div>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    @php
                                        $profileItems = [
                                            ['completed' => auth()->user()->profile_photo, 'label' => 'Photo de profil'],
                                            ['completed' => auth()->user()->bio, 'label' => 'Bio complétée'],
                                            ['completed' => auth()->user()->pseudo, 'label' => 'Pseudo défini'],
                                            ['completed' => auth()->user()->name && auth()->user()->email, 'label' => 'Infos de base'],
                                        ];
                                    @endphp
                                    
                                    @foreach($profileItems as $item)
                                        <div class="flex items-center">
                                            <div class="w-6 h-6 flex items-center justify-center rounded-full mr-3 {{ $item['completed'] ? 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400' : 'bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400' }}">
                                                {{ $item['completed'] ? '✓' : '!' }}
                                            </div>
                                            <span class="text-sm text-[#1b1b18] dark:text-white {{ $item['completed'] ? '' : 'opacity-70' }}">
                                                {{ $item['label'] }}
                                            </span>
                                            @if(!$item['completed'])
                                                <a href="{{ route('profile.edit') }}" class="ml-auto text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                                    Compléter
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dernières activités -->
                    <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.08)] dark:shadow-[inset_0px_0px_0px_1px_#3E3E3A] rounded-xl overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-white mb-4">
                                📅 Dernières activités
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center text-sm">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                    <span class="text-[#706f6c] dark:text-[#A1A09A]">Connexion réussie</span>
                                    <span class="ml-auto text-[#706f6c] dark:text-[#A1A09A]">Aujourd'hui</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-[#706f6c] dark:text-[#A1A09A]">Profil mis à jour</span>
                                    <span class="ml-auto text-[#706f6c] dark:text-[#A1A09A]">
                                        {{ auth()->user()->updated_at->diffForHumans() }}
                                    </span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                                    <span class="text-[#706f6c] dark:text-[#A1A09A]">Compte créé</span>
                                    <span class="ml-auto text-[#706f6c] dark:text-[#A1A09A]">
                                        {{ auth()->user()->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>