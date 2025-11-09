<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <title>Somnath Enterprise</title>
    @include('admin.layouts.css')
</head>
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            @include('admin.layouts.sidebar')
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                @include('admin.layouts.top_header')
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    @yield('main_contant')
                </div>
            </div>
        </div>
    </div>
    @include('admin.layouts.scripts')
    @yield('custom_scripts')
</body>    
</html>