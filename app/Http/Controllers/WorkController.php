<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\Firm;
use App\Models\Department;
use App\Models\Subdepartment;
use App\Models\Division;
use App\Models\SubDivision;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\WorkStoreRequest;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $works = Work::with(['firm', 'department', 'subdepartment', 'division', 'subDivision', 'location'])->latest()->get();
        return view('admin.work.index', compact('works'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $firms = Firm::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        return view('admin.work.create', compact('firms', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkStoreRequest $request)
    {
        Work::create([
            'firm_id' => $request->firm_id,
            'department_id' => $request->department_id,
            'subdepartment_id' => $request->subdepartment_id,
            'division_id' => $request->division_id,
            'sub_division_id' => $request->sub_division_id,
            'location_id' => $request->location_id,
            'name_of_work' => $request->name_of_work,
            'description_of_work' => $request->description_of_work,
            'tender_id' => $request->tender_id,
            'estimate_cost' => $request->estimate_cost,
            'equal_above_below_on_estimate' => $request->equal_above_below_on_estimate,
            'final_amt_of_work' => $request->final_amt_of_work,
            'add_18_percent_gst' => $request->add_18_percent_gst,
            'our_final_work_amt' => $request->our_final_work_amt,
            'time_limit_years_months' => $request->time_limit_years_months,
            'work_order_no' => $request->work_order_no,
            'wo_date' => $request->wo_date,
            'end_date_of_work' => $request->end_date_of_work,
            'work_start_date' => $request->work_start_date,
            'if_extend_date' => $request->has('if_extend_date') ? true : false,
            'extended_date' => $request->extended_date,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('works.index')
            ->with('success', 'Work created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $work = Work::findOrFail($id);
        $firms = Firm::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $subdepartments = Subdepartment::where('department_id', $work->department_id)->orderBy('name')->get();
        $divisions = Division::where('subdepartment_id', $work->subdepartment_id)->orderBy('name')->get();
        $subDivisions = SubDivision::where('division_id', $work->division_id)->orderBy('name')->get();
        $locations = Location::where('firm_id', $work->firm_id)
            ->where('department_id', $work->department_id)
            ->where('subdepartment_id', $work->subdepartment_id)
            ->where('division_id', $work->division_id)
            ->orderBy('name')
            ->get();
        return view('admin.work.edit', compact('work', 'firms', 'departments', 'subdepartments', 'divisions', 'subDivisions', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkStoreRequest $request, string $id)
    {
        $work = Work::findOrFail($id);
        $work->update([
            'firm_id' => $request->firm_id,
            'department_id' => $request->department_id,
            'subdepartment_id' => $request->subdepartment_id,
            'division_id' => $request->division_id,
            'sub_division_id' => $request->sub_division_id,
            'location_id' => $request->location_id,
            'name_of_work' => $request->name_of_work,
            'description_of_work' => $request->description_of_work,
            'tender_id' => $request->tender_id,
            'estimate_cost' => $request->estimate_cost,
            'equal_above_below_on_estimate' => $request->equal_above_below_on_estimate,
            'final_amt_of_work' => $request->final_amt_of_work,
            'add_18_percent_gst' => $request->add_18_percent_gst,
            'our_final_work_amt' => $request->our_final_work_amt,
            'time_limit_years_months' => $request->time_limit_years_months,
            'work_order_no' => $request->work_order_no,
            'wo_date' => $request->wo_date,
            'end_date_of_work' => $request->end_date_of_work,
            'work_start_date' => $request->work_start_date,
            'if_extend_date' => $request->has('if_extend_date') ? true : false,
            'extended_date' => $request->extended_date,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('works.index')
            ->with('success', 'Work updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $work = Work::findOrFail($id);
        $work->delete();
        return redirect()->route('works.index')
            ->with('success', 'Work deleted successfully.');
    }

    /**
     * Get subdepartments by department ID (for AJAX)
     */
    public function getSubdepartments(Request $request)
    {
        $subdepartments = Subdepartment::where('department_id', $request->department_id)
            ->orderBy('name')
            ->get();
        
        return response()->json($subdepartments);
    }

    /**
     * Get divisions by subdepartment ID (for AJAX)
     */
    public function getDivisions(Request $request)
    {
        $divisions = Division::where('subdepartment_id', $request->subdepartment_id)
            ->orderBy('name')
            ->get();
        
        return response()->json($divisions);
    }

    /**
     * Get sub divisions by division ID (for AJAX)
     */
    public function getSubDivisions(Request $request)
    {
        $subDivisions = SubDivision::where('division_id', $request->division_id)
            ->orderBy('name')
            ->get();
        
        return response()->json($subDivisions);
    }

    /**
     * Get locations by filters (for AJAX)
     */
    public function getLocations(Request $request)
    {
        $query = Location::query();
        
        if ($request->has('firm_id') && $request->firm_id) {
            $query->where('firm_id', $request->firm_id);
        }
        if ($request->has('department_id') && $request->department_id) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->has('subdepartment_id') && $request->subdepartment_id) {
            $query->where('subdepartment_id', $request->subdepartment_id);
        }
        if ($request->has('division_id') && $request->division_id) {
            $query->where('division_id', $request->division_id);
        }
        if ($request->has('sub_division_id') && $request->sub_division_id) {
            $query->where('sub_division_id', $request->sub_division_id);
        }
        
        $locations = $query->orderBy('name')->get();
        
        return response()->json($locations);
    }
}
