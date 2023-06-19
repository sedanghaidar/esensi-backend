<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 'name', 'short_name', 'created_at', 'updated_at', 'deleted_at',
    ];

    //SOFT DELETE
    protected $dates = ['deleted_at'];

    public function limit_participant()
    {
        return $this->hasMany(OrganizationLimit::class);
    }

    public static function getSingleOrganisasi($name)
    {
        return self::where('name', '=', $name)->first();
    }

    public static function insertOrganisasi($name)
    {
        return self::create([
            'name' => $name,
            'short_name' => $name,
        ]);
    }

    public static function findOrCreate($name)
    {
        //cek instansi ada tidak
        $organisasi = Organization::getSingleOrganisasi($name);
        if ($organisasi == false) {
            $insOrg = Organization::insertOrganisasi($name);
            return $insOrg;
        }
        return $organisasi;
    }

    public function parent()
    {
        return $this->belongsTo(Organization::class, 'parent_id', 'id')->with('parent');
    }
}
