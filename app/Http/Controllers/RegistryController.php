<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegistryResource;
use App\Models\Registry;
use Illuminate\Http\Request;

class RegistryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registries = Registry::all();
        if ($registries->count() > 0) {
            return RegistryResource::collection($registries);
        } else {
            return response()->json(['message' => 'No records available'], 200);
        }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Registry $registry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registry $registry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registry $registry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registry $registry)
    {
        //
    }
}
