<?php

namespace App\Http\Controllers\Api\V1\Koordinat;

use App\Http\Controllers\Controller;
use App\Repositories\KoordinatRepository;
use App\Models\Koordinat;
use Illuminate\Http\Request;

class GetByBarangId extends Controller {

    protected $koordinatRepository;

    public function __construct(KoordinatRepository $koordinatRepository) {
        $this->koordinatRepository= $koordinatRepository;
    }


    public function getKoordinatBarang($id)
    {
        try {
            // Attempt to find the Petugas by ID
            $koordinat = Koordinat::where('barang_id', $id)->firstOrFail(); //$this->koordinatRepository->getByBarangId($id);

            // If Petugas not found, throw an exception
            if (!$koordinat) {
                throw new Exception("Koordinat with Barang ID {$id} not found.");
            }

            // Return success response with Petugas data
            // return (new KoordinatResource($koordinat))->additional([
            //     'message' => 'Koordinat retrieved successfully.'
            // ]);

            return response()->json($koordinat);

        } catch (Exception $e) {
            // Return error response if something fails
            return response()->json([
                'success' => false,
                'message' => 'Error fetching koordinat barang: ' . $e->getMessage(),
            ], 404); // You can return 404 for "not found" or 500 depending on the error
        }
    }


}
