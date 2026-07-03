<link rel="stylesheet" href="{{ asset('css/app.css') }}?v=3">
<link rel="stylesheet" href="{{ asset('build/assets/app.css') }}?v=3">

@php($fallbackCssPath = public_path('css/app.css'))
@if (is_file($fallbackCssPath))
    <style>
        {!! file_get_contents($fallbackCssPath) !!}
    </style>
@endif
