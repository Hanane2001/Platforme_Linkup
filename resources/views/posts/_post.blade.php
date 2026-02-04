<div class="bg-white dark:bg-[#161615] rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-800 hover:shadow-xl transition-all duration-300">
    <!-- Contenu du post -->
    <div class="relative">
        <div class="flex items-start gap-3 mb-4">
            <!-- Avatar (si disponible) -->
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold">
                {{ substr($post->user->name ?? 'U', 0, 1) }}
            </div>
            
            <!-- Informations utilisateur -->
            <div class="flex-1">
                <div class="flex items-center gap-2">
                    <h4 class="font-semibold text-gray-900 dark:text-white">
                        {{ $post->user->name ?? 'Utilisateur' }}
                    </h4>
                    <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded-full text-gray-600 dark:text-gray-400">
                        {{ $post->created_at->diffForHumans() }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Publié
                </p>
            </div>
        </div>
        
        <!-- Description -->
        <p class="text-[#1b1b18] dark:text-gray-200 text-lg leading-relaxed pl-13">
            {{ $post->description }}
        </p>
        
        <!-- Photo du post (si disponible) -->
        @if($post->post_photo)
            <div class="mt-4 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-800">
                <img src="{{ asset('storage/' . $post->post_photo) }}" 
                     alt="Post image" 
                     class="w-full h-auto max-h-96 object-cover">
            </div>
        @endif
    </div>

    <!-- Actions -->
    <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100 dark:border-gray-800">
        <!-- Interactions -->
        <div class="flex items-center gap-4">
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
        </div>

        <!-- Bouton supprimer -->
        @if($post->user_id === auth()->id())
            <form action="{{ route('posts.destroy', $post) }}" method="POST" 
                  class="relative group" 
                  x-data="{ confirmDelete: false }">
                @csrf
                @method('DELETE')
                <button type="button"
                        @click="confirmDelete = !confirmDelete"
                        class="text-gray-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </form>
        @endif
    </div>
</div>