<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DepartmentStoreRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::with('subdepartments')->latest()->get();
        return view('admin.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentStoreRequest $request)
    {
        $dept = Department::create([
            'name' => $request->name,
            'created_by' => Auth::user()->id
        ]);
        
        return redirect()->route('departments.index')->with('success', 'Department created.');
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
    public function edit(Department $department)
    {
        return view('admin.department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentStoreRequest $request, Department $department)
    {
        $department->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
        ]);

        return redirect()->route('departments.index')->with('success', 'Department updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted.');
    }
}
