@section('title','Edit Daily Expense')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Daily Expense</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-6">
                <div class="card card-flush h-lg-100" id="kt_daily_expense_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_daily_expense_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('daily-expense.update', $expense->id) }}">
                            @csrf
                            @method('PUT')
                            @if(auth()->check() && auth()->user()->isStaff() && auth()->user()->staff)
                                <input type="hidden" name="staff_id" value="{{ auth()->user()->staff->id }}">
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-bold form-label mt-3">Staff</label>
                                    <input type="text" class="form-control form-control-solid" value="{{ auth()->user()->staff->full_name }} ({{ auth()->user()->staff->code ?? 'N/A' }})" readonly />
                                </div>
                            @else
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Staff</span>
                                    </label>
                                    <select class="form-select form-select-solid" name="staff_id" id="staff_id" data-control="select2" data-placeholder="Select Staff...">
                                        <option value="">Select Staff...</option>
                                        @foreach($staff as $s)
                                            <option value="{{ $s->id }}" {{ old('staff_id', $expense->staff_id) == $s->id ? 'selected' : '' }}>{{ $s->full_name }} ({{ $s->code ?? 'N/A' }})</option>
                                        @endforeach
                                    </select>
                                    @error('staff_id')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Date</span>
                                </label>
                                <input type="date" class="form-control form-control-solid" name="date" value="{{ old('date', $expense->date ? $expense->date->format('Y-m-d') : '') }}" />
                                @error('date')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Amount</span>
                                </label>
                                <input type="number" step="0.01" class="form-control form-control-solid" name="amount" value="{{ old('amount', $expense->amount) }}" placeholder="Enter Amount" />
                                @error('amount')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Description</label>
                                <textarea class="form-control form-control-solid" name="description" rows="3" placeholder="Enter Description">{{ old('description', $expense->description) }}</textarea>
                                @error('description')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Remark</label>
                                <textarea class="form-control form-control-solid" name="remark" rows="3" placeholder="Enter Remark">{{ old('remark', $expense->remark) }}</textarea>
                                @error('remark')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('daily-expense.index')}}" data-kt-daily-expense-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-daily-expense-form="submit" class="btn btn-primary">
                                    <span class="indicator-label">Update</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
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
