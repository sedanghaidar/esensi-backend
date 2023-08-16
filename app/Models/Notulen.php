<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Notulen extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'activity_id', 'image1', 'image2', 'image3', 'nosurat', 'jabatan', 'nama', 'pangkat', 'nip', 'hasil', 'delta', 'created_by', 'created_at', 'updated_at'
    ];

    //SOFT DELETE
    protected $dates = ['deleted_at'];

    public function kegiatan()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    public function peserta()
    {
        return $this->belongsToMany(Participant::class, 'activity_id');
    }
}
