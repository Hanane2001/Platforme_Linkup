<div class="bg-white dark:bg-[#161615] rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-800 hover:shadow-xl transition-all duration-300">
    <div class="relative">
        <div class="flex items-start gap-3 mb-4">
            <div class="relative w-15 h-15 rounded-full overflow-hidden ring-4 ring-white dark:ring-[#161615]">
                @if($post->user->profile_photo)
                    <img src="{{ asset('storage/' . $post->user->profile_photo) }}" alt="{{ $post->user->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center"><span class="text-3xl font-bold text-white">{{ strtoupper(substr($post->user->name, 0, 1)) }}</span></div>
                @endif
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-2">
                    <h4 class="font-semibold text-gray-900 dark:text-white">{{ $post->user->name ?? 'Utilisateur' }}</h4>
                    <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded-full text-gray-600 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Publié</p>
            </div>
        </div>
        <p class="text-[#1b1b18] dark:text-gray-200 text-lg leading-relaxed pl-13">{{ $post->description }}</p>
        @if($post->post_photo)
            <div class="mt-4 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-800"><img src="{{ asset('storage/' . $post->post_photo) }}" alt="Post image" class="w-full h-auto max-h-96 object-cover"></div>
        @endif
    </div>
    <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100 dark:border-gray-800">
        <div class="flex items-center gap-4">
            @if($post->isLikedBy(auth()->user()))
                <form action="{{ route('likes.destroy', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="flex items-center gap-2 text-blue-600 dark:text-blue-400">❤️<span>{{ $post->likes->count() }}</span></button>
                </form>
            @else
                <form action="{{ route('likes.store', $post) }}" method="POST">
                    @csrf
                    <button class="flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-blue-600">🤍<span>{{ $post->likes->count() }}</span></button>
                </form>
            @endif
            <button class="flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <span class="text-sm">Commenter</span>
            </button>
        </div>
        <div class="mt-4 border-t pt-4 space-y-3">
            <form action="{{ route('comments.store', $post) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="content" placeholder="Écrire un commentaire..." class="flex-1 px-4 py-2 rounded-lg bg-gray-100 dark:bg-[#1C1C1B] text-sm text-gray-900 dark:text-white focus:outline-none">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Publier</button>
            </form>
            @foreach($post->comments as $comment)
                <div class="text-sm text-gray-700 dark:text-gray-300"><strong>{{ $comment->user->name }}</strong> :{{ $comment->content }}</div>
            @endforeach
        </div>
        @if($post->user_id === auth()->id())
            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="relative group" x-data="{ confirmDelete: false }">
                @csrf
                @method('DELETE')
                <button type="button" @click="confirmDelete = !confirmDelete" class="text-gray-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </form>
        @endif
    </div>
</div>