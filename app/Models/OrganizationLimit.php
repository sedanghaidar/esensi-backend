<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationLimit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 'activity_id', 'organization_id', 'max_participant', 'created_by'
    ];

    //SOFT DELETE
    protected $dates = ['deleted_at'];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
    public function kegiatan()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
