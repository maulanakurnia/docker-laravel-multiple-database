<x-base-layout title="Dashboard">
    <header x-data="setup()" class="flex justify-end items-center border-b p-2">
            <!-- Navbar right -->
            <div class="ml-auto justify-end relative flex items-center space-x-3">
                <div class="items-center hidden space-x-3 md:flex">
                    <!-- avatar button -->
                    <div class="relative" x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen" class="p-1 bg-gray-200 rounded-full focus:outline-none">
                            @php
                                $name           = implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 2));
                            @endphp
                            <img class="object-cover w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{$name}}&color=6dbda1&background=bcf0da" alt="{{ $name }}" aria-hidden="true" />
                        </button>
                        <!-- green dot -->
                        <div class="absolute right-0 p-1 bg-green-400 rounded-full bottom-3 animate-ping"></div>
                        <div class="absolute right-0 p-1 bg-green-400 border border-white rounded-full bottom-3"></div>

                    <!-- Dropdown card -->
                    <div @click.away="isOpen = false" x-show.transition.opacity="isOpen"
                        class="absolute mt-3 transform -translate-x-full bg-white rounded-md shadow-lg min-w-max">
                        <div class="flex flex-col p-4 space-y-1 font-medium border-b">
                            <span class="text-gray-800">{{Auth::user()->name}}</span>
                            <span class="text-sm text-gray-400">{{Auth::user()->email}}</span>
                        </div>
                        <ul class="px-4 my-2" aria-label="submenu">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <li>
                                    <a class="flex items-center text-red-500" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span>{{ __('Logout') }}</span>
                                    </a>
                                </li>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
    </header>
    <div class="container">
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-header">
                    <h3>Dashboard</h3>
                </div>
                <div class="card-body">
                    <h5>Selamat datang di halaman dashboard, <strong>{{ Auth::user()->name }}</strong></h5>
                    <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
    @section('style')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    @endsection

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script>
    <script>
      const setup = () => {
        return {
          loading: true,
          isSidebarOpen: false,
          toggleSidbarMenu() {
            this.isSidebarOpen = !this.isSidebarOpen
          },
          isSettingsPanelOpen: false,
          isSearchBoxOpen: false,
        }
      }
    </script>
    @endsection
</x-base-layout>