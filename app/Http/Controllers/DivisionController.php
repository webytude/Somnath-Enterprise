<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Department;
use App\Models\Subdepartment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DivisionStoreRequest;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisions = Division::with(['department', 'subdepartment'])->latest()->get();
        return view('admin.division.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.division.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DivisionStoreRequest $request)
    {
        Division::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'subdepartment_id' => $request->subdepartment_id,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('division.index')
            ->with('success', 'Division created successfully.');
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
        $division = Division::findOrFail($id);
        $departments = Department::orderBy('name')->get();
        $subdepartments = Subdepartment::where('department_id', $division->department_id)->orderBy('name')->get();
        return view('admin.division.edit', compact('division', 'departments', 'subdepartments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DivisionStoreRequest $request, string $id)
    {
        $division = Division::findOrFail($id);
        $division->update([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'subdepartment_id' => $request->subdepartment_id,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('division.index')
            ->with('success', 'Division updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $division = Division::findOrFail($id);
        $division->delete();
        return redirect()->route('division.index')
            ->with('success', 'Division deleted successfully.');
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
}
