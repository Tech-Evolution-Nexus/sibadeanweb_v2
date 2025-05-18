<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where("role", "!=", "admin")->where("status", 1)->orderBy("created_at", "desc")->get();

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
            "role" => "required",
            "status" => "required",
            "masa_jabatan_mulai" => "required|date",
            "masa_jabatan_selesai" => "required|date|after:masa_jabatan_mulai"
        ]);

        $validated["password"] = bcrypt($validated["password"]);
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
            "name" => "required|min:3|max:50",
            "email" => "required|email|unique:users,email," . $user->id,
            "role" => "required",
            "status" => "required",
            "masa_jabatan_mulai" => "required|date",
            "masa_jabatan_selesai" => "required|date|after:masa_jabatan_mulai"
        ]);

        if ($request->filled("password")) {
            $validated["password"] = bcrypt($request->password);
        }

        $user->update($validated);
        return redirect()->route("users.index")->with("success", "User berhasil diperbarui");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route("users.index")->with("success", "User berhasil dihapus");
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
            ->addColumn('action', function ($row) {
                return '<div class="row flex">
                    <a href="' . route("users.edit", $row->id) . '" class="btn-edit">Edit</a>
                    <form action="' . route("users.destroy", $row->id) . '" method="POST" onsubmit="return confirm(\'Yakin ingin menghapus user ini?\')" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn-delete">Hapus</button>
                    </form>
                    </div>';
            })
                ->addColumn('nama_lengkap', function ($row) {
                return $row->masyarakat->nama_lengkap;
            })
            ->rawColumns(["action"])
            ->make(true);
    }
}
