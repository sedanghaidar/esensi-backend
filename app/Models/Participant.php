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
        'gender',
        'nip',
        'jabatan',
        'instansi',
        'organization_id',
        'wilayah',
        'wilayah_id',
        'nohp',
        'signature',
        'qr_code',
        'scanned_by',
        'scanned_at',
        'verification_message',
        'is_wa_sent',
        'created_at',
        'updated_at',
    ];

    //SOFT DELETE
    protected $dates = ['deleted_at'];

    public function kegiatan()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public static function getTotalPesertaTerdaftar($activity_id, $organization_id)
    {
        return self::where('activity_id', '=', $activity_id)->where('organization_id', '=', $organization_id)->count();
    }
}
