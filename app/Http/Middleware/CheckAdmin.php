<?php 

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckJwtAndRole
{
    public function handle($request, Closure $next, $role = null)
    {
        $user = JWTAuth::parseToken()->authenticate();

            // لو التوكن صحيح لكن الرول مش Admin
            if ($user && $user->role !== 'admin') {
                return response()->json([
                    'status' => false,
                    'message' => 'Forbidden - Admins only',
                ], 403);
            }
            
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (! $user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized',
                ], 401);
            }

            if ($role && $user->role !== $role) {
                return response()->json([
                    'status' => false,
                    'message' => 'Forbidden - ' . ucfirst($role) . ' only',
                ], 403);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['status' => false, 'message' => 'Token expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['status' => false, 'message' => 'Token invalid'], 401);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Token not provided'], 401);
        }

        return $next($request);
    }
}
