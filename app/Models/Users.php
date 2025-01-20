<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $table = 'users';
    public const CREATED_AT = 'date_created';
    public const UPDATED_AT = 'date_updated';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'email', 'password', 'user_id', 'phone' // Add 'user_id' to the fillable array
    ];

}
