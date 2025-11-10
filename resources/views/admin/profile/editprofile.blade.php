@section('title','Edit Profile')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Profile</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-6">
                <div class="card card-flush h-lg-100" id="kt_contacts_main">
                    <div class="card-body pt-5">
                        @include('global.show_session')
                        <form id="kt_ecommerce_settings_general_form" class="form" method="POST" action="{{ route('user.updateProfile', [$user->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Name</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="name" value="{{ $user->name }}" />
                                @error('name')
                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Email</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="email" value="{{ $user->email }}" />
                                @error('email')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Phone </span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="phone" value="{{ $user->phone }}" />
                                @error('phone')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Emergancy Phone </span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="e_phone" value="{{ $user->e_phone }}" />
                                @error('e_phone')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Address </span>
                                </label>
                                <textarea name="address" class="form-control form-control-solid" >{{ $user->address }}</textarea>
                                @error('address')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('user.getProfile') }}" data-kt-contacts-type="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-contacts-type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Save</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection