<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Traits\ResponseTrait;
use App\Http\Requests\PenetapanPelaksanaanRequest;
use App\Repositories\PenetapanPelaksanaanRepository;
use App\Models\PenetapanPelaksanaan;
use App\Http\Controllers\Controller;

class PenetapanPelaksanaanController extends Controller
{
    // Menggunakan trait untuk menangani respons
    use ResponseTrait;

    // Menyimpan instance dari repository PenetapanPelaksanaan
    public $penetapanpelaksanaanRepository;

    /**
     * Buat instance baru PenetapanPelaksanaanController.
     *
     * @param  PenetapanPelaksanaanRepository  $penetapanpelaksanaanRepository
     * @return void
     */
    public function __construct(PenetapanPelaksanaanRepository $penetapanpelaksanaanRepository)
    {
        // Menggunakan middleware 'auth:api' untuk otentikasi
        $this->middleware('auth:api');
        $this->penetapanpelaksanaanRepository = $penetapanpelaksanaanRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/permohonan/pelaksanaan",
     *     operationId="index2",
     *     tags={"Permohonan_Lelang"},
     *     summary="Ambil semua pelaksanaan",
     *     description="Ambil data pelaksanaan",
     *     @OA\Parameter(
     *         name="token",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         description="Token otorisasi"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data berhasil diambil",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Data tidak valid",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token tidak valid",
     *     ),
     * )
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Ambil token dari parameter query request
            $token = $request->input('token');

            if (!$token) {
                return $this->responseError(null, 'Token tidak disediakan', Response::HTTP_UNAUTHORIZED);
            }

            // Periksa apakah token ada di kolom remember_token
            $user = \App\Models\User::where('remember_token', $token)->first();

            if (!$user) {
                return $this->responseError(null, 'Token tidak valid', Response::HTTP_UNAUTHORIZED);
            }

            // Token valid, lanjutkan untuk mengambil data
            $data = $this->penetapanpelaksanaanRepository->getAll();
            return $this->responseSuccess($data, 'Daftar Pelaksanaan Berhasil Diambil!');

        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
