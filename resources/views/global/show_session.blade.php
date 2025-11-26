@if (Session::has('success'))
<div class="alert alert-success alert-dismissable">{!! Session::get('success') !!}</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissable">{!! Session::get('error') !!}</div>
@endif