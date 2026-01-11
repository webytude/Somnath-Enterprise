<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Pedhi;
use App\Models\Department;
use App\Models\Subdepartment;
use App\Models\Division;
use App\Models\SubDivision;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LocationStoreRequest;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::with(['pedhi', 'department', 'subdepartment', 'division', 'subDivision'])->latest()->get();
        return view('admin.location.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pedhi = Pedhi::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        return view('admin.location.create', compact('pedhi', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocationStoreRequest $request)
    {
        Location::create([
            'pedhi_id' => $request->pedhi_id,
            'department_id' => $request->department_id,
            'subdepartment_id' => $request->subdepartment_id,
            'division_id' => $request->division_id,
            'sub_division_id' => $request->sub_division_id,
            'name' => $request->name,
            'location' => $request->location,
            'remark' => $request->remark,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('locations.index')
            ->with('success', 'Location created successfully.');
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
        $location = Location::findOrFail($id);
        $pedhi = Pedhi::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $subdepartments = Subdepartment::where('department_id', $location->department_id)->orderBy('name')->get();
        $divisions = Division::where('subdepartment_id', $location->subdepartment_id)->orderBy('name')->get();
        $subDivisions = SubDivision::where('division_id', $location->division_id)->orderBy('name')->get();
        return view('admin.location.edit', compact('location', 'pedhi', 'departments', 'subdepartments', 'divisions', 'subDivisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocationStoreRequest $request, string $id)
    {
        $location = Location::findOrFail($id);
        $location->update([
            'pedhi_id' => $request->pedhi_id,
            'department_id' => $request->department_id,
            'subdepartment_id' => $request->subdepartment_id,
            'division_id' => $request->division_id,
            'sub_division_id' => $request->sub_division_id,
            'name' => $request->name,
            'location' => $request->location,
            'remark' => $request->remark,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('locations.index')
            ->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location = Location::findOrFail($id);
        $location->delete();
        return redirect()->route('locations.index')
            ->with('success', 'Location deleted successfully.');
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
}
