<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\OrganizationLimit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listByKegiatan($id)
    {
        try {
            $result = OrganizationLimit::where('activity_id', '=', $id)
                ->leftjoin('organizations', 'organizations.id', '=',  'organization_id')
                ->select('organizations.id', 'name', 'short_name', 'region_id', 'region_name', 'max_participant', 'parent_id')
                ->with('parent')
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
        try {
            $result = Organization::with('parent')->where(function ($query) {
                $query->whereIn('parent_all_id', [751, 863, 947, 1053, 1127, 1269, 1413, 1495, 1625, 1809, 1921, 1999, 2119])->orWhere('parent_id', '=', null);
            })->orWhere('parent_id', '=', null)->get();
            // $result = Organization::with('parent')->where('parent_id', '=', null)->get();

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
        try {
            $input = $request->all();
            // return $input;

            $validator = Validator::make($input, [
                'name' => 'required|unique:organizations',
                'short_name' => 'required',
                'internal' => 'required',
            ]);


            if ($validator->fails()) {
                return $this->error("Parameter is missing");
            }
            $result = Organization::create($input);

            if ($result) {
                return $this->success("Berhasil menambahkan data", $result);
            } else {
                return $this->error("data tidak ditemukan.");
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
        try {
            $input = $request->all();
            // return $input;

            $validator = Validator::make($input, [
                'name' => 'required|unique:organizations',
                'short_name' => 'required',
                'internal' => 'required',
            ]);


            if ($validator->fails()) {
                return $this->error("Parameter is missing");
            }

            $organization = Organization::find($id);
            $organization->name = $request->name;
            $organization->short_name = $request->short_name;
            $organization->internal = $request->has('internal') ? $request->internal : $organization->internal;
            $organization->save();

            return $this->success("Berhasil memperbarui data", $organization);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = Organization::find($id);
            $result->delete();

            return $this->success("Berhasil menghapus data", $result);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
