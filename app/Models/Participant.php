<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'activity_id',
        'name',
        'nip',
        'jabatan',
        'instansi',
        'nohp',
        'signature',
        'qr_code',
        'scanned_by',
        'scanned_at',
        'created_at',
        'updated_at',
    ];

    //SOFT DELETE
    protected $dates = ['deleted_at'];

    public function kegiatan()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
