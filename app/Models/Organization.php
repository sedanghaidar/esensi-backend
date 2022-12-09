<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 'name', 'short_name'
    ];

    //SOFT DELETE
    protected $dates = ['deleted_at'];

    public function limit_participant()
    {
        return $this->hasMany(OrganizationLimit::class);
    }
}
