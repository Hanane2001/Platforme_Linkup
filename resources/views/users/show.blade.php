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
                                        class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                            Modifier le profil
                                        </a>
                                    @elseif(auth()->user()->isFriendWith($user))
                                        <span class="px-4 py-2 bg-green-500 text-white rounded-lg flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Ami
                                        </span>

                                        <a href="{{ route('messages.create', $user) }}"
                                        class="px-4 py-2 border border-blue-500 text-blue-500 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                            Message
                                        </a>
                                        <form method="POST" action="{{ route('friends.remove', $user) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                                Supprimer
                                            </button>
                                        </form>
                                    @elseif(auth()->user()->hasPendingRequestTo($user))
                                        <span class="px-4 py-2 bg-yellow-500 text-white rounded-lg flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            En attente
                                        </span>
                                    @else
                                        <form method="POST" action="{{ route('friends.request', $user) }}" class="inline">
                                            @csrf
                                            <button
                                                class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                                Ajouter en ami
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="flex justify-center md:justify-start gap-8 mt-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->friends()->count() }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">amis</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->posts()->count() }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">publications</div>
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
                    <!-- Formulaire de création de post (seulement si c'est le profil de l'utilisateur connecté) -->
                    @if(auth()->id() === $user->id)
                    <div class="bg-white/80 dark:bg-[#161615]/90 backdrop-blur-sm rounded-2xl p-6 shadow-lg mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Créer une publication</h3>
                        
                        <!-- Formulaire de création de post -->
                        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-[#161615] dark:to-[#1a1a19] rounded-xl shadow p-6 border border-gray-200 dark:border-gray-800">
                            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                
                                <!-- Zone de texte -->
                                <div class="relative">
                                    <textarea
                                        name="description"
                                        rows="3"
                                        class="w-full p-4 rounded-lg bg-gray-50 dark:bg-[#1C1C1B] border border-gray-200 dark:border-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                                        placeholder="Quoi de neuf ?"
                                    ></textarea>
                                </div>

                                <!-- Upload d'image et bouton -->
                                <div class="flex items-center justify-between">
                                    <div x-data="{ preview: null }">
                                        <label class="cursor-pointer">
                                            <input type="file" 
                                                   name="post_photo" 
                                                   class="hidden"
                                                   accept="image/*"
                                                   @change="
                                                       const file = $event.target.files[0];
                                                       if (file) {
                                                           const reader = new FileReader();
                                                           reader.onload = (e) => preview = e.target.result;
                                                           reader.readAsDataURL(file);
                                                       }
                                                   ">
                                            <div class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span class="text-sm text-gray-600 dark:text-gray-400">Ajouter une photo</span>
                                            </div>
                                        </label>
                                        
                                        <!-- Prévisualisation -->
                                        <div x-show="preview" 
                                             x-transition
                                             class="mt-2 relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-800">
                                            <img :src="preview" 
                                                 alt="Preview" 
                                                 class="w-full h-32 object-cover">
                                            <button type="button"
                                                    @click="preview = null; $refs.fileInput.value = ''"
                                                    class="absolute top-2 right-2 p-1 bg-red-600 text-white rounded-full hover:bg-red-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <button type="submit"
                                            class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all shadow-md hover:shadow-lg">
                                        Publier
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                    <!-- Affichage des publications -->
                    <div class="bg-white/80 dark:bg-[#161615]/90 backdrop-blur-sm rounded-2xl p-6 shadow-lg">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                Publications
                                @if($user->posts()->count() > 0)
                                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-2">
                                        ({{ $user->posts()->count() }})
                                    </span>
                                @endif
                            </h3>
                        </div>
                        
                        <!-- Liste des publications -->
                        <div class="space-y-4">
                            @forelse($user->posts()->latest()->get() as $post)
                            <div class="bg-white dark:bg-[#1C1C1B] rounded-xl p-4 shadow border border-gray-100 dark:border-gray-800 hover:shadow-md transition-shadow duration-200">
                                <!-- En-tête du post -->
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="relative w-15 h-15 rounded-full overflow-hidden ring-4 ring-white dark:ring-[#161615]">
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
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-semibold text-gray-900 dark:text-white">
                                                {{ $user->name }}
                                            </h4>
                                            @if($user->pseudo)
                                            <span class="text-xs px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full">
                                                {{ $user->pseudo }}
                                            </span>
                                            @endif
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $post->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    
                                    <!-- Bouton supprimer (seulement pour l'auteur) -->
                                    @if($post->user_id === auth()->id())
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" 
                                          x-data="{ confirmDelete: false }"
                                          class="relative">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <div x-show="confirmDelete" 
                                             x-transition
                                             class="absolute right-0 top-full mt-2 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3 shadow-lg z-10">
                                            <p class="text-sm text-red-700 dark:text-red-300 mb-2">Supprimer ce post ?</p>
                                            <div class="flex gap-2">
                                                <button type="button" 
                                                        @click="confirmDelete = false"
                                                        class="px-3 py-1 text-xs bg-gray-200 dark:bg-gray-700 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
                                                    Annuler
                                                </button>
                                                <button type="submit"
                                                        class="px-3 py-1 text-xs bg-red-600 text-white rounded-lg hover:bg-red-700">
                                                    Supprimer
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <button type="button"
                                                @click="confirmDelete = !confirmDelete"
                                                class="text-gray-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                
                                <!-- Contenu du post -->
                                <div class="mb-4">
                                    <p class="text-gray-800 dark:text-gray-200 whitespace-pre-line">
                                        {{ $post->description }}
                                    </p>
                                    
                                    <!-- Image du post -->
                                    @if($post->post_photo)
                                    <div class="mt-3 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-800">
                                        <img src="{{ asset('storage/' . $post->post_photo) }}" 
                                             alt="Post image" 
                                             class="w-full h-auto max-h-96 object-cover">
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Interactions -->
                                <div class="flex items-center gap-4 pt-3 border-t border-gray-100 dark:border-gray-800">
                                    <button class="flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                        </svg>
                                        <span class="text-sm">J'aime</span>
                                    </button>
                                    
                                    <button class="flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <span class="text-sm">Commenter</span>
                                    </button>
                                    
                                    <button class="flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                        </svg>
                                        <span class="text-sm">Partager</span>
                                    </button>
                                </div>
                            </div>
                            @empty
                            <!-- Message si pas de publications -->
                            <div class="text-center py-12">
                                <div class="w-24 h-24 mx-auto mb-4 text-gray-300 dark:text-gray-700">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                    Aucune publication pour le moment
                                </h4>
                                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">
                                    @if(auth()->id() === $user->id)
                                        Commencez à partager vos pensées avec vos amis en créant votre première publication !
                                    @else
                                        {{ $user->name }} n'a pas encore publié de contenu.
                                    @endif
                                </p>
                                
                                @if(auth()->id() === $user->id)
                                <button onclick="document.querySelector('textarea[name=\"description\"]').focus()"
                                        class="mt-4 px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all">
                                    Créer ma première publication
                                </button>
                                @endif
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- Colonne de droite - Informations supplémentaires -->
                <div>
                <!-- Date d'inscription -->
                    <div class="bg-white dark:bg-[#1C1C1B] backdrop-blur-sm rounded-2xl p-6 shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Informations</h3>
                        <div class="space-y-3">
                            <div class="flex items-center text-sm">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <div class="text-gray-500 dark:text-gray-400">Membre depuis</div>
                                    <div class="text-gray-900 dark:text-white">{{ $user->created_at->format('d F Y') }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center text-sm">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <div class="text-gray-500 dark:text-gray-400">Dernière activité</div>
                                    <div class="text-gray-900 dark:text-white">{{ $user->updated_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>