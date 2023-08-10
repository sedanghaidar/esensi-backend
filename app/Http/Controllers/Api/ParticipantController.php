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
use PDF;
use App\Exports\Participant as P;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\RequestOptions;
use App\Helpers\MyHelper;

class ParticipantController extends Controller
{

    public function sendWA($kegiatan, $participant)
    {
        $message = $kegiatan->verification_message;
        $message = str_replace("#nama_agenda", $kegiatan->name, $message);
        $message = str_replace("#tanggal_agenda", $this->indonesian_date($kegiatan->date, 'l, d F Y'), $message);
        $message = str_replace("#waktu_agenda", substr($kegiatan->time, 0, 5), $message);
        $message = str_replace("#lokasi_agenda", $kegiatan->location, $message);
        $message = str_replace("#informasi_tambahan", $kegiatan->information, $message);

        $message = str_replace("#nama_peserta", $participant->name, $message);
        $message = str_replace("#telp_peserta", $participant->nohp, $message);
        $message = str_replace("#jk_peserta", $participant->gender, $message);
        $message = str_replace("#instansi_peserta", $participant->instansi . " " . $participant->region_name, $message);
        $message = str_replace("#jabatan_peserta", $participant->jabatan, $message);


        if ($kegiatan->type == 2) {
            $message = "" . $message . "\n\nLihat QR Pendaftaran anda disini http://cs.saturnalia.jatengprov.go.id/#/detail-peserta/" . $participant->id . "";
        }

        $response = Http::asForm()->post(
            '103.9.227.50:3333/message/text?key=test123',
            [
                'id' => $this->formatPhone($participant->nohp),
                'message' => $message
            ]
        );

        if ($response['error'] == false) {
            $participant->is_wa_sent = true;
            $participant->save();
        } else {
        }

        return $response;
    }

    public function sendWAPerActivity($id)
    {
        $result = Participant::with('kegiatan')
            ->where('activity_id', '=', $id)
            ->orderByDesc('updated_at')
            ->get();

        foreach ($result as $key => $value) {
            app('App\Http\Controllers\Api\ParticipantController')->sendWA($value->kegiatan, $value);
        }

        return $result;
    }

    public function sendWAPerParticipantAndActivity($id, Request $request)
    {

        $result = Participant::with('kegiatan')
            ->where('activity_id', '=', $id)
            ->where('nohp', '=', $request->number)
            ->orderByDesc('updated_at')
            ->first();

        $response = app('App\Http\Controllers\Api\ParticipantController')->sendWA($result->kegiatan, $result);

        return $response;
    }

    public function downloadExcel(Request $request)
    {
        try {
            $input = $request->all();

            $validator = Validator::make($input, [
                'kegiatan_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->error("Parameter tidak sesuai.");
            }

            $activity = Activity::where('id', '=', $request->kegiatan_id)->first();
            // return $activity->limit_participant;
            return Excel::download(new P($request->kegiatan_id, $activity->limit_participant), $activity->name . ' Tanggal ' . $activity->date . '.xlsx');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function downloadPDF(Request $request)
    {
        try {
            $input = $request->all();
            $printWilayah = false;
            $stream = false;

            if ($request->has('wilayah')) {
                $printWilayah = $request->wilayah;
            }

            if ($request->has('stream')) {
                $stream = $request->stream;
            }

            $validator = Validator::make($input, [
                'kegiatan_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->error("Parameter tidak sesuai.");
            }

            $kegiatan = Activity::where('id', '=', $request->kegiatan_id)->first();

            $sortBy = 'updated_at';
            $sortAt = 'asc';
            if ($request->sortBy != null) $sortBy = $request->sortBy;
            if ($request->sortAt != null) $sortAt = $request->sortAt;
            $query = Participant::where('activity_id', '=', $request->kegiatan_id)
                ->orderBy($sortBy, $sortAt);

            if ($kegiatan->type == 2) {
                //kondisi tipe pendaftaran
                $query = $query->whereNotNull('scanned_at');
            }
            $results = $query->get();

            // return $results;

            // return view('pdfdownload', compact('results', 'kegiatan', 'printWilayah'));

            $pdf = PDF::loadView('pdfdownload', compact('results', 'kegiatan', 'printWilayah'));

            if ($stream) {

                return $pdf->stream($kegiatan->name . '.pdf');
            } else {
                return $pdf->download($kegiatan->name . '.pdf');
            }

            // $pdf = PDF::setOptions([
            //     'images' => true,
            //     'isHtml5ParserEnabled' => true,
            //     'isRemoteEnabled' => true,
            // ])->loadView('pdfdownload', compact('results', 'kegiatan', 'printWilayah'));
            // $pdf->setProtocol($_SERVER['DOCUMENT_ROOT']);

            // $pdf->getDomPDF()->setProtocol($_SERVER['DOCUMENT_ROOT']);

            // $pdf->getDomPDF()->setHttpContext(
            //     stream_context_create([
            //         'ssl' => [
            //             'allow_self_signed' => TRUE,
            //             'verify_peer' => FALSE,
            //             'verify_peer_name' => FALSE,
            //         ]
            //     ])
            // );

            // $pdf->setPaper('a4', 'potrait');

            // return $pdf->stream($kegiatan->name . '.pdf');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

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
            $data->updated_at = now();

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
                ->with('parent')
                ->where('activity_id', '=', $kegiatan_id)
                ->orderByDesc('updated_at')
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
                // 'gender' => 'required',
                'jabatan' => 'required',
                'instansi' => 'required',
                'region_id' => 'required',
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
                if (Participant::getTotalPesertaTerdaftar($request->activity_id, $organisasi->id, $request->region_id) >= OrganizationLimit::getTotalLimitParticipant($request->activity_id, $organisasi->id, $request->region_id)) {
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
                'gender' => $request->gender ?? null,
                'nip' => $request->nip ?? null,
                'jabatan' => $request->jabatan,
                'instansi' => $request->instansi,
                'organization_id' => $organisasi->id,
                'region_name' => $request->region_name ?? null,
                'region_id' => $request->region_id ?? null,
                'nohp' => $request->nohp,
                'signature' => $request->path_signature,
                'qr_code' => Str::random(69),
            ]);

            if ($result) {
                app('App\Http\Controllers\Api\ParticipantController')->sendWA($kegiatan, $result);
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
