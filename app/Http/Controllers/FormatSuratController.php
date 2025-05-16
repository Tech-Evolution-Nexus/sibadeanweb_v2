<?php

namespace App\Http\Controllers;

use App\Models\SuratModel;
use Illuminate\Http\Request;

class FormatSuratController extends Controller
{
    public function index()
    {
        $surat = SuratModel::orderBy("id", "desc")->get();
        return view("admin.format_surat.format_surat", compact("surat"));
    }
    public function edit($id)
    {
        $surat = SuratModel::find($id);
        $fields = count($surat->fields->toArray()) != 0 ? "{" . implode("}{", $surat->fields()->pluck("nama_field")->toArray()) . "}" : "";
        dd($fields);
        $params["data"] = (object) [
            "surat" => $surat,
            "fields" => $fields,
            "action_form" => route('format-surat.update', $id)
        ];
        return view("admin.format_surat.form", $params);
    }
    public function update($id)
    {
        $surat = SuratModel::find($id);
        $surat->update([
            "format_surat" => request()->format_surat
        ]);
        return redirect()->route("format-surat.index")->with("success", "Format surat berhasil diupdate");
    }
}
