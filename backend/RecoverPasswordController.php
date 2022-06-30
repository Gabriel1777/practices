<?php

namespace App\Http\Controllers\RecoverPassword;


use App\Models\User;
use Illuminate\Support\Str;
use App\Models\PasswordReset;
use App\Mail\ResetPasswordUser;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ApiController;
use App\Http\Requests\RecoverPassword\RecoverPasswordEmail;
use App\Http\Requests\RecoverPassword\RecoverPasswordReset;
use App\Http\Requests\RecoverPassword\RecoverPasswordToken;

class RecoverPasswordController extends ApiController
{
    protected $user;

    protected $passwordReset;

    public function __construct(User $user, PasswordReset $passwordReset)
    {
        $this->middleware('guest');
        $this->user = $user;
        $this->passwordReset = $passwordReset;
    }

    public function sendEmailResetPassword($email, $token)
    {
        Mail::to($email)->send(new ResetPasswordUser($email, $token));
    }

    public function forgotPassword(RecoverPasswordEmail $request)
    {
        try {
            $token = rand(100000, 9999999);
            $user = $this->user->byEmail($request->email)->first();

            if (!$user)
                throw new \Exception("No existe ningun usuario con el correo " . $request->email . ".");

            $passwordReset = $this->passwordReset->byEmail($request->email)->first();

            if (!$passwordReset)
                $passwordReset = $this->passwordReset->setData($request->email, $token);
            else
                $passwordReset = $passwordReset->setData($request->email, $token);
            $passwordReset->save();

            $this->sendEmailResetPassword($request->email, $token);
            return $this->successResponse("Ingresa el código que hemos enviado a : $request->email", 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function verifyTokenResetPassword(RecoverPasswordToken $request)
    {
        $tokenGet = $this->passwordReset->byEmail($request->email)->value("token");
        if ($request->token == $tokenGet)
            return $this->successResponse('Código valido. ahora puedes cambiar tu contraseña', 200);
        return $this->errorResponse("El código ingresado no esta asociado a $request->email", 400);
    }

    public function resetPassword(RecoverPasswordReset $request)
    {
        try {
            $passwordReset = $this->passwordReset->byToken($request->token)->first();
            $user = $this->user->where('email', $request->email)->first();
            $user = $user->setDataPassword($request->password);
            $user->save();
            $passwordReset->delete();
            return $this->successResponse('La contraseña ha sido reestablecida', 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
}