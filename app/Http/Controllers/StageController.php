<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StageStoreRequest;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stages = Stage::latest()->get();
        return view('admin.stage.index', compact('stages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.stage.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StageStoreRequest $request)
    {
        Stage::create([
            'name' => $request->name,
            'percentage' => $request->percentage,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('stages.index')
            ->with('success', 'Stage created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stage $stage)
    {
        return view('admin.stage.show', compact('stage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stage $stage)
    {
        return view('admin.stage.edit', compact('stage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StageStoreRequest $request, Stage $stage)
    {
        $stage->update([
            'name' => $request->name,
            'percentage' => $request->percentage,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('stages.index')
            ->with('success', 'Stage updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stage $stage)
    {
        $stage->delete();
        return redirect()->route('stages.index')
            ->with('success', 'Stage deleted successfully.');
    }
}
