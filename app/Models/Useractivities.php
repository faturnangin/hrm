<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Useractivities extends Model
{
    protected $table = 'user_activities';
    protected $primaryKey = 'id';
    public const CREATED_AT = 'date_created';
    public const UPDATED_AT = 'date_updated';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'activity', 'user'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    public $timestamps = true;
}
