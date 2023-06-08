@include('layouts/_head')
<body>
<div class="container">
@yield('content')
</div>
@stack('scripts')
</body>
@include('layouts/_footer')

