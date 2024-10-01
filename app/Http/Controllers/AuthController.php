<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\JwtRepository;

class AuthController extends Controller
{
    protected $jwtService;

    public function __construct(JwtRepository $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function generateJwt(Request $request)
    {
        try {
            // Pass the authenticated user's ID to the repository
            //'$request->user()->id'
            $id='id';
            $token = $this->jwtService->generateToken($id);

            return response()->json([
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            // Handle the error and return a generic error message
            return response()->json([
                'error' => 'An error occurred while processing your request.',
                'msg'=> $e->getMessage()
            ], 500);
        }
    }
}
