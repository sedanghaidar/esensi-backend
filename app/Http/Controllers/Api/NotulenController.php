<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Notulen;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class NotulenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $result = Notulen::OrderByDesc('created_at')->get();

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
                'activity_id' => 'required',
                'image1' => 'required',
                'nosurat' => 'required',
                'jabatan' => 'required',
                'nama' => 'required',
                'pangkat' => 'required',
                'nip' => 'required',
                'hasil' => 'required',
            ]);

            // return auth()->user();

            if ($validator->fails()) {
                return $this->error("Parameter tidak sesuai.");
            }

            $name1 = '';
            $name2 = '';
            $name3 = '';

            if ($request->hasfile('image1')) {
                $filenameWithExt = $request->file('image1')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('image1')->getClientOriginalExtension();
                $name1 = date("Y-m-d_His") . '_' . $filename . '.' . $extension;

                if ($request->file('image1') != null) {
                    $request->file('image1')->storeAs('public/images', $name1);
                }
                // $files[] = $name1;
            }

            if ($request->hasfile('image2')) {
                $filenameWithExt = $request->file('image2')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('image2')->getClientOriginalExtension();
                $name2 = date("Y-m-d_His") . '_' . $filename . '.' . $extension;

                if ($request->file('image2') != null) {
                    $request->file('image2')->storeAs('public/images', $name2);
                }
                // $files[] = $name2;
            }

            if ($request->hasfile('image3')) {
                $filenameWithExt = $request->file('image3')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('image3')->getClientOriginalExtension();
                $name3 = date("Y-m-d_His") . '_' . $filename . '.' . $extension;

                if ($request->file('image3') != null) {
                    $request->file('image3')->storeAs('public/images', $name3);
                }
                // $files[] = $name3;
            }

            $result = Notulen::create([
                'activity_id' => $request->activity_id,
                'image1' => $name1 == '' ? null : $name1,
                'image2' => $name2 == '' ? null : $name2,
                'image3' => $name3 == '' ? null : $name3,
                'nosurat' => $request->nosurat,
                'jabatan' => $request->jabatan,
                'nama' => $request->nama,
                'pangkat' => $request->pangkat,
                'nip' => $request->nip,
                'hasil' => $request->hasil,
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
            $result = Notulen::where('activity_id', '=', $id)->first();

            if ($result) {
                return $this->success("Berhasil mengambil data", $result);
            } else {
                return $this->error("data tidak ditemukan.", 405);
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

            $input = $request->all();

            $validator = Validator::make($input, [
                'activity_id' => 'required',
                'nosurat' => 'required',
                'jabatan' => 'required',
                'nama' => 'required',
                'pangkat' => 'required',
                'nip' => 'required',
                'hasil' => 'required',
            ]);

            // return auth()->user();

            if ($validator->fails()) {
                return $this->error("Parameter tidak sesuai.");
            }

            $name1 = '';
            $name2 = '';
            $name3 = '';

            if ($request->hasfile('image1')) {
                $filenameWithExt = $request->file('image1')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('image1')->getClientOriginalExtension();
                $name1 = date("Y-m-d_His") . '_' . $filename . '.' . $extension;

                if ($request->file('image1') != null) {
                    $request->file('image1')->storeAs('public/images', $name1);
                }
                // $files[] = $name1;
            }

            if ($request->hasfile('image2')) {
                $filenameWithExt = $request->file('image2')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('image2')->getClientOriginalExtension();
                $name2 = date("Y-m-d_His") . '_' . $filename . '.' . $extension;

                if ($request->file('image2') != null) {
                    $request->file('image2')->storeAs('public/images', $name2);
                }
                // $files[] = $name2;
            }

            if ($request->hasfile('image3')) {
                $filenameWithExt = $request->file('image3')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('image3')->getClientOriginalExtension();
                $name3 = date("Y-m-d_His") . '_' . $filename . '.' . $extension;

                if ($request->file('image3') != null) {
                    $request->file('image3')->storeAs('public/images', $name3);
                }
                // $files[] = $name3;
            }

            $data = Notulen::find($id);

            $data->activity_id = $request->activity_id;
            $data->image1 = $name1 == '' ? $data->image1 : $name1;
            $data->image2 = $name2 == '' ? $data->image2 : $name2;
            $data->image3 = $name3 == '' ? $data->image3 : $name3;
            $data->nosurat = $request->nosurat;
            $data->jabatan = $request->jabatan;
            $data->nama = $request->nama;
            $data->pangkat = $request->pangkat;
            $data->nip = $request->nip;
            $data->hasil = $request->hasil;
            $data->created_by = auth()->user()->id;

            if ($data->save()) {
                return $this->success("Berhasil memperbarui data", Notulen::find($id));
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
            $result = Notulen::where('id', '=', $id)->first();
            $result->delete();

            return $this->success("Berhasil menghapus data", $result);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function downloadPDF(Request $request)
    {
        try {
            $input = $request->all();

            $validator = Validator::make($input, [
                'kegiatan_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->error("Parameter tidak sesuai.");
            }

            $kegiatan = Activity::where('id', '=', $request->kegiatan_id)->first();
            $notulen = Notulen::where('activity_id', '=', $request->kegiatan_id)->first();

            //get total instansi
            $query = Participant::where('activity_id', '=', $request->kegiatan_id)
                ->orderBy('instansi', 'asc');
            // ->groupBy('instansi')

            $instansi = $query->get()->unique('instansi');
            $instansi_count = $query->count();

            // return view('pdfdownload_notulen', compact('notulen', 'kegiatan', 'instansi', 'instansi_count'));

            $pdf = PDF::setOptions([
                'images' => true,
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ])->loadView('pdfdownload_notulen', compact('notulen', 'kegiatan', 'instansi', 'instansi_count'));

            $pdf->getDomPDF()->setHttpContext(
                stream_context_create([
                    'ssl' => [
                        'allow_self_signed' => TRUE,
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                    ]
                ])
            );

            $pdf->setPaper('a4', 'potrait');

            return $pdf->download($kegiatan->name . '_' . date("YmdHis") . '.pdf');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
