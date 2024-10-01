<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PesertaLelang;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Traits\ResponseTrait;
use App\Http\Requests\PesertaLelangRequest;
use App\Repositories\PesertaLelangRepository;

class PesertaLelangController extends Controller
{

	 use ResponseTrait;

    /**
     * Product Repository class.
     *
     * @var PermohonanRepo
     */
    public $pesertaLelangRepository;

    public function __construct(PesertaLelangRepository $pesertaLelangRepository)
    {
        $this->middleware('auth:api');
		$this->pesertaLelangRepository = $pesertaLelangRepository;

    }



 /**
     * @OA\Get(
     *     path="/api/v1/permohonan/pemenang",
     *     operationId="pemenang",
     *     tags={"Permohonan_Lelang"},
     *     summary="Ambil pemenang",
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
    public function pemenang(Request $request): JsonResponse
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
            $data = $this->pesertaLelangRepository->getpemenang();
            return $this->responseSuccess($data, 'Daftar Pemenang Berhasil Diambil!');

        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
