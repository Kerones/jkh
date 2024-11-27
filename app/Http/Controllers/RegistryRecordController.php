<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegistryRecordResource;
use App\Models\RegistryRecord;
use Illuminate\Http\Request;

class RegistryRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registryRecords = RegistryRecord::all();
        if ($registryRecords->count() > 0) {
            return RegistryRecordResource::collection($registryRecords);
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
    public function show(RegistryRecord $registryRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegistryRecord $registryRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegistryRecord $registryRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegistryRecord $registryRecord)
    {
        //
    }
}
