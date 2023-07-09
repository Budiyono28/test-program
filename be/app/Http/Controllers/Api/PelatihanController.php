<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PelatihanResource;
use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PelatihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelatihans = Pelatihan::latest()->get();
        return response()->json([
            'data' => PelatihanResource::collection($pelatihans),
            'message' => 'Fetch all trainings',
            'success' => true
        ]);
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:155',
            'description' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $pelatihan = Pelatihan::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'status' => $request->get('status'),
            'slug' => Str::slug($request->get('title'))
        ]);

        return response()->json([
            'data' => new PelatihanResource($pelatihan),
            'message' => 'Training created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelatihan $pelatihan)
    {
        return response()->json([
            'data' => new PelatihanResource($pelatihan),
            'message' => 'Data training found',
            'success' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelatihan $pelatihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelatihan $pelatihan)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:155',
            'description' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $pelatihan->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'status' => $request->get('status'),
            'slug' => Str::slug($request->get('title'))
        ]);

        return response()->json([
            'data' => new PelatihanResource($pelatihan),
            'message' => 'Training updated successfully',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelatihan $pelatihan)
    {
        $pelatihan->delete();

        return response()->json([
            'data' => [],
            'message' => 'Training deleted successfully',
            'success' => true
        ]);
    }
}
