<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if ($exception instanceof AuthorizationException) {
            return $this->showMessage(
                "No tiene permisos para acceder a esta ruta",
                Response::HTTP_FORBIDDEN
            );
        }

        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse("Debe iniciar sesión", 400);
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->showMessage("El dato con el id especificado no existe", 404);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('La ruta no existe', 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('El metodo no existe', 404);
        }

        if ($exception instanceof \Exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }

        return parent::render($request, $exception);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        return $this->errorResponse($errors, 422);
    }
}