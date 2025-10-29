<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BearerAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = $request->header('Authorization');
        $expectedToken = 'Bearer '.env('ZAPIER_WEBHOOK_SECRET');

        // Verifica se o header existe e está no formato "Bearer <token>"


        // Compara com o token esperado do .env
        if ($authorizationHeader !== $expectedToken) {
            return response()->json(['error' => 'Token inválido'.$authorizationHeader.'  '.$expectedToken], 403);
        }

        return $next($request);
    }
}
