<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermohonanRequest;
use App\Repositories\PermohonanRepository;

class PermohonanController extends Controller
{
    use ResponseTrait;

    public $permohonanRepository;

    public function __construct(PermohonanRepository $permohonanRepository)
    {
        $this->permohonanRepository = $permohonanRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/permohonan/viewall",
     *     operationId="index",
     *     tags={"Permohonan_Lelang"},
     *     summary="Ambil semua permohonan",
     *     description="Mengambil Data",
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
            // Ambil token dari parameter query permintaan
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
            $data = $this->permohonanRepository->getAll();
            return $this->responseSuccess($data, 'Daftar Permohonan Berhasil Diambil!');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/permohonan/sitapajak",
     *     operationId="sitapajak",
     *     tags={"Permohonan_Lelang"},
     *     summary="Ambil permohonan sita pajak",
     *     description="Mengambil Data",
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
    public function sitapajak(Request $request): JsonResponse
    {
        try {
            // Ambil token dari parameter query permintaan
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
            $data = $this->permohonanRepository->getsitapajak();
            return $this->responseSuccess($data, 'Daftar Permohonan Sita Pajak Berhasil Diambil!');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/permohonan/UUHT",
     *     operationId="uuht",
     *     tags={"Permohonan_Lelang"},
     *     summary="Ambil permohonan UUHT",
     *     description="Mengambil Data",
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
    public function UUHT(Request $request): JsonResponse
    {
        try {
            // Ambil token dari parameter query permintaan
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
            $data = $this->permohonanRepository->getuuht();
            return $this->responseSuccess($data, 'Daftar Permohonan UUHT Berhasil Diambil!');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

   
}
