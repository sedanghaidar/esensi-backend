<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Organization;
use App\Models\OrganizationLimit;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ParticipantController extends Controller
{
    public function scanQRParticipant(Request $request)
    {
        try {

            $input = $request->all();

            $validator = Validator::make($input, [
                'qr_code' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->error("Parameter tidak sesuai.");
            }

            // return $request;
            $data = Participant::where("qr_code", "=", $request->qr_code)
                ->first();

            if ($data->scanned_at != null) {
                return $this->error("Scan sudah di lakukan pada " . $data->scanned_at);
            }

            $data->scanned_by = auth()->user()->id;
            $data->scanned_at = now();

            if ($data->save()) {
                return $this->success("Berhasil melakukan scan QR", Participant::find($data->id));
            } else {
                return $this->error("data tidak ditemukan.");
            }
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function getParticipantByKegiatanID($kegiatan_id)
    {
        try {
            $result = Participant::with('kegiatan')
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
        try {
            $result = Participant::with('kegiatan')->get();

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
            // return 'a';
            $input = $request->all();

            $validator = Validator::make($input, [
                'activity_id' => 'required',
                'name' => 'required',
                'jabatan' => 'required',
                'instansi' => 'required',
                'nohp' => 'required',
                'signature' => 'required',
            ]);


            if ($validator->fails()) {
                return $this->error("Parameter tidak sesuai.");
            }

            //cek instansi, jika tidak ada create jika ada ambil datanya
            $organisasi = Organization::findOrCreate($request->instansi);

            //load detail kegiatan
            $kegiatan = Activity::find($request->activity_id);
            if ($kegiatan->limit_participant == 1) {
                if (Participant::getTotalPesertaTerdaftar($request->activity_id, $organisasi->id) >= OrganizationLimit::getTotalLimitParticipant($request->activity_id, $organisasi->id)) {
                    return $this->error("Maaf, Kuota telah terpenuhi untuk instansi anda..");
                }
            }

            //INIT location FILE SURAT
            $filenameSimpan = ""; //Inisisasi
            if ($request->has('signature')) {
                // ada file yang diupload
                $filenameWithExt = $request->file('signature')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('signature')->getClientOriginalExtension();
                $filenameSimpan = date("YmdHis") . '_' . $filename . '.' . $extension;

                if ($request->file('signature') != null) {
                    $uploaded = $request->file('signature')->storeAs('public/signature', $filenameSimpan);
                }
            }

            $request->merge([
                'path_signature' => $filenameSimpan,
            ]);

            $result = Participant::create([
                'activity_id' => $request->activity_id,
                'name' => $request->name,
                'nip' => $request->nip ?? null,
                'jabatan' => $request->jabatan,
                'instansi' => $request->instansi,
                'organization_id' => $organisasi->id,
                'nohp' => $request->nohp,
                'signature' => $request->path_signature,
                'qr_code' => Str::random(69),
            ]);

            if ($result) {
                return $this->success("Berhasil menambah data", Participant::find($result->id));
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
            $result = Participant::with('kegiatan')->find($id);

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
        try {
            $result = Participant::find($id);
            $result->delete();

            return $this->success("Berhasil menghapus data", $result);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
