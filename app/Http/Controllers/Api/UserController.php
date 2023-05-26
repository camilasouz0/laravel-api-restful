<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;


/**
 * @OA\Info(title="Webapp API", version="1.0")
 *
 * @OA\SecurityScheme(
 *    securityScheme="bearerAuth",
 *    in="header",
 *    name="bearerAuth",
 *    type="http",
 *    scheme="bearer",
 *    bearerFormat="JWT"
 * )
 */
class UserController extends Controller
{
     /**
     * @OA\Get(
     *     tags={"user"},
     *     summary="Returns a list of users",
     *     description="Returns a object of users",
     *     security={
     *       {"bearer_token":{}},
     *     },
     *     path="/api/v1/users",
     *     @OA\Response(response="200", description="A list with users"),
     * ),
     * @SWG\Swagger(
     *     schemes={"https"},
     *     @SWG\SecurityScheme(
     *         securityDefinition="Bearer",
     *         type="apiKey",
     *         name="Authorization",
     *         in="header"
     *     ), 
     */
    public function index() {
        $usuarios = User::all();
        return $usuarios;
    }

    /**
     * @OA\Post(
     *     tags={"user"},
     *     summary="Returns a single user",
     *     security={
     *       {"token":{}},
     *     },
     *     description="Returns a single user from ID",
     *     @OA\Parameter(
     *         name="id",
     *         schema={"type":"integer"},
     *         in="path",
     *         description="User ID",
     *         required=true,
     *     ),
     *     path="/api/v1/users/{id}",
     *     @OA\Response(response="200", description="A list with users"),
     * ),
     * 
    */

    public function findUser($id) {
        $usuario = User::find($id);
        return $usuario;
    }
}
