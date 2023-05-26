<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function(TokenInvalidException $e, $request){
            return response()->json([
                'status' => 401,
                'message' => 'Token JWT invalido'
            ], 401);
        });
        $this->renderable(function (TokenExpiredException $e, $request) {
            return response()->json([
                'status' => 401,
                'message' => 'Token JWT expirado'
            ], 401);
        });

        $this->renderable(function (JWTException $e, $request) {
            return response()->json([
                'status' => 401,
                'message' => 'Token nao informado'
            ], 401);
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return response()->json([
                'status' => 405,
                'message' => 'Metodo nao permitido'
            ], 405);
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'status' => 404,
                'message' => 'Rota nao encontrada'
            ], 404);
        });
    }
}
