<?php

namespace App\Http\Controllers\Api\V1\Koordinat;

use App\Http\Controllers\Controller;
use App\Repositories\KoordinatRepository;
use App\Models\Koordinat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EditKoordinat extends Controller {

    protected $koordinatRepository;

    public function __construct(KoordinatRepository $koordinatRepository) {
        $this->koordinatRepository= $koordinatRepository;
    }


    /**
     * Update latitude and longitude based on barang_id.
     */
    public function updateByBarangId(Request $request, $barang_id)
    {
        try {
            // Validate the input data
            $request->validate([
                'latitude' => 'required|string',
                'longitude' => 'required|string',
            ]);

            // Find the record by barang_id
            $koordinat = Koordinat::where('barang_id', $barang_id)->first();

            if ($koordinat) {
                // Update the latitude and longitude
                $koordinat->latitude = $request->input('latitude');
                $koordinat->longitude = $request->input('longitude');
                $koordinat->save();

                return response()->json([
                    'message' => 'Coordinates updated successfully!',
                    'data' => $koordinat
                ], 200);
            }

            return response()->json([
                'message' => 'Koordinat not found!'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
