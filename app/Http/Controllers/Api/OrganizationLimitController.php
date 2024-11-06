<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\OrganizationLimit;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationLimitController extends Controller
{
    public function bulkStore(Request $request)
    {
        // 'id', 'activity_id', 'organization_id', 'max_participant', 'created_by'
        try {
            // return $request->data[0]['activity_id'];

            $input = $request->all();

            $validator = Validator::make($input, [
                'activity_id' => 'required',
                'data' => 'required',
            ]);


            if ($validator->fails()) {
                return $this->error("Parameter tidak sesuai.");
            }


            $result = true;
            foreach ($request->data as $item) {
                //cek organisasi sudah ada blm
                $org = Organization::findOrCreate($item['organization_name']);

                // insert atau update
                OrganizationLimit::insertOrUpdateLimit($item['activity_id'], $org->id, $item['max_participant'], $item['region_id'], $item['region_name']);
            }

            if ($result) {
                return $this->success("Berhasil menambah semua data", null);
            } else {
                return $this->error("Gagal menambahkan data");
            }
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function getListLimitOrgbyActivityID($kegiatan_id)
    {
        try {
            $result = OrganizationLimit::with('organization')
                ->where('activity_id', '=', $kegiatan_id)
                ->get();

            if ($result) {
                return $this->success("Berhasil mengambil data", $result);
            } else {
                return $this->error("data tidak ditemukan.");
            }
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "A";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 'id', 'activity_id', 'organization_id', 'max_participant', 'created_by'
        try {
            $input = $request->all();

            $validator = Validator::make($input, [
                'activity_id' => 'required',
                'organization_name' => 'required',
                'max_participant' => 'required',
                'region_id' => 'required',
                'region_name' => 'required',
            ]);


            if ($validator->fails()) {
                return $this->error("Parameter tidak sesuai.");
            }

            $result = OrganizationLimit::updateOrCreate(
                ['activity_id' => $request->activity_id, 'organization_id' => Organization::getSingleOrganisasi($request->organization_name)->id, 'region_id' => $request->region_id,],
                ['region_name' => $request->region_name, 'max_participant' => $request->max_participant, 'created_by' => auth()->user()->id,]
            );

            if ($result) {
                return $this->success("Berhasil memperbarui data", OrganizationLimit::find($result->id));
            } else {
                return $this->error("Gagal menambahkan data");
            }
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = OrganizationLimit::find($id);
        $participant = Participant::where([
            ['activity_id', '=', $data->activity_id],
            ['organization_id', '=', $data->organization_id],
        ])->get();
        if (count($participant) == 0) {
            $data->delete();
            return $this->success("Berhasil menghapus data", $data);
        } else {
            return $this->error("Gagal menghapus data. Sudah ada partisipan yang terdaftar");
        }
    }
}
