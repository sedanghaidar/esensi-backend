<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ActivityController extends Controller
{

    /**
     * UPDATE NOTULENSI/LAPORAN
     */
    public function updateLaporan(Request $request, $id)
    {
        try {
            $input = $request->all();

            $validator = Validator::make($input, [
                'notulensi' => 'required',
            ]);

            // return auth()->user();

            if ($validator->fails()) {
                return $this->error("Parameter tidak sesuai.");
            }

            //INIT location FILE SURAT
            $filenameSimpan = ""; //Inisisasi
            if ($request->has('file_notulensi')) {
                // ada file yang diupload
                $filenameWithExt = $request->file('file_notulensi')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file_notulensi')->getClientOriginalExtension();
                $filenameSimpan = date("YmdHis") . '_' . $filename . '.' . $extension;

                if ($request->file('file_notulensi') != null) {
                    $uploaded = $request->file('file_notulensi')->storeAs('public/file_notulensi', $filenameSimpan);
                }
            }

            $request->merge([
                'data_file' => $filenameSimpan,
            ]);

            $data = Activity::find($id);

            $data->notulensi = $request->notulensi ?? null;
            $data->file_notulensi = $request->has("file_notulensi") ? $request->data_file : $data->file_notulensi ?? null;

            if ($data->save()) {
                return $this->success("Berhasil menambahkan laporan/notulensi", Activity::find($id));
            } else {
                return $this->error("Gagal menambahkan notulensi");
            }
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     *  LOAD
     *
     * @param  String  $codeurl
     * @return \Illuminate\Http\Response
     */
    public function loadByCode($codeurl)
    {
        try {
            $result = Activity::where('code_url', '=', $codeurl)->first();

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
            $result = Activity::OrderByDesc('created_at')->get();

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
        //
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

            $validator = Validator::make($input, [
                'name' => 'required',
                'date' => 'required',
                'time' => 'required',
                'location' => 'required',
            ]);

            // return auth()->user();

            if ($validator->fails()) {
                return $this->error("Parameter tidak sesuai.");
            }

            $result = Activity::create([
                'dinas_id' => auth()->user()->dinas_id,
                'bidang_id' => auth()->user()->bidang_id,
                'name' => $request->name,
                'date' => $request->date,
                'time' => $request->time,
                'location' => $request->location,
                'information' => $request->information ?? null,
                'verification_message' => $request->verification_message ?? null,
                'code_url' => Str::random(12),
                'max_date' => $request->max_date ?? null,
                'type' => $request->type ?? 2,
                'limit_participant' => $request->limit_participant ?? 0,
                'created_by' => auth()->user()->id,
            ]);

            if ($result) {
                return $this->success("Berhasil menambah data", $result);
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
        try {
            $result = Activity::find($id);

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

            $validator = Validator::make($input, [
                'name' => 'required',
                'date' => 'required',
                'time' => 'required',
                'location' => 'required',
            ]);

            // return auth()->user();

            if ($validator->fails()) {
                return $this->error("Parameter tidak sesuai.");
            }

            $data = Activity::find($id);


            $data->name = $request->name;
            $data->date = $request->date;
            $data->time = $request->time;
            $data->location = $request->location;
            $data->information = $request->has("information") ? $request->information : $data->information;
            $data->verification_message = $request->has("verification_message") ? $request->verification_message : $data->verification_message;
            $data->max_date = $request->max_date ?? null;
            $data->type = $request->type ?? 1;
            $data->limit_participant = $request->limit_participant ?? 0;
            $data->created_by = auth()->user()->id;


            if ($data->save()) {
                return $this->success("Berhasil memperbarui data", Activity::find($id));
            } else {
                return $this->error("Gagal menambahkan data");
            }
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
            $result = Activity::find($id);
            $result->delete();

            return $this->success("Berhasil menghapus data", $result);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
