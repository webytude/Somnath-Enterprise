<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedhi;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PedhiStoreRequest;

class PedhiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedhi = Pedhi::latest()->get();
        return view('admin.pedhi.index', compact('pedhi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pedhi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PedhiStoreRequest $request)
    {
        Pedhi::create([
            'name' => $request->name,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('pedhi.index')
            ->with('success', 'Pedhi created successfully.');
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
        $pedhi = Pedhi::findOrFail($id);
        return view('admin.pedhi.edit', compact('pedhi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PedhiStoreRequest $request, string $id)
    {
        $pedhi = Pedhi::findOrFail($id);
        $pedhi->update([
            'name' => $request->name,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('pedhi.index')
            ->with('success', 'Pedhi updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pedhi = Pedhi::findOrFail($id);
        $pedhi->delete();
        return redirect()->route('pedhi.index')
            ->with('success', 'Pedhi deleted successfully.');
    }

}
