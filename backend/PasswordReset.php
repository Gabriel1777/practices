<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasswordReset extends Model
{
    use HasFactory;

    protected $table = "password_resets";

    protected $fillable = [
    	"email",
    	"token"
    ];

    public function setData($email, $token)
    {
    	$this->email = $email;
    	$this->token = $token;
    	return $this;
    }

    public function scopeByEmail($query, $email)
    {
    	return $query->where("email", $email);
    }

    public function scopeByToken($query, $token)
    {
    	return $query->where("token" , $token);
    }
}