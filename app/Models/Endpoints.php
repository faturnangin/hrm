<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endpoints extends Model
{
    use HasFactory;
    protected $table = 'endpoints';
    public const CREATED_AT = 'date_created';
    public const UPDATED_AT = 'date_updated';
    protected $primaryKey = 'id';
    protected $fillable = [
        'endpoint_id', 'name', 'description', 'permissions', 'point', 'body', 'response'
    ];
}
