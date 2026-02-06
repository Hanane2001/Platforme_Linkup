<div x-data="{ showComments: false }" class="bg-white dark:bg-[#161615] rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm hover:shadow-md transition overflow-hidden">
    <div class="p-4 flex justify-between items-start">
        <div class="flex gap-3">
            <div class="w-11 h-11 rounded-full overflow-hidden bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold">
                @if($post->user->profile_photo)
                    <img src="{{ asset('storage/' . $post->user->profile_photo) }}" class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                @endif
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h4 class="font-semibold text-gray-900 dark:text-white">{{ $post->user->name }}</h4>
                    <span class="text-xs text-gray-400">• {{ $post->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-xs text-indigo-500">Membre LinkUp</p>
            </div>
        </div>
        @if($post->user_id === auth()->id())
            <form action="{{ route('posts.destroy', $post) }}" method="POST">
                @csrf @method('DELETE')
                <button class="text-gray-400 hover:text-red-500">🗑</button>
            </form>
        @endif
    </div>
    <div class="px-4 pb-4">
        <p class="text-gray-800 dark:text-gray-200 text-[15px] mb-3">{{ $post->description }}</p>
        @if($post->post_photo)
            <img src="{{ asset('storage/' . $post->post_photo) }}" class="rounded-xl w-full max-h-[450px] object-cover">
        @endif
    </div>
    <div class="px-4 py-2 flex border-t border-gray-100 dark:border-gray-800">
        <div class="flex-1">
            @if($post->isLikedBy(auth()->user()))
                <form action="{{ route('likes.destroy', $post) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="w-full py-2 text-blue-600 font-semibold hover:bg-blue-50 rounded-lg">❤️ J’aime</button>
                </form>
            @else
                <form action="{{ route('likes.store', $post) }}" method="POST">
                    @csrf
                    <button class="w-full py-2 text-gray-600 font-semibold hover:bg-gray-100 rounded-lg">🤍 J’aime</button>
                </form>
            @endif
        </div>
        <button @click="showComments = !showComments" class="flex-1 py-2 text-gray-600 font-semibold hover:bg-gray-100 rounded-lg">💬 Commenter</button>
    </div>
    <div x-show="showComments" x-transition class="bg-gray-50 dark:bg-black/20 border-t border-gray-100 dark:border-gray-800 p-4 space-y-4">
        <form action="{{ route('comments.store', $post) }}" method="POST" class="flex gap-2">
            @csrf
            <input type="text" name="content" placeholder="Écrire un commentaire..." class="flex-1 rounded-full px-4 py-2 bg-gray-100 dark:bg-gray-800 text-sm focus:ring-1 focus:ring-indigo-500">
            <button class="bg-indigo-600 text-white px-4 rounded-full">Envoyer</button>
        </form>
        <div class="space-y-3">
            @foreach($post->comments as $comment)
                <div class="flex gap-2">
                    <div class="w-7 h-7 rounded-full bg-indigo-500 text-white flex items-center justify-center text-xs font-bold">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</div>
                    <div class="bg-gray-100 dark:bg-gray-800 rounded-xl px-3 py-2">
                        <p class="text-xs font-semibold">{{ $comment->user->name }}</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
