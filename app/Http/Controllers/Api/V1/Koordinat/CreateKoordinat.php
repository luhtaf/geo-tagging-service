<?php

namespace App\Http\Controllers\Api\V1\Koordinat;

use App\Http\Controllers\Controller;
use App\Repositories\KoordinatRepository;
use App\Models\Koordinat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CreateKoordinat extends Controller {

    protected $koordinatRepository;

    public function __construct(KoordinatRepository $koordinatRepository) {
        $this->koordinatRepository= $koordinatRepository;
    }


    /**
     * Create a new koordinat record.
     */
    public function create(Request $request)
    {
        try {
            // Validate the input data
            $request->validate([
                'barang_id' => 'required|uuid',
                'latitude' => 'required|string',
                'longitude' => 'required|string',
            ]);

            // Create the new koordinat
            $koordinat = new Koordinat([
                'koordinat_id' => \Str::uuid(), // Generate a new UUID for koordinat_id
                'barang_id' => $request->input('barang_id'),
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
            ]);

            $koordinat->save();

            return response()->json([
                'message' => 'Koordinat created successfully!',
                'data' => $koordinat
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
