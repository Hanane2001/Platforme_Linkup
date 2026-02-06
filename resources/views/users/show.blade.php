<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 dark:from-[#0f0f0e] dark:to-[#1a1a18] py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200 group">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span class="font-medium">Retour au dashboard</span>
                </a>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10 dark:from-blue-500/5 dark:to-purple-500/5 rounded-2xl blur-xl"></div>
                <div class="relative bg-white/80 dark:bg-[#161615]/90 backdrop-blur-sm rounded-2xl p-8 shadow-2xl shadow-blue-500/5 dark:shadow-black/30 border border-white/20 dark:border-white/5">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full blur opacity-25 group-hover:opacity-75 transition duration-500"></div>
                            <div class="relative w-24 h-24 rounded-full overflow-hidden ring-4 ring-white dark:ring-[#161615]">
                                @if($user->profile_photo)
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                        <span class="text-3xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                            @if($user->is_verified)
                                <div class="absolute bottom-2 right-2 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div>
                                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                        <br>
                                        @if($user->pseudo)
                                            <span class="text-blue-500 dark:text-blue-400 font-medium ml-2">{{ $user->pseudo }}</span>
                                        @endif
                                    </h1>
                                </div>
                                <div class="flex gap-3 justify-center md:justify-end">
                                    @if(auth()->id() === $user->id)
                                        <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">Modifier le profil</a>
                                    @elseif(auth()->user()->isFriendWith($user))
                                        <span class="px-4 py-2 bg-green-500 text-white rounded-lg flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Ami</span>
                                        <a href="{{ route('messages.create', $user) }}" class="px-4 py-2 border border-blue-500 text-blue-500 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">Message</a>
                                        <form method="POST" action="{{ route('friends.remove', $user) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">Supprimer</button>
                                        </form>
                                    @elseif(auth()->user()->hasPendingRequestTo($user))
                                        <span class="px-4 py-2 bg-yellow-500 text-white rounded-lg flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>En attente</span>
                                    @else
                                        <form method="POST" action="{{ route('friends.request', $user) }}" class="inline">
                                            @csrf
                                            <button class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">Ajouter en ami</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
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
                    <div class="mt-8 pt-8 border-t border-gray-100 dark:border-gray-800">
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">À propos</h3>
                        <div class="prose prose-blue dark:prose-invert max-w-none"><p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">{{ $user->bio ?? 'Cet utilisateur n\'a pas encore rédigé de bio.' }}</p></div>
                    </div>
                </div>
            </div>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    @if(auth()->id() === $user->id)
                    <div class="bg-white/80 dark:bg-[#161615]/90 backdrop-blur-sm rounded-2xl p-6 shadow-lg mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Créer une publication</h3>
                        <div class="bg-gradient-to-br from-white to-gray-50 dark:from-[#161615] dark:to-[#1a1a19] rounded-xl shadow p-6 border border-gray-200 dark:border-gray-800">
                            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <textarea name="description" rows="3" class="w-full p-4 rounded-lg bg-gray-50 dark:bg-[#1C1C1B] border border-gray-200 dark:border-gray-800 focus:ring-2 focus:ring-blue-500 resize-none text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400" placeholder="Quoi de neuf ?"></textarea>
                                <div class="flex items-center justify-between">
                                    <div x-data="{ preview: null }">
                                        <label class="cursor-pointer">
                                            <input type="file" name="post_photo" class="hidden" accept="image/*" @change="const file = $event.target.files[0];
                                                if (file) {
                                                    const reader = new FileReader();
                                                    reader.onload = (e) => preview = e.target.result;
                                                    reader.readAsDataURL(file);}">
                                            <div class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span class="text-sm text-gray-600 dark:text-gray-400">Ajouter une photo</span>
                                            </div>
                                        </label>
                                    </div>
                                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all shadow-md hover:shadow-lg">Publier</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                    <div class="space-y-4">
                        @forelse($user->posts()->latest()->get() as $post)
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
                            <div class="px-4 py-2 flex border-t border-gray-100 dark:border-gray-800 gap-2">
                                <div class="flex-1">
                                    @if($post->isLikedBy(auth()->user()))
                                    <form action="{{ route('likes.destroy', $post) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="w-full py-2 text-blue-600 font-semibold hover:bg-blue-50 rounded-lg">❤️ J’aime ({{ $post->likes->count() }})</button>
                                    </form>
                                    @else
                                    <form action="{{ route('likes.store', $post) }}" method="POST">
                                        @csrf
                                        <button class="w-full py-2 text-gray-600 font-semibold hover:bg-gray-100 rounded-lg">🤍 J’aime ({{ $post->likes->count() }})</button>
                                    </form>
                                    @endif
                                </div>
                                <button @click="showComments = !showComments" class="flex-1 py-2 text-gray-600 font-semibold hover:bg-gray-100 rounded-lg">💬 Commenter</button>
                            </div>
                            <div x-show="showComments" x-transition class="text-white bg-gray-50 dark:bg-black/20 border-t border-gray-100 dark:border-gray-800 p-4 space-y-4">
                                <form action="{{ route('comments.store', $post) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <input type="text" name="content" placeholder="Écrire un commentaire..." class="flex-1 rounded-full px-4 py-2 bg-gray-100 dark:bg-gray-800 text-sm focus:ring-1 focus:ring-indigo-500" required>
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
                        @empty
                        <div class="text-center py-12"><p class="text-gray-500 dark:text-gray-400">Aucune publication pour le moment.</p></div>
                        @endforelse
                    </div>
                </div>
                <div>
                    <div class="bg-white dark:bg-[#1C1C1B] backdrop-blur-sm rounded-2xl p-6 shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Informations</h3>
                        <div class="space-y-3">
                            <div class="flex items-center text-sm">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <div>
                                    <div class="text-gray-500 dark:text-gray-400">Membre depuis</div>
                                    <div class="text-gray-900 dark:text-white">{{ $user->created_at->format('d F Y') }}</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center text-sm">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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