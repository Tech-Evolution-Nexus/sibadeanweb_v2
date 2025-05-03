<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with("petugas")->where("role", "!=", "masyarakat")->orderBy("created_at", "desc")->get();

        if (request()->ajax()) {
            return $this->dataTable($users);
        }

        return view("admin.petugas.petugas", ["users" => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.petugas.form", [
            "title" => "Tambah petugas",
            "action_form" => route("petugas.store"),
            "method" => "POST",
            "data" => new User()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "nip" => "required|numeric|digits:16",
            "nama" => "required|min:3|max:50",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6",
            "role" => "required",
            "status" => "required",
        ]);

        DB::beginTransaction();
        try {
            // Simpan ke tabel users
            $user = User::create([
                "email" => $validated["email"],
                "password" => bcrypt($validated["password"]),
                "role" => $validated["role"],
                "status" => $validated["status"],
            ]);

            // Simpan ke tabel petugas
            Petugas::create([
                "nip" => $validated["nip"],
                "nama" => $validated["nama"],
                "id_user" => $user->id,
            ]);

            DB::commit();
            return redirect()->route("petugas.index")->with("success", "Petugas berhasil ditambahkan");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal simpan petugas: " . $e->getMessage());
            return back()->withErrors("Terjadi kesalahan: " . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $petugas = Petugas::with('user')->where('id_user', $id)->first();

        if (!$petugas) {
            return redirect()->route('petugas.index')->with('error', 'Petugas tidak ditemukan');
        }
        return view("admin.petugas.form", [
            "title" => "Edit Petugas",
            "action_form" => route("petugas.update", $petugas->id_user),
            "method" => "PUT",
            "data" => $petugas
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $petugas = Petugas::with('user')->where('id_user', $id)->first();

        if (!$petugas) {
            return redirect()->route('petugas.index')->with('error', 'Petugas tidak ditemukan');
        }

        $validated = $request->validate([
            "nip" => "required|numeric|digits:16",
            "nama" => "required|min:3|max:50",
            "email" => [
                "sometimes",
                "email",
                Rule::unique('users', 'email')->ignore($petugas->id_user),
            ],
            "password" => "nullable|min:6",
            "role" => "required",
            "status" => "required",
        ]);

        if ($request->filled("password")) {
            $validated["password"] = bcrypt($request->password);
        } else {
            // Don't include the password in the update if it's not filled
            unset($validated['password']);
        }

        DB::beginTransaction();
        try {
            // Update user
            $petugas->user->update($validated);

            // Update petugas
            $petugas->update([
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
            ]);

            DB::commit();
            return redirect()->route("petugas.index")->with("success", "Petugas berhasil diperbarui");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal update petugas: " . $e->getMessage());
            return back()->withErrors("Terjadi kesalahan: " . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $petugas = Petugas::with('user')->where('id_user', $id)->first();

        if ($petugas) {
            DB::beginTransaction();
            try {
                // Delete petugas first to maintain integrity
                $petugas->delete();

                // Then delete the associated user
                $petugas->user->delete();

                DB::commit();
                return redirect()->route("petugas.index")->with("success", "Petugas dan user berhasil dihapus");
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Gagal hapus petugas: " . $e->getMessage());
                return back()->withErrors("Terjadi kesalahan: " . $e->getMessage());
            }
        }

        return redirect()->route("petugas.index")->with("error", "Petugas tidak ditemukan");
    }

    /**
     * Handle DataTables AJAX request.
     */
    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<div class="row flex">
                    <a href="' . route("petugas.edit", $row->id) . '" class="btn-edit">Edit</a>
                    <form action="' . route("petugas.destroy", $row->id) . '" method="POST" onsubmit="return confirm(\'Yakin ingin menghapus user ini?\')" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn-delete">Hapus</button>
                    </form>
                    </div>';
            })
            ->rawColumns(["action"])
            ->make(true);
    }
}
