<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        // Mengambil data user sesuai peran
        $role_id = auth()->user()->role_id;
        $users = User::where('role_id', '>=', $role_id)->get();

        return $this->success("Success get data", $users);
    }

    // Menampilkan form untuk membuat user baru
    public function create()
    {
    }

    // Menyimpan user baru ke database
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            // return $input;

            $validator = Validator::make($input, [
                'name' => 'required|string',
                'username' => 'required|string|unique:users',
                'role_id' => 'required|integer',
                'dinas_id' => 'required|integer',
                'bidang_id' => 'required|integer',
                'phone' => 'nullable|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return $this->error("Parameter is missing");
            }


            // Simpan user ke database
            $result = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'role_id' => $request->role_id,
                'dinas_id' => $request->dinas_id,
                'bidang_id' => $request->bidang_id,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return $this->success('User created successfully.', $result);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    // Menampilkan detail user
    public function show(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {

            return $this->success("Berhasil mengambil data", $user);
        } else {
            return $this->error("User not found",);
        }
    }

    // Menampilkan form untuk mengedit user
    public function edit(User $user)
    {
    }

    // Memperbarui user di database
    public function update(Request $request, $id)
    {
        try {
            $input = $request->all();
            // return $input;

            $validator = Validator::make($input, [
                'name' => 'required|string',
                'username' => 'required|string',
                'role_id' => 'required|integer',
                'dinas_id' => 'required|integer',
                'bidang_id' => 'required|integer',
                'phone' => 'nullable|string',
                'email' => 'required|email',
                // 'password' => 'nullable|string|min:6',
            ]);

            if ($validator->fails()) {
                return $this->error("Parameter is missing " . $validator->errors());
            }

            $user = User::find($id);


            if ($user) {
                // Perbarui data user
                $result = $user->update([
                    'name' => $request->name ?? $user->name,
                    'username' => $request->username ?? $user->username,
                    'role_id' => $request->role_id ?? $user->role_id,
                    'dinas_id' => $request->dinas_id ?? $user->dinas_id,
                    'bidang_id' => $request->bidang_id ?? $user->bidang_id,
                    'phone' => $request->phone ?? $user->phone,
                    'email' => $request->email ?? $user->email,
                ]);
                // Perbarui password jika ada perubahan
                if ($request->filled('password')) {
                    $user->update([
                        'password' => Hash::make($request->password),
                    ]);
                }
                return $this->success('User updated successfully.', $result);
            } else {
                return $this->error('User not found.');
            }
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    // Menghapus user dari database
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return $this->success("Berhasil menghapus data", null);
        } else {
            return $this->error('User not found.');
        }
    }
}
