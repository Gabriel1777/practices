<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use App\Serializers\NoDataSerializer;
use Illuminate\Database\Eloquent\Model;

trait ApiResponse
{
	protected function successResponse($data, $code)
	{
		return response()->json(['data' => $data, 'code' => $code], 200);
	}

	protected function errorResponse($message, $code)
	{
		return response()->json(
            [
                'data' => $message, 
                'code' => !$code || $code > 503 ? 500 : $code
            ], 
            200
        );
	}

	protected function showAll(Collection $collection, $code = 200)
	{
		if ($collection->isEmpty())
			return $this->successResponse(['data' => $collection, 'code' => $code], 200);

		$transformer = $collection->first()->transformer;
        $collection = $this->transformData($collection, $transformer);

		return $this->successResponse($collection, $code);
	}

	protected function showOne(Model $instance, $code = 200)
	{
		$transformer = $instance->transformer;
		$instance = $this->transformData($instance, $transformer);
		return $this->successResponse($instance, $code);
	}

	protected function showMessage($message, $code)
	{
		return $this->successResponse(['data' => $message, 'code' => $code], 200);
	}

	protected function transformData($data, $transformer)
    {
    	if (isset($_GET["first"]))
        	$data = $data->first();

        $transformation = fractal($data, new $transformer)->serializeWith(new NoDataSerializer());

        if (isset($_GET['include']))
            $transformation->parseIncludes($_GET['include']);

        return $transformation->toArray();
    }
}