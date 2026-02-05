<div class="bg-gradient-to-br from-white to-gray-50 dark:from-[#161615] dark:to-[#1a1a19] rounded-2xl shadow-xl p-6 border border-gray-200 dark:border-gray-800">
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="flex items-center gap-3 mb-2">
            <div class="relative">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" class="w-20 h-20 rounded-full object-cover shadow-lg border-2 border-white dark:border-[#161615]" alt="{{ auth()->user()->name }}">
                @else
                    <div class="w-20 h-20 bg-gradient-to-br from-[#4361EE] to-[#3A0CA3] dark:from-[#7209B7] dark:to-[#4361EE] rounded-full flex items-center justify-center shadow-lg">
                        <span class="text-white text-2xl font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                @endif
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Créer une publication</p>
            </div>
        </div>
        <div class="relative">
            <textarea name="description" rows="4" class="w-full p-4 rounded-xl bg-gray-50 dark:bg-[#1C1C1B] border border-gray-200 dark:border-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400" placeholder="Partagez vos pensées..." x-data="{ chars: 0 }" @input="chars = $event.target.value.length"></textarea>
            <div class="absolute bottom-3 right-3 text-xs text-gray-400"><span x-text="chars"></span>/500</div>
        </div>
        <div x-data="{ preview: null,
            clearPreview() {
                this.preview = null;
                const input = document.querySelector('input[name=\"post_photo\"]');
                input.value = '';}}" class="space-y-3">
            <div class="flex items-center justify-between gap-4">
                <label class="flex-1">
                    <input type="file" name="post_photo" class="hidden" accept="image/*" @change="const file = $event.target.files[0];
                               if (file) {
                                   const reader = new FileReader();
                                   reader.onload = (e) => preview = e.target.result;
                                   reader.readAsDataURL(file);
                               }">
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 dark:bg-[#1C1C1B] border border-gray-200 dark:border-gray-800 hover:bg-gray-100 dark:hover:bg-gray-900 cursor-pointer transition-colors">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Ajouter une photo</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">JPG, PNG • Max 5MB</p>
                        </div>
                    </div>
                </label>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-xl hover:from-blue-700 hover:to-purple-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition-all shadow-md hover:shadow-lg">Publier</button>
            </div>
        </div>
        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Public</span>
            </div>
        </div>
    </form>
</div>