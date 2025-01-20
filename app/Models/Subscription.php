<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $table = 'subscription';
    public const CREATED_AT = 'date_created';
    public const UPDATED_AT = 'date_updated';
    protected $primaryKey = 'id';

}
