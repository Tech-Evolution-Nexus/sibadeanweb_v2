<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereNotIn("role", ["admin", "petugas", "lurah"])->with("masyarakat")->where("status", 1)->orderBy("created_at", "desc")->get();
        if (request()->ajax()) {
            return $this->dataTable($users);
        }

        return view("admin.user.index", ["users" => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.user.form", [
            "title" => "Tambah User",
            "action_form" => route("users.store"),
            "method" => "POST",
            "data" => new User()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|min:3|max:50",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6",
            "status" => "required",
            "masa_jabatan_mulai" => "required|date",
            "masa_jabatan_selesai" => "required|date|after:masa_jabatan_mulai"
        ]);

        $validated["password"] = bcrypt($validated["password"]);
        $validated["role"] = "user";
        User::create($validated);
        return redirect()->route("users.index")->with("success", "User berhasil ditambahkan");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view("admin.user.form", [
            "title" => "Edit User",
            "action_form" => route("users.update", $user->id),
            "method" => "PUT",
            "data" => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            // "name" => "required|min:3|max:50",
            "email" => "required|email|unique:users,email," . $user->id,
            "status" => "required",
            // "masa_jabatan_mulai" => "required|date",
            // "masa_jabatan_selesai" => "required|date|after:masa_jabatan_mulai"
        ]);

        if ($request->filled("password")) {
            $validated["password"] = Hash::make($request->password);
        }
        $validated["role"] = "masyarakat";
        $user->update($validated);
        return redirect()->route("users.index")->with("success", "User berhasil diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route("users.index")->with("success", "User berhasil dihapus");
        } catch (QueryException $th) {
            if ($th->getCode() === '23000') {
                return redirect()->back()->with('error', 'Gagal menghapus karena data terkait masih digunakan.');
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan tak terduga.');
        }
    }

    /**
     * Handle DataTables AJAX request.
     */
    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('masa_jabatan', function ($row) {
                return $row->masa_jabatan_mulai . ' - ' . $row->masa_jabatan_selesai;
            })
            ->addColumn('status', function ($row) {
                return $row->status == 1 ? 'Aktif' : 'Nonaktif';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="row flex">
                    <a href="' . route("users.edit", $row->id) . '" class="btn-edit">
                    <i class="fa fa-pencil"></i>
                    </a>';
                $message = "Apakah anda yakin menghapus data {$row->masyarakat->nama_lengkap}?";
                $btn .= "<button class='btn-delete' x-data x-on:click=\"\$dispatch('open-modal', {name: 'delete'}), message= '$message', url= '" . route("users.destroy", $row->id) . "'\"><i class='fa fa-trash'></i></button>";
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(["action"])
            ->make(true);
    }
}
