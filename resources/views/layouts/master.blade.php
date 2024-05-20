<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Oming') }}</title>

    <!-- Scripts -->
    {{-- <script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <!-- Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>


<div>
    <nav class="bg-white dark:bg-gray-900 fixed w-full z-10 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo">
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Oming's Cake</span>
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            {{-- <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Get started</button> --}}
            <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
              <span class="sr-only">Open main menu</span>
              <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
              </svg>
          </button>
          


          @guest
          @if (Route::has('login'))

          <button  type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></button>

          @endif

          {{-- @if (Route::has('register'))
          
          <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></button>


          @endif --}}
          @else

          
          
            <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation" class="gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button"><i class="fa-solid fa-user"> </i> <span class="hidden sm:inline ">{{ Auth::user()->name }}</span><svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            
            <!-- Dropdown menu -->
            <div id="dropdownInformation" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                
                <div class="font-medium truncate">{{ Auth::user()->email }}</div>
                </div>
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInformationButton">
                {{-- <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                </li> --}}
                <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                </li>
                <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                </li>
                </ul>
                <div class="py-2">
                {{-- <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a> --}}
                    {{-- <a href=""  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white" >Sign out</a> --}}
                    <a href="#" onclick="showLogoutModal(event)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                    
                    {{-- <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white" onclick="showLogoutModal(event)">Sign out</a>
                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form> --}}
                    
                </div>

            </div>
            
                @endguest

                </div>
                <div class=" justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                    <ul class="row flex flex-col justify-around p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                        <li class="grid  align-items-center">
                            <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'text-blue-600' : '' }} block py-2 px-3  rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700" aria-current="page"><i class="fa-solid fa-house"></i> Home</a>
                        </li>
                        @cannot('isAdmin')
                        <li >
                            <a href="{{ url('order') }}" class="{{ Request::is('order') ? 'text-blue-600' : '' }} block py-2 px-3  rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"><i class="fa-solid fa-clipboard-list"></i> Order</a>
                        </li>
                        <li>
                            <a href="{{ url('cart') }}" class="{{ Request::is('cart') ? 'text-blue-600' : '' }} block py-2 px-3  rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"><i class="fa-solid fa-cart-shopping"></i> Cart</a>
                        </li>
                        <li>
                        @endcannot
                            @can('isAdmin')
                            <li >
                                {{-- <a class="nav-link" href="{{ url('food/viewfood') }}">
                                    <div class="flex" id="navbtnviewfood" aria-describedby="tooltipviewfood" data-tooltip-text="View Food">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <div class="text-md mt-2 bg-gray-600 text-white absolute rounded bg-opacity-50 shadow-xl hidden top-8 py-1 px-2 whitespace-pre" id="tooltipviewfood">    
                                        </div>
                                        <span class="sr-only">
                                        
                                    </div>
                                    
                                </a> --}}
                                <button id="dashboardInformationButton" data-dropdown-toggle="dashboardInformation" class="text-black bg-yellow-100 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button"><i class="fa-solid fa-gear fa-spin px-2"></i>  Dashboard<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <div id="dashboardInformation" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    
                                    {{-- <div class="font-medium truncate">{{ Auth::user()->email }}</div> --}}
                                    </div>
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dashboardInformationButton">
                                    <li>
                                        <a href="{{ url('food/viewfood') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Menu</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('order/orders_list') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Order List</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('ingredient/ingredientslist') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">ingredients list</a>
                                    </li>
                                    </ul>
                                    
                                    <div class="py-2">

                                    </div>
                                </div>
                                
                            </li>
                        

                            @endcan
                        

                        
                        </div>
                        </li>
                    </ul>
                    
                </div>
                </div>
            </nav>

            
            <main class="flex-grow py-4 h-full relative mt-16">
                @include('components.flash_message')
                
                @yield('content')
            </main>
        </div>

    

    @stack('script')
    <div id="popup-modal" tabindex="-1" class="hidden fixed inset-0 z-50 overflow-auto bg-gray-500 bg-opacity-75">
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative bg-white rounded-lg shadow-md w-96">
                <button type="button" onclick="hideLogoutModal()" class="absolute top-0 right-0 mt-3 mr-3 text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <div class="p-6">
                    <div class="text-center">
                        <h3 class="text-lg font-medium text-gray-900">Are you sure you want to sign out?</h3>
                    </div>
                    <div class="mt-6 flex justify-center">
                        <button onclick="logout()" type="button" class="mr-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Yes, I'm sure</button>
                        <button onclick="hideLogoutModal()" type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">No, cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
<script src="https://kit.fontawesome.com/56c2e8bc64.js" crossorigin="anonymous"></script>
<script>
    function showLogoutModal(event) {
        event.preventDefault();
        var modal = document.getElementById('popup-modal');
        modal.classList.remove('hidden');
    }

    function hideLogoutModal() {
        var modal = document.getElementById('popup-modal');
        modal.classList.add('hidden');
    }

    function logout() {
        window.location.href = "{{ route('logout') }}";
    }
</script>