<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        // Jika checkbox tidak dicentang, set is_active menjadi 0
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        Category::create($data);
        return redirect()->back()->with('success', 'Kategori berhasil ditambah');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->all();

        // Pastikan status diperbarui ke 0 jika tidak ada di request
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $category->update($data);
        return redirect()->back()->with('success', 'Kategori berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
