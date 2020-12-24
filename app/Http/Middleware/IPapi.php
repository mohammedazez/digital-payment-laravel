<?php

namespace App\Http\Middleware;

use Pulsa;
use Closure;

class IPapi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return response()->json([
                'success' => false, 
                'message' => 'tes', 
            ], 401);
            
        $cek = json_decode(Pulsa::cek_server());
        if($cek == null){
            return response()->json([
                'success' => false, 
                'message' => 'cek kembali settingan anda', 
            ], 401);
        } 
        
        if(isset($cek->error)){
            if(strtolower($cek->error) == 'unauthenticated.'){
                return response()->json([
                    'success' => false, 
                    'message' => $cek->error, 
                ], 401);
            } 
        }
        
        if($cek->success == 0){
            return response()->json([
                'success' => false, 
                'message' => $cek->message, 
            ], 401);
        } 
        
        return $next($request);
    }
}
