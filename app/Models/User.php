<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, HasUlids;
    protected $primaryKey = "user_id";
    protected $keyType = 'string';
    protected $fillable = [
        'username',
        'email',
        'password',
        'role'
    ];
}
