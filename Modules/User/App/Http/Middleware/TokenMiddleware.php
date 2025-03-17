<?php
namespace Modules\User\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\User\App\Services\ApiService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Daftar route yang tidak memerlukan token
        $exceptRoutes = [
            '/', // Landing page
            'login-ppid',
            'login',
            'register',
            'landing_page',
        ];

        // Jika route saat ini ada di daftar pengecualian, lewati pengecekan token
        if ($request->is($exceptRoutes)) {
            return $next($request);
        }

        // Ambil token dari session
        $token = session('api_token');

        if (empty($token)) {
            // Jika token kosong, jangan langsung redirect, tetapi izinkan beberapa akses terbatas
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return redirect()->route('login-ppid')->with('error', 'Silakan login untuk melanjutkan.');
        }

        // Validasi token dengan API (opsional, bisa dihapus jika tidak ingin pakai API lagi)
        $isValid = ApiService::validateToken($token);

        if (!$isValid) {
            // Coba refresh token
            $refreshed = ApiService::refreshToken();

            if (!$refreshed) {
                // Hapus token yang tidak valid
                Session::forget('api_token');

                // Jika request adalah JSON, kembalikan error, jika tidak redirect ke login
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Token expired'], 401);
                }

                return redirect()->route('login-ppid')->with('error', 'Sesi Anda telah berakhir, silakan login kembali.');
            }
        }

        return $next($request);
    }
}

// use Closure;
// use Illuminate\Http\Request;
// use Modules\User\App\Services\ApiService;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Session;
// use Tymon\JWTAuth\Facades\JWTAuth;
// use Tymon\JWTAuth\Exceptions\TokenExpiredException;
// use Tymon\JWTAuth\Exceptions\JWTException;

// class TokenMiddleware
// {
//     public function handle(Request $request, Closure $next)
//     {
//         // Hanya ambil token dari session, tidak dari cookies
//         $token = session('api_token');
        
//         if ($token) {
//             try {
//                 // Hapus 'Bearer ' prefix jika ada untuk kompatibilitas dengan JWTAuth
//                 $cleanToken = str_replace('Bearer ', '', $token);
                
//                 // Verifikasi dan periksa token
//                 $payload = JWTAuth::setToken($cleanToken)->getPayload();
//                 $expTime = $payload->get('exp');
                
//                 // Refresh token jika akan expired dalam 5 menit (300 detik)
//                 if (time() > ($expTime - 300)) {
//                     Log::info('Token akan expired dalam 5 menit, melakukan refresh');
                    
//                     // Refresh token
//                     $refreshed = ApiService::refreshToken();
                    
//                     if ($refreshed) {
//                         Log::info('Token berhasil di-refresh');
//                     } else {
//                         Log::warning('Gagal refresh token');
//                     }
//                 }
//             } catch (TokenExpiredException $e) {
//                 // Token sudah expired, coba refresh
//                 Log::info('Token expired, mencoba refresh');
                
//                 $refreshed = ApiService::refreshToken();
                
//                 if (!$refreshed) {
//                     Log::warning('Gagal refresh token yang expired');
                    
//                     // Hapus token dari session karena tidak valid
//                     Session::forget('api_token');
//                 }
//             } catch (JWTException $e) {
//                 // Error pada JWT, token tidak valid
//                 Log::warning('JWT error: ' . $e->getMessage());
                
//                 // Hapus token yang tidak valid dari session
//                 Session::forget('api_token');
//             } catch (\Exception $e) {
//                 // Error lain, log saja
//                 Log::warning('Token check error', ['error' => $e->getMessage()]);
//             }
//         }
        
//         return $next($request);
//     }
// }