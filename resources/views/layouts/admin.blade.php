
@props([
    'breadcrumbs'=>[],
    'title'=>config('app.name','laravel'),
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


        <!-- fopntwawesome -->
        <script src="https://kit.fontawesome.com/e121eddea9.js" crossorigin="anonymous"></script>

        {{-- sweeta alerta --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
        {{-- wire ui --}}
        <wireui:scripts />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Styles -->
        @livewireStyles
        @stack('css')
    </head>
    <body class="font-sans antialiased bg-gray-50">

    @include('layouts.includes.admin.navigation')

    @include('layouts.includes.admin.sidebar')

    <div class=" p-4 sm:ml-64">
        <div class="mt-14 flex items-center ">
            @include('layouts.includes.admin.breadcrumb')
            @isset($action)
                <div class="ml-auto">
                    {{ $action }}

                </div>                
            @endisset
  
        </div>
                {{$slot}}  
    </div>


        @stack('modals')

        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        @if(session('swal'))
            <script>
                swal.fire(@json(session('swal')));
            </script>
        @endif

        @stack('js')

    </body>
</html>
<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
</div>