<!DOCTYPE html>
<html lang="id">

<head>
    @include('dashboard.partials.head')

    @yield('head')
</head>


<body class="bg-slate-50 text-slate-600 font-sans antialiased">

    <div class="flex h-screen overflow-hidden bg-slate-50">

        @include('dashboard.partials.sidebar')

        <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/20 z-40 hidden lg:hidden"></div>
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50">

            @include('dashboard.partials.navbar')

            {{-- Content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto flex flex-col">

                @yield('content')

                @include('dashboard.partials.footer')
            </main>

        </div>
    </div>



    @include('dashboard.partials.vendor-scripts')

    @yield('scripts')


</body>

</html>
