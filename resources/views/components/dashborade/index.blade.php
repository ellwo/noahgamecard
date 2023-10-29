
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <title>{{ config('app.name') }}</title>
 <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{Config::get('mysetting.site_header_logo')}}">

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap"
        rel="stylesheet" />
        <link
	href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
	rel="stylesheet">
        <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
      />
      {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
      <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
      <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/translations/ar.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/ui/trumbowyg.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- <link rel="stylesheet" href="build/css/tailwind.css" /> --}}

    @livewireStyles

    <script src="{{ mix('js/app.js') }}" defer></script>
















<style>
    canvas{
        width: 60%;
    }
</style>





    {{-- <script src="https://cdn.jsdelivr.net/gh/alpine-collective/alpine-magic-helpers@0.5.x/dist/component.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script> --}}
</head>

<body class="antialiased" >













    <div x-data="setup()" @resize.window="handleWindowResize" x-init="$refs.loading.classList.add('hidden');
    setColors('mycolor'); " :class="{ 'dark': isDark}">


    <div   class="min-h-screen text-gray-900 bg-gray-100 dark:bg-dark dark:text-light">
            <!-- Loading screen -->

            @auth

            @if(!isset($withsidebar))
            <x-sidebar.sidebar/>
            @endif
            @endauth

            <x-loading/>


                        <!-- Sidebar -->


            <div :class="{
                'lg:ml-64': isSidebarOpen,
                'md:ml-16': !isSidebarOpen
            }" class="flex flex-col flex-1 min-h-full "
            style="transition-property: margin; transition-duration: 150ms;"
            >

                <!-- her Is The Nav Bar -->
                @auth

                <x-dashborade.navbar/>
                @livewire('admin-notfiy', key(time()))

                @endauth

                <main class="flex-1 px-4 sm:px-6">

                    {{$slot}}

                </main>



            </div>
        </div>
        <!-- here is The Bob Up Views Or Panle -->


    <!-- Notification panel -->
    <!-- Backdrop -->
    {{-- <div x-transition:enter="transition duration-300 ease-in-out" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300 ease-in-out"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        x-show="isNotificationsPanelOpen" @click="isNotificationsPanelOpen = false"
        class="fixed inset-0 z-10 bg-primary-darker" style="opacity: 0.5" aria-hidden="true"></div>
    <!-- Panel -->
    <section x-transition:enter="transition duration-300 ease-in-out transform sm:duration-500"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition duration-300 ease-in-out transform sm:duration-500"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        x-ref="notificationsPanel" x-show="isNotificationsPanelOpen"
        @keydown.escape="isNotificationsPanelOpen = false" tabindex="-1"
        aria-labelledby="notificationPanelLabel"
        class="fixed inset-y-0 z-20 w-full max-w-xs bg-white dark:bg-darker dark:text-light sm:max-w-md focus:outline-none">
        <div class="absolute right-0 p-2 transform translate-x-full">
            <!-- Close button -->
            <button @click="isNotificationsPanelOpen = false"
                class="p-2 text-white rounded-md focus:outline-none focus:ring">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex flex-col h-screen" x-data="{ activeTabe: 'action' }">
            <!-- Panel header -->
            <div class="flex-shrink-0">
                <div class="flex items-center justify-between px-4 pt-4 border-b dark:border-primary-darker">
                    <h2 id="notificationPanelLabel" class="pb-4 font-semibold">Notifications</h2>
                    <div class="space-x-2">
                        <button @click.prevent="activeTabe = 'action'"
                            class="px-px pb-4 transition-all duration-200 transform translate-y-px border-b focus:outline-none"
                            :class="{'border-primary-dark dark:border-primary': activeTabe == 'action', 'border-transparent': activeTabe != 'action'}">
                            Action
                        </button>
                        <button @click.prevent="activeTabe = 'user'"
                            class="px-px pb-4 transition-all duration-200 transform translate-y-px border-b focus:outline-none"
                            :class="{'border-primary-dark dark:border-primary': activeTabe == 'user', 'border-transparent': activeTabe != 'user'}">
                            User
                        </button>
                    </div>
                </div>
            </div>

            <!-- Panel content (tabs) -->
            <div class="flex-1 pt-4 overflow-y-hidden hover:overflow-y-auto">
                <!-- Action tab -->
                <div class="space-y-4" x-show.transition.in="activeTabe == 'action'">
                    <a href="#" class="block">
                        <div class="flex px-4 space-x-4">
                            <div class="relative flex-shrink-0">
                                <span
                                    class="z-10 inline-block p-2 overflow-visible rounded-full bg-primary-50 text-primary-light dark:bg-primary-darker">
                                    <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </span>
                                <div
                                    class="absolute h-24 p-px -mt-3 -ml-px bg-primary-50 left-1/2 dark:bg-primary-darker">
                                </div>
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h5 class="text-sm font-semibold text-gray-600 dark:text-light">
                                    New project "KWD Dashboard" created
                                </h5>
                                <p
                                    class="text-sm font-normal text-gray-400 truncate dark:text-primary-lighter">
                                    Looks like there might be a new theme soon
                                </p>
                                <span class="text-sm font-normal text-gray-400 dark:text-primary-light"> 9h ago
                                </span>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="block">
                        <div class="flex px-4 space-x-4">
                            <div class="relative flex-shrink-0">
                                <span
                                    class="inline-block p-2 overflow-visible rounded-full bg-primary-50 text-primary-light dark:bg-primary-darker">
                                    <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </span>
                                <div
                                    class="absolute h-24 p-px -mt-3 -ml-px bg-primary-50 left-1/2 dark:bg-primary-darker">
                                </div>
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h5 class="text-sm font-semibold text-gray-600 dark:text-light">
                                    KWD Dashboard v0.0.2 was released
                                </h5>
                                <p
                                    class="text-sm font-normal text-gray-400 truncate dark:text-primary-lighter">
                                    Successful new version was released
                                </p>
                                <span class="text-sm font-normal text-gray-400 dark:text-primary-light"> 2d ago
                                </span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- User tab -->
                <div class="space-y-4" x-show.transition.in="activeTabe == 'user'">
                    <a href="#" class="block">
                        <div class="flex px-4 space-x-4">
                            <div class="relative flex-shrink-0">
                                <span class="relative z-10 inline-block overflow-visible rounded-ful">
                                    <img class="object-cover rounded-full w-9 h-9"
                                        src="{{ asset('davatar.png') }}" alt="Ahmed kamel" />
                                </span>
                                <div
                                    class="absolute h-24 p-px -mt-3 -ml-px bg-primary-50 left-1/2 dark:bg-primary-darker">
                                </div>
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h5 class="text-sm font-semibold text-gray-600 dark:text-light">Ahmed Kamel
                                </h5>
                                <p
                                    class="text-sm font-normal text-gray-400 truncate dark:text-primary-lighter">
                                    Shared new project "K-WD Dashboard"
                                </p>
                                <span class="text-sm font-normal text-gray-400 dark:text-primary-light"> 1d ago
                                </span>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="block">
                        <div class="flex px-4 space-x-4">
                            <div class="relative flex-shrink-0">
                                <span class="relative z-10 inline-block overflow-visible rounded-ful">
                                    <img class="object-cover rounded-full w-9 h-9"
                                        src="{{ asset('davatar.png') }}" alt="Ahmed kamel" />
                                </span>
                                <div
                                    class="absolute h-24 p-px -mt-3 -ml-px bg-primary-50 left-1/2 dark:bg-primary-darker">
                                </div>
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h5 class="text-sm font-semibold text-gray-600 dark:text-light">John</h5>
                                <p
                                    class="text-sm font-normal text-gray-400 truncate dark:text-primary-lighter">
                                    Commit new changes to K-WD Dashboard project.
                                </p>
                                <span class="text-sm font-normal text-gray-400 dark:text-primary-light"> 10h
                                    ago </span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Search panel -->
    <!-- Backdrop -->
    {{-- <div x-transition:enter="transition duration-300 ease-in-out" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300 ease-in-out"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-show="isSearchPanelOpen"
        @click="isSearchPanelOpen = false" class="fixed inset-0 z-10 bg-primary-darker" style="opacity: 0.5"
        aria-hidden="ture"></div>
    <!-- Panel -->
    <section x-transition:enter="transition duration-300 ease-in-out transform sm:duration-500"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition duration-300 ease-in-out transform sm:duration-500"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        x-show="isSearchPanelOpen" @keydown.escape="isSearchPanelOpen = false"
        class="fixed inset-y-0 z-20 w-full max-w-xs bg-white shadow-xl dark:bg-darker dark:text-light sm:max-w-md focus:outline-none">
        <div class="absolute right-0 p-2 transform translate-x-full">
            <!-- Close button -->
            <button @click="isSearchPanelOpen = false"
                class="p-2 text-white rounded-md focus:outline-none focus:ring">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <h2 class="sr-only">Search panel</h2>
        <!-- Panel content -->
        <div class="flex flex-col h-screen">
            <!-- Panel header (Search input) -->
            <div
                class="relative flex-shrink-0 px-4 py-8 text-gray-400 border-b dark:border-primary-darker dark:focus-within:text-light focus-within:text-gray-700">
                <span class="absolute inset-y-0 inline-flex items-center px-4">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input x-ref="searchInput" type="text"
                    class="w-full py-2 pl-10 pr-4 border rounded-full dark:bg-dark dark:border-transparent dark:text-light focus:outline-none focus:ring"
                    placeholder="Search..." />
            </div>

            <!-- Panel content (Search result) -->
            <div class="flex-1 px-4 pb-4 space-y-4 overflow-y-hidden h hover:overflow-y-auto">
                <h3 class="py-2 text-sm font-semibold text-gray-600 dark:text-light">History</h3>
                <a href="#" class="flex space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-10 h-10 rounded-lg" src="build/images/cover.jpg" alt="Post cover" />
                    </div>
                    <div class="flex-1 max-w-xs overflow-hidden">
                        <h4 class="text-sm font-semibold text-gray-600 dark:text-light">Header</h4>
                        <p class="text-sm font-normal text-gray-400 truncate dark:text-primary-lighter">
                            Lorem ipsum dolor, sit amet consectetur.
                        </p>
                        <span class="text-sm font-normal text-gray-400 dark:text-primary-light"> Post </span>
                    </div>
                </a>
                <a href="#" class="flex space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-10 h-10 rounded-lg" src="build/images/avatar.jpg" alt="Ahmed Kamel" />
                    </div>
                    <div class="flex-1 max-w-xs overflow-hidden">
                        <h4 class="text-sm font-semibold text-gray-600 dark:text-light">Ahmed Kamel</h4>
                        <p class="text-sm font-normal text-gray-400 truncate dark:text-primary-lighter">
                            Last activity 3h ago.
                        </p>
                        <span class="text-sm font-normal text-gray-400 dark:text-primary-light"> Offline
                        </span>
                    </div>
                </a>
                <a href="#" class="flex space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-10 h-10 rounded-lg" src="build/images/cover-2.jpg"
                            alt="K-WD Dashboard" />
                    </div>
                    <div class="flex-1 max-w-xs overflow-hidden">
                        <h4 class="text-sm font-semibold text-gray-600 dark:text-light">K-WD Dashboard</h4>
                        <p class="text-sm font-normal text-gray-400 truncate dark:text-primary-lighter">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                        </p>
                        <span class="text-sm font-normal text-gray-400 dark:text-primary-light"> Updated 3h
                            ago. </span>
                    </div>
                </a>
                <template x-for="i in 10" x-key="i">
                    <a href="#" class="flex space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-10 h-10 rounded-lg" src="build/images/cover-3.jpg"
                                alt="K-WD Dashboard" />
                        </div>
                        <div class="flex-1 max-w-xs overflow-hidden">
                            <h4 class="text-sm font-semibold text-gray-600 dark:text-light">K-WD Dashboard</h4>
                            <p class="text-sm font-normal text-gray-400 truncate dark:text-primary-lighter">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                            </p>
                            <span class="text-sm font-normal text-gray-400 dark:text-primary-light"> Updated 3h
                                ago. </span>
                        </div>
                    </a>
                </template>
            </div>
        </div>
    </section> --}}

    </div>






    <!-- her is The Scripts -->

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.bundle.min.js"></script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    @can('ادارة الطلبات')


    @endcan
    <script src="{{ asset('js/uploadeimage.js') }}"></script>

    @isset($script)
        {{$script}}

    @endisset


</body>
</html>
