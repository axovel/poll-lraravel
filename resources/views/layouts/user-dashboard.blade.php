<!DOCTYPE html>
<html lang="en">
    <!-- Head -->
    @include('admin.includes.head')

<body id="app-layout">
    <div id="wrapper">
        <!-- Navigation -->
            @include('includes.nav')
        <!-- Content -->
        @yield('content')
    </div>
</body>
</html>
