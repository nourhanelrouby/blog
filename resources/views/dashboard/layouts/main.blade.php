<!DOCTYPE html>
<html lang="en">
@include('dashboard.layouts.head')

<body class="g-sidenav-show  bg-gray-100">

<div class="app-body">
    {{-- Sidebar --}}
    @include('dashboard.layouts.aside')
      {{-- Main content --}}
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('dashboard.layouts.nav')
        @include('dashboard.layouts.success')
        @include('dashboard.layouts.error')
        @yield('content')
        @include('dashboard.layouts.footer')
    </main>

</div>
@include('dashboard.layouts.scripts')

@yield('scripts')


</body>
</html>
