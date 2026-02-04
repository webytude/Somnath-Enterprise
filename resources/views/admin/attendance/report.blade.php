@section('title','Attendance Report - All Staff All Days')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="card mb-5 mb-xl-12">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Attendance Report - All Staff All Days</h1>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('staff.index') }}" type="button" class="btn btn-light-primary me-3">
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M9.60041 15L8.40039 13.8L12.6004 9.60001L16.8004 13.8L15.6004 15L12.6004 12L9.60041 15Z" fill="currentColor"/>
                                <path opacity="0.3" d="M4.60039 4H19.4004C20.5004 4 21.4004 4.9 21.4004 6V18C21.4004 19.1 20.5004 20 19.4004 20H4.60039C3.50039 20 2.60039 19.1 2.60039 18V6C2.60039 4.9 3.50039 4 4.60039 4Z" fill="currentColor"/>
                            </svg>
                        </span>
                        Back to Staff
                    </a>
                </div>
            </div>
            <div class="card-body py-4">
                @include('global.show_session')
                
                <!-- Filter Section -->
                <div class="card mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Filter Options</h3>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('attendance.report') }}" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Staff (Optional - Leave empty for all staff)</label>
                                <select name="staff_id" class="form-select">
                                    <option value="">All Staff</option>
                                    @foreach($allStaff as $s)
                                        <option value="{{ $s->id }}" {{ $staffId == $s->id ? 'selected' : '' }}>
                                            {{ $s->full_name }} ({{ $s->code ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M14.2929 16.7071C13.9024 16.3166 13.9024 15.6834 14.2929 15.2929L16.5858 13H5C4.44772 13 4 12.5523 4 12C4 11.4477 4.44772 11 5 11H16.5858L14.2929 8.70711C13.9024 8.31658 13.9024 7.68342 14.2929 7.29289C14.6834 6.90237 15.3166 6.90237 15.7071 7.29289L19.7071 11.2929C20.0976 11.6834 20.0976 12.3166 19.7071 12.7071L15.7071 16.7071C15.3166 17.0976 14.6834 17.0976 14.2929 16.7071Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                    Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row g-5 g-xl-8 mb-5">
                    <div class="col-xl-3">
                        <div class="card bg-light-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span class="text-gray-700 fw-bold fs-6 d-block">Total Records</span>
                                        <span class="text-gray-900 fw-bolder fs-2x">{{ number_format($totalRecords) }}</span>
                                    </div>
                                    <div class="symbol symbol-50px">
                                        <div class="symbol-label bg-primary">
                                            <span class="svg-icon svg-icon-2x svg-icon-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14Z" fill="currentColor" opacity="0.3"/>
                                                    <path d="M17 21H13V17H17C17.6 17 18 17.4 18 18V20C18 20.6 17.6 21 17 21Z" fill="currentColor" opacity="0.3"/>
                                                    <path d="M20 7H18V9H20C20.6 9 21 8.6 21 8V6C21 5.4 20.6 5 20 5H18V7H20Z" fill="currentColor" opacity="0.3"/>
                                                    <path d="M17 3H13V7H17C17.6 7 18 6.6 18 6V4C18 3.4 17.6 3 17 3Z" fill="currentColor" opacity="0.3"/>
                                                    <path d="M7 3H11V7H7C6.4 7 6 6.6 6 6V4C6 3.4 6.4 3 7 3Z" fill="currentColor" opacity="0.3"/>
                                                    <path d="M4 10H6V14H4C3.4 14 3 13.6 3 13V11C3 10.4 3.4 10 4 10Z" fill="currentColor" opacity="0.3"/>
                                                    <path d="M7 21H11V17H7C6.4 17 6 17.4 6 18V20C6 20.6 6.4 21 7 21Z" fill="currentColor" opacity="0.3"/>
                                                    <path d="M4 14H6V10H4C3.4 10 3 10.4 3 11V13C3 13.6 3.4 14 4 14Z" fill="currentColor" opacity="0.3"/>
                                                    <path d="M11 21H13V17H11V21Z" fill="currentColor" opacity="0.3"/>
                                                    <path d="M11 7H13V3H11V7Z" fill="currentColor" opacity="0.3"/>
                                                    <path d="M17 13H20C20.6 13 21 12.6 21 12V11C21 10.4 20.6 10 20 10H17V13Z" fill="currentColor"/>
                                                    <path d="M7 13H4C3.4 13 3 12.6 3 12V11C3 10.4 3.4 10 4 10H7V13Z" fill="currentColor"/>
                                                    <path d="M13 18H11V21H13C13.6 21 14 20.6 14 20V18C14 17.4 13.6 17 13 17V18Z" fill="currentColor"/>
                                                    <path d="M13 7H11V3H13C13.6 3 14 3.4 14 4V6C14 6.6 13.6 7 13 7Z" fill="currentColor"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card bg-light-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span class="text-gray-700 fw-bold fs-6 d-block">Present</span>
                                        <span class="text-gray-900 fw-bolder fs-2x">{{ number_format($presentCount) }}</span>
                                    </div>
                                    <div class="symbol symbol-50px">
                                        <div class="symbol-label bg-success">
                                            <span class="svg-icon svg-icon-2x svg-icon-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M10 18C9.7 18 9.5 17.9 9.3 17.7L4.3 12.7C4.1 12.5 4 12.3 4 12C4 11.7 4.1 11.5 4.3 11.3L9.3 6.3C9.7 5.9 10.3 5.9 10.7 6.3C11.1 6.7 11.1 7.3 10.7 7.7L6.4 12L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z" fill="currentColor"/>
                                                    <path d="M20 18C19.7 18 19.5 17.9 19.3 17.7L14.3 12.7C14.1 12.5 14 12.3 14 12C14 11.7 14.1 11.5 14.3 11.3L19.3 6.3C19.7 5.9 20.3 5.9 20.7 6.3C21.1 6.7 21.1 7.3 20.7 7.7L16.4 12L20.7 16.3C21.1 16.7 21.1 17.3 20.7 17.7C20.5 17.9 20.3 18 20 18Z" fill="currentColor"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card bg-light-danger">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span class="text-gray-700 fw-bold fs-6 d-block">Absent</span>
                                        <span class="text-gray-900 fw-bolder fs-2x">{{ number_format($absentCount) }}</span>
                                    </div>
                                    <div class="symbol symbol-50px">
                                        <div class="symbol-label bg-danger">
                                            <span class="svg-icon svg-icon-2x svg-icon-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M6 9C6 8.44772 6.44772 8 7 8H17C17.5523 8 18 8.44772 18 9V15C18 15.5523 17.5523 16 17 16H7C6.44772 16 6 15.5523 6 15V9Z" fill="currentColor"/>
                                                    <path opacity="0.5" d="M2 5C2 4.44772 2.44772 4 3 4H21C21.5523 4 22 4.44772 22 5V19C22 19.5523 21.5523 20 21 20H3C2.44772 20 2 19.5523 2 19V5Z" fill="currentColor"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card bg-light-info">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span class="text-gray-700 fw-bold fs-6 d-block">Total OT Hours</span>
                                        <span class="text-gray-900 fw-bolder fs-2x">{{ number_format($totalOvertimeHours, 2) }}</span>
                                    </div>
                                    <div class="symbol symbol-50px">
                                        <div class="symbol-label bg-info">
                                            <span class="svg-icon svg-icon-2x svg-icon-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill="currentColor" opacity="0.3"/>
                                                    <path d="M12 6C12.5523 6 13 6.44772 13 7V11H17C17.5523 11 18 11.4477 18 12C18 12.5523 17.5523 13 17 13H13V17C13 17.5523 12.5523 18 12 18C11.4477 18 11 17.5523 11 17V13H7C6.44772 13 6 12.5523 6 12C6 11.4477 6.44772 11 7 11H11V7C11 6.44772 11.4477 6 12 6Z" fill="currentColor"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Table -->
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_attendance_report">
                        <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-50px">S.No</th>
                                <th class="min-w-100px">Date</th>
                                <th class="min-w-100px">Photo</th>
                                <th class="min-w-150px">Staff Name</th>
                                <th class="min-w-100px">Code</th>
                                <th class="min-w-100px">Designation</th>
                                <th class="min-w-120px text-center">Status</th>
                                <th class="min-w-150px">Location</th>
                                <th class="min-w-100px text-center">OT Hours</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-bold">
                            @forelse($attendances as $index => $attendance)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $attendance->attendance_date->format('d/m/Y') }}</td>
                                <td>
                                    @if($attendance->staff && $attendance->staff->photo)
                                        <img src="{{ $attendance->staff->photo }}" alt="{{ $attendance->staff->full_name }}" class="w-50px h-50px rounded" style="object-fit: cover;">
                                    @elseif($attendance->staff)
                                        <div class="symbol symbol-50px">
                                            <div class="symbol-label fs-2 fw-semibold text-success bg-light-success">
                                                {{ substr($attendance->staff->first_name, 0, 1) }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="symbol symbol-50px">
                                            <div class="symbol-label fs-2 fw-semibold text-muted bg-light">-</div>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $attendance->staff ? $attendance->staff->full_name : 'N/A' }}</td>
                                <td>{{ $attendance->staff && $attendance->staff->code ? $attendance->staff->code : 'N/A' }}</td>
                                <td>{{ $attendance->staff && $attendance->staff->designation ? $attendance->staff->designation : 'N/A' }}</td>
                                <td class="text-center">
                                    @if($attendance->attendance_status == 'present')
                                        <span class="badge badge-success">Present</span>
                                    @elseif($attendance->attendance_status == 'present_with_bike')
                                        <span class="badge badge-warning">Present with Bike</span>
                                    @else
                                        <span class="badge badge-danger">Absent</span>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->location)
                                        <span class="badge badge-primary">{{ $attendance->location->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($attendance->overtime_hours > 0)
                                        <span class="badge badge-info">{{ number_format($attendance->overtime_hours, 2) }} hrs</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-10">
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="svg-icon svg-icon-5x svg-icon-muted mb-5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M14.2929 16.7071C13.9024 16.3166 13.9024 15.6834 14.2929 15.2929L16.5858 13H5C4.44772 13 4 12.5523 4 12C4 11.4477 4.44772 11 5 11H16.5858L14.2929 8.70711C13.9024 8.31658 13.9024 7.68342 14.2929 7.29289C14.6834 6.90237 15.3166 6.90237 15.7071 7.29289L19.7071 11.2929C20.0976 11.6834 20.0976 12.3166 19.7071 12.7071L15.7071 16.7071C15.3166 17.0976 14.6834 17.0976 14.2929 16.7071Z" fill="currentColor"/>
                                            </svg>
                                        </span>
                                        <span class="text-muted fs-4 fw-bold">No attendance records found for the selected period.</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable if available
        if (typeof $.fn.DataTable !== 'undefined') {
            $('#kt_table_attendance_report').DataTable({
                pageLength: 25,
                order: [[1, 'desc']], // Sort by date descending
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries"
                }
            });
        }
    });
</script>
@endsection
