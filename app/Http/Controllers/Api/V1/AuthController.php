<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\AuthRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Info(
 *     description="Dokumentasi API",
 *     version="1.0.0",
 *     title="",
 *     @OA\Contact(
 *         email=""
 *     ),
 *     @OA\License(
 *         name="",
 *         url=""
 *     )
 * )
 */ 

class AuthController extends Controller
{
    /**
     * Trait untuk menangani respons pengembalian.
     */
    use ResponseTrait;

    /**
     * Fungsionalitas terkait otentikasi.
     *
     * @var AuthRepository
     */
    public $authRepository;

    /**
     * Membuat instance AuthController baru.
     *
     * @return void
     */
    public function __construct(AuthRepository $ar)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->authRepository = $ar;
    }

    /**
     * @OA\POST(
     *     path="/api/auth/login",
     *     tags={"Otentikasi"},
     *     summary="Login",
     *     description="Login",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="string", example="admin@example.com"),
     *              @OA\Property(property="password", type="string", example="123456")
     *          ),
     *      ),
     *      @OA\Response(response=200, description="Login berhasil"),
     *      @OA\Response(response=400, description="Permintaan tidak valid"),
     *      @OA\Response(response=404, description="Sumber tidak ditemukan")
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');

            if ($token = $this->guard()->attempt($credentials)) 
            {
                // Dapatkan pengguna yang sedang login
                $user = $this->guard()->user();
                
                $shortToken = Str::random(100); // Gunakan token pendek
                $user->remember_token = $shortToken;
                $user->save();

                // Buat respons dengan token
                $data = $this->respondWithToken($shortToken);

                return $this->responseSuccess($data, 'Login Berhasil!');
            } else 
            {
                return $this->responseError(null, 'Username atau Password tidak valid!', Response::HTTP_UNAUTHORIZED);
            }
        } catch (\Exception $e) 
        {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/auth/register",
     *     tags={"Otentikasi"},
     *     summary="Registrasi Pengguna",
     *     description="Registrasi Pengguna Baru",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="nama"),
     *              @OA\Property(property="email", type="string", example="example@example.com"),
     *              @OA\Property(property="password", type="string", example="123456"),
     *              @OA\Property(property="password_confirmation", type="string", example="123456")
     *          ),
     *      ),
     *      @OA\Response(response=200, description="Data Pengguna Baru Terdaftar"),
     *      @OA\Response(response=400, description="Permintaan tidak valid"),
     *      @OA\Response(response=404, description="Sumber tidak ditemukan")
     * )
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $requestData = $request->only('name', 'email', 'password', 'password_confirmation');
            
            // Registrasi pengguna baru
            $user = $this->authRepository->register($requestData);
            
            if ($user) 
            {
                // Mengambil token dari login
                if ($token = $this->guard()->attempt($requestData)) 
                {
                    // Memperbarui token di model user
                    $shortToken = Str::random(100);
                    $user->remember_token = $shortToken;
                    $user->save();
                    
                    // Mengembalikan token yang telah di-generate
                    $data = $this->respondWithToken($shortToken);
                    
                    return $this->responseSuccess($data, 'Pengguna Terdaftar dan Login Berhasil', Response::HTTP_OK);
                }
            }
        } catch (\Exception $e) 
        {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mendapatkan struktur array token.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token): array
    {
        $data = [[
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60 * 60 * 24 * 365, // 1 Tahun dalam Detik      
            'user' => $this->guard()->user()
        ]];
        return $data[0];
    }

    /**
     * Mendapatkan guard yang digunakan selama otentikasi.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard(): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
    {
        return Auth::guard('api'); 
    }
}
