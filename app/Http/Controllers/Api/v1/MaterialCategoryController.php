<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\MaterialCategory;
use App\Transformers\MaterialCategoryTransformer;
use Illuminate\Http\Request;

class MaterialCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->response->collection(MaterialCategory::all(), new MaterialCategoryTransformer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaterialCategory  $materialCategory
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialCategory $materialCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaterialCategory  $materialCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialCategory $materialCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaterialCategory  $materialCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialCategory $materialCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaterialCategory  $materialCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialCategory $materialCategory)
    {
        //
    }
}
