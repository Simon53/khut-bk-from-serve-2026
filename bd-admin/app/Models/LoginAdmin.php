<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class LoginAdmin extends Authenticatable
{
    protected $table = 'login_admin';
    protected $fillable = ['name','username','email','password','role'];

    protected $hidden = ['password'];
}
