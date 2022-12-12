<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'short_name'
    ];


    public function limit_participant()
    {
        return $this->hasMany(OrganizationLimit::class);
    }
}
