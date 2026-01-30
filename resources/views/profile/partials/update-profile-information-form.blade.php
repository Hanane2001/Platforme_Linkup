<section class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 md:p-8">
    <header class="mb-8">
        <div class="flex items-center gap-3 mb-3">
            <div class="p-2 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('Profile Information') }}
            </h2>
        </div>
        
        <p class="text-gray-600 dark:text-gray-300">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('patch')

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Colonne gauche : Photo de profil -->
            <div class="space-y-6">
                <div class="bg-gray-50 dark:bg-gray-900 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('Profile Picture') }}
                    </h3>
                    
                    <div class="flex flex-col items-center space-y-6">
                        <div class="relative group">
                            <div class="relative">
                                <img class="h-32 w-32 rounded-full object-cover ring-4 ring-white dark:ring-gray-800 shadow-lg" 
                                     src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=6366f1&color=fff' }}" 
                                     alt="{{ Auth::user()->name }}">
                                
                                <div class="absolute inset-0 bg-black bg-opacity-40 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">
                                        {{ __('Change') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="w-full">
                            <div class="relative">
                                <input type="file" 
                                       name="profile_photo" 
                                       id="profile_photo"
                                       class="hidden"
                                       accept="image/*">
                                
                                <label for="profile_photo" 
                                       class="cursor-pointer flex items-center justify-center gap-2 w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors duration-200">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('Upload new photo') }}
                                    </span>
                                </label>
                            </div>
                            
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 text-center">
                                {{ __('PNG, JPG up to 2MB') }}
                            </p>
                            
                            @error('profile_photo')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne droite : Informations -->
            <div class="space-y-6">
                <!-- Nom -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <x-input-label for="name" :value="__('Full Name')" />
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('Required') }}
                        </span>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <x-text-input id="name" 
                                    name="name" 
                                    type="text" 
                                    class="pl-10 block w-full" 
                                    :value="old('name', $user->name)" 
                                    required 
                                    autofocus 
                                    autocomplete="name"
                                    placeholder="{{ __('Enter your full name') }}" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Pseudo -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <x-input-label for="pseudo" :value="__('Pseudo')" />
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('Optional') }}
                        </span>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <x-text-input id="pseudo" 
                                    name="pseudo" 
                                    type="text" 
                                    class="pl-10 block w-full" 
                                    :value="old('pseudo', $user->pseudo)" 
                                    autocomplete="username" 
                                    placeholder="{{ __('Enter your pseudo') }}" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('pseudo')" />
                </div>


                <!-- Email -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <x-input-label for="email" :value="__('Email Address')" />
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('Required') }}
                        </span>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <x-text-input id="email" 
                                    name="email" 
                                    type="email" 
                                    class="pl-10 block w-full" 
                                    :value="old('email', $user->email)" 
                                    required 
                                    autocomplete="email"
                                    placeholder="{{ __('Enter your email address') }}" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    <!-- Vérification email -->
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-yellow-600 dark:text-yellow-400 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-300 font-medium mb-1">
                                        {{ __('Email not verified') }}
                                    </p>
                                    <p class="text-sm text-yellow-700 dark:text-yellow-400 mb-2">
                                        {{ __('Please verify your email address to access all features.') }}
                                    </p>
                                    <button form="send-verification" 
                                            class="inline-flex items-center gap-1 text-sm font-medium text-yellow-700 dark:text-yellow-300 hover:text-yellow-800 dark:hover:text-yellow-200 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        {{ __('Resend verification email') }}
                                    </button>
                                    
                                    @if (session('status') === 'verification-link-sent')
                                        <div class="mt-2 flex items-center gap-1 text-sm text-green-600 dark:text-green-400">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bouton de sauvegarde -->
        <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('All changes will be saved automatically') }}
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- Message de succès -->
                    @if (session('status') === 'profile-updated')
                        <div x-data="{ show: true }"
                             x-show="show"
                             x-transition
                             x-init="setTimeout(() => show = false, 3000)"
                             class="flex items-center gap-2 px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">{{ __('Profile updated successfully!') }}</span>
                        </div>
                    @endif

                    <x-primary-button class="px-8 py-3 rounded-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('Save Changes') }}
                    </x-primary-button>
                </div>
            </div>
        </div>
    </form>
</section>