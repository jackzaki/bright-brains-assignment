<?php
namespace App\Http\Middleware;
use Closure;
use Exception;
use App\User;
use App\Models\Users;
use App\Models\Admin;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->get('token');
        
        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 401);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 401);
        }
        
     
        if($credentials->type === "Admin"){
            $user = Admin::find($credentials->sub);
        }else{
            $user = Users::find($credentials->sub);
        }
        
        // Now let's put the user in the request class so that you can grab it from there
        $request->auth = $user;
        return $next($request);
    }
}