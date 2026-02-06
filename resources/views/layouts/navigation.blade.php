<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <x-application-logo class="h-8 w-auto text-gray-800 dark:text-gray-200" />
                    <span class="ml-2 font-semibold text-gray-800 dark:text-gray-200">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>
            <!-- NAVIGATION DESKTOP -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-gray-900 dark:text-white font-medium' : 'text-gray-600 dark:text-gray-300' }} hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md transition-colors">{{ __('Dashboard') }}</a>
                <a href="{{ route('profile.edit') }}" class="text-gray-700 dark:text-gray-300 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">{{ __('Profile') }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-700 dark:text-gray-300 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">{{ __('Log Out') }}</button>
                </form>
            </div>
            <button id="mobile-menu-button" class="md:hidden text-gray-600 dark:text-gray-300 p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
        <!-- MOBILE MENU -->
        <div id="mobile-menu" class="md:hidden hidden border-t border-gray-200 dark:border-gray-700 pt-2 pb-3">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} block px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Dashboard</a>
            <a href="{{ route('profile.edit') }}" class="text-gray-700 dark:text-gray-300 block px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>Log Out
                </button>
            </form>
        </div>
    </div>
</nav>

<script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        const icon = btn.querySelector('svg');
        const paths = icon.querySelectorAll('path');
        if(menu.classList.contains('hidden')){
            paths[0].setAttribute('d','M4 6h16');
            paths[1].setAttribute('d','M4 12h16');
            paths[2].setAttribute('d','M4 18h16');
        } else {
            paths[0].setAttribute('d','M6 18L18 6M6 6l12 12');
            paths[1].setAttribute('d','');
            paths[2].setAttribute('d','');
        }
    });
</script>