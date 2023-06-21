<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationLimit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 'activity_id', 'region_id', 'region_name', 'organization_id', 'max_participant', 'created_by'
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


    public static function insertOrUpdateLimit($activity_id, $organization_id, $max_participant, $region_id, $region_name)
    {
        try {
            $result = self::where('activity_id', '=', $activity_id)->where('organization_id', '=', $organization_id)->where('region_id', '=', $region_id)->first();

            if ($result) {
                //ada maka update
                self::where('id', '=', $result->id)->update([
                    'max_participant' => $max_participant,
                ]);
            } else {
                //kosong maka insert
                OrganizationLimit::create([
                    'activity_id' => $activity_id,
                    'organization_id' => $organization_id,
                    'max_participant' => $max_participant,
                    'region_id' => $region_id,
                    'region_name' => $region_name,
                    'created_by' => auth()->user()->id,
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function getTotalLimitParticipant($activity_id, $organization_id, $region_id)
    {
        //cek jumlah maksimal
        $result = self::where('activity_id', '=', $activity_id)->where('organization_id', '=', $organization_id)->where('region_id', '=', $region_id)->first();
        if ($result) {
            return $result->max_participant;
        }
        return 0;
    }

    public function parent()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id')->with('parent');
    }
}
