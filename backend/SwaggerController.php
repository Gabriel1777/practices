<?php

namespace App\Http\Controllers\Owner;

use App\Models\Swagger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Owner\SwaggerCreateRequest;
use App\Http\Requests\Owner\SwaggerUpdateRequest;

class SwaggerController extends ApiController
{
    private $swagger;

    public function __construct(Swagger $swagger)
    {
        $this->swagger = $swagger;
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *     path="/api/swagger",
     *     summary="Muestra la lista de swaggers.",
     *     tags={"Swagger"},
     *     @OA\Response(
     *         response=200,
     *         description="Devuelve una lista de todos los swaggers.",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en validaciones de negocio.",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Entidad no procesable.",
     *     ),
     *     security={ {"bearer_token": {}} },
     * )
     */

    public function index()
    {
        try{
            return $this->showAll($this->swagger->all(), 200);
        } catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/swagger",
     *     summary="Crear swagger",
     *     tags={"Swagger"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "longitude", "latitude", "address", "contact_name" , "email", "phone", "city_id", "photo"},
     *                 @OA\Property(
     *                     property="nit",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="longitude",
     *                     type="decimal"
     *                 ),
     *                 @OA\Property(
     *                     property="latitude",
     *                     type="decimal"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="contact_name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="status_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="city_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="photo",
     *                     type="image"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Muestra el objeto del swagger recien creado.",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la petición.",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Entidad no procesable.",
     *     ),
     * )
     */

    public function store(SwaggerCreateRequest $request)
    {
    	DB::beginTransaction();
    	try {
    		$data = $this->swagger->setDataCreate($request->all());
    		$this->swagger = $this->swagger->create($data);       
    		DB::commit();
    		return $this->showOne($this->swagger, 200);
    	} catch (\Exception $exception) {
    		DB::rollback();
    		return $this->errorResponse($exception->getMessage(), 200);
    	}
    }

    /**
     * @OA\Put(
     *     path="/api/swagger/{swagger}",
     *     summary="Actualiza la información del swagger solicitado",
     *     tags={"Swagger"},
     *     @OA\Parameter(
     *         name="swagger",
     *         in="path",
     *         description="Id del swagger que se desea modificar.",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "longitude", "latitude", "address", "contact_name" , "email", "phone", "city_id", "photo"},
     *                 @OA\Property(
     *                     property="nit",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="longitude",
     *                     type="decimal"
     *                 ),
     *                 @OA\Property(
     *                     property="latitude",
     *                     type="decimal"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="contact_name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="qualification",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="status_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="city_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="photo",
     *                     type="image"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Muestra la información actualizada del swagger.",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en validaciones de negocio.",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Entidad no procesable.",
     *     ),
     *     security={ {"bearer_token": {}} },
     * )
     */

    public function update(SwaggerUpdateRequest $request, Swagger $swagger) 
    {
        DB::beginTransaction();
        try {
            $this->swagger = $swagger->setDataUpdate($request->all());
            $this->swagger->save();
            DB::commit();
            return $this->showOne($this->swagger, 200);
        } catch (\Exception $exception){
            DB::rollback();
            return $this->errorResponse($exception->getMessage(), 400);
        } 
    }

    /**
     * @OA\Delete(
     *     path="/api/swagger/{swagger}",
     *     summary="Eliminar un swagger.",
     *     tags={"Swagger"},
     *     @OA\Parameter(
     *         name="swagger",
     *         in="path",
     *         description="Id del swagger que se desea eliminar.",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna el mensaje: Swagger eliminado exitosamente.",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en validaciones de negocio.",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Entidad no procesable.",
     *     ),
     *     security={ {"bearer_token": {}} },
     * )
     */

    public function delete(Swagger $swagger)
    {
        DB::beginTransaction();
        try{
            $swagger->refresh();
            $swagger->delete();
            DB::commit();
            
            return $this->successResponse('Swagger eliminado exitosamente.', 200);
        }
        catch (\Exception $exception){
            DB::rollback();
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
}
