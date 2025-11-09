@section('title','Login')
@extends('admin.layouts.login')
@section('main_contant')
<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
    <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
        @include('global.show_session')
        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('post.login') }}" method="POST">
            @csrf
            
            <div class="text-center mb-10">
                 <img alt="Logo" src="{{ asset('assets/media/logos/somnathenterprice-logo.svg') }}" class="h-40px" />
            </div>

            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                <input 
                    class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror" 
                    type="text" 
                    name="email" 
                    value="{{ old('email') }}" {{-- Use old() to retain the input on failure --}}
                    autocomplete="off" 
                />
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="fv-row mb-10">
                <div class="d-flex flex-stack mb-2">
                    <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                </div>
                <input 
                    class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror" 
                    type="password" 
                    name="password" 
                    autocomplete="off" 
                />
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label">Continue</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection