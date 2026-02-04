<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MaterialCategoryStoreRequest;

class MaterialCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materialCategories = MaterialCategory::latest()->get();
        return view('admin.material-category.index', compact('materialCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.material-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialCategoryStoreRequest $request)
    {
        MaterialCategory::create([
            'name' => $request->name,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('material-categories.index')
            ->with('success', 'Material Category created successfully.');
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
        $materialCategory = MaterialCategory::findOrFail($id);
        return view('admin.material-category.edit', compact('materialCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaterialCategoryStoreRequest $request, string $id)
    {
        $materialCategory = MaterialCategory::findOrFail($id);
        $materialCategory->update([
            'name' => $request->name,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('material-categories.index')
            ->with('success', 'Material Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $materialCategory = MaterialCategory::findOrFail($id);
        $materialCategory->delete();
        return redirect()->route('material-categories.index')
            ->with('success', 'Material Category deleted successfully.');
    }
}
