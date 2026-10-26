<nav x-data="{ open: false }" class="bg-white border-b border-stone-200 shadow-sm sticky top-0 z-30">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo & Brand -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : (Auth::user()->role === 'kasir' ? route('dashboard') : route('orders.index')) }}" class="flex items-center space-x-2.5 group">
                        <div class="w-9 h-9 rounded-lg bg-coffee-800 flex items-center justify-center text-amber-200 shadow-sm group-hover:bg-coffee-900 transition">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M2,21H20V19H2M20,8H18V5H20M20,3H4V13A4,4 0 0,0 8,17H14A4,4 0 0,0 18,13V10H20A2,2 0 0,0 22,8V5C22,3.89 21.1,3 20,3Z"/>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-lg text-stone-900 leading-none tracking-tight">JOGO <span class="text-amber-800">KOPI</span></span>
                            <span class="text-[10px] text-stone-500 font-medium tracking-wider uppercase">Self-Ordering System</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-8 sm:flex">
                    @if (Auth::user()->isAdmin())
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            {{ __('Kelola Akun') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            {{ __('Kategori Menu') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.menus.index')" :active="request()->routeIs('admin.menus.*')">
                            {{ __('Menu Makanan & Minuman') }}
                        </x-nav-link>
                    @elseif (Auth::user()->role === 'kasir')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard Kasir') }}
                        </x-nav-link>
                    @else
                        <!-- Menu khusus Customer -->
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                            {{ __('Lacak Pesanan') }}
                        </x-nav-link>
                        <!-- Tambahkan link katalog atau menu lain jika ada -->
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-3">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ Auth::user()->isAdmin() ? 'bg-amber-100 text-amber-900 border border-amber-300' : (Auth::user()->role === 'kasir' ? 'bg-blue-100 text-blue-900 border border-blue-300' : 'bg-green-100 text-green-900 border border-green-300') }}">
                    {{ ucfirst(Auth::user()->role) }}
                </span>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-stone-200 text-sm leading-4 font-medium rounded-lg text-stone-700 bg-white hover:bg-stone-50 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div class="font-medium text-stone-800">{{ Auth::user()->name }}</div>

                            <div class="ms-1.5 text-stone-400">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil Saya') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                    class="text-rose-600 hover:text-rose-700 hover:bg-rose-50">
                                {{ __('Keluar (Log Out)') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-stone-500 hover:text-stone-700 hover:bg-stone-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-stone-50 border-b border-stone-200">
        <div class="pt-2 pb-3 space-y-1">
            @if (Auth::user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    {{ __('Kelola Akun') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                    {{ __('Kategori Menu') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.menus.index')" :active="request()->routeIs('admin.menus.*')">
                    {{ __('Menu Makanan & Minuman') }}
                </x-responsive-nav-link>
            @elseif (Auth::user()->role === 'kasir')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard Kasir') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                    {{ __('Lacak Pesanan') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-stone-200 px-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="font-medium text-base text-stone-900">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-stone-500">{{ Auth::user()->email }}</div>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold {{ Auth::user()->isAdmin() ? 'bg-amber-100 text-amber-900' : (Auth::user()->role === 'kasir' ? 'bg-blue-100 text-blue-900' : 'bg-green-100 text-green-900') }}">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil Saya') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                    this.closest('form').submit();"
                            class="text-rose-600">
                        {{ __('Keluar (Log Out)') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>