<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'date', 'time', 'location', 'code_url', 'notulensi', 'file_notulensi', 'max_date', 'type', 'limit_participant', 'created_at', 'updated_at'
    ];

    //SOFT DELETE
    protected $dates = ['deleted_at'];
}
