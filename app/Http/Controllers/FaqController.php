<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FaqController extends Controller
{
    public function index()
    {

        $faq = Faq::orderBy("id", "desc")->get();
        $params["data"] = (object)[
            "question" => $faq
        ];


        if (request()->ajax()) {
            return $this->dataTable($faq);
        }
        return view("admin.faq.faq", $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $params["data"] = (object)[
            "title" => "Tambah FAQ",
            "action_form" => route("faq.store"),
            "method" => "POST",
            "data" => (object)[
                "question" => "",
                "answer" => "",
            ]
        ];
        return view("admin.faq.form", $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // Validasi data menggunakan request() dan validasi bahasa Indonesia
        $validated = request()->validate( [
            "question" => "required",
            "answer" => "required",
        ]);
        // Menyimpan data kartu keluarga
        Faq::create($validated);

        return redirect()->route('faq.index')->with('success', 'FAQ berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Faq $faqModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $faq = Faq::find($id);
        $params["data"] = (object)[
            "title" => "Ubah FAQ",
            "action_form" => route("faq.update", $id),
            "method" => "PUT",
            "data" => (object)[
                "question" => $faq->question,
                "answer" => $faq->answer,


            ]
        ];
        return view("admin.faq.form", $params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {

        $validated = request()->validate(
            [
                "question" => "required",
                "answer" => "required",
            ]
        );

        try {
            // Cari data kartu keluarga berdasarkan ID
            Faq::findOrFail($id)->update($validated);

            return redirect()->route('faq.index')->with('success', 'FAQ berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'FAQ gagal diperbarui');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $faqModel = Faq::findOrFail($id);
        $faqModel->delete();
        return redirect()->back()->with('success', 'FAQ berhasil dihapus');
    }



    public function dataTable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="row flex">';
                $btn .= ' <a href="' . route('faq.edit', $row->id) . '" class="btn-edit"><i class="fa fa-pencil"></i></a>';
                $message = "Apakah anda yakin menghapus data {$row->judul}?";
                $btn .= "<button class='btn-delete' x-data x-on:click=\"\$dispatch('open-modal', {name: 'delete'}), message= '$message', url= '" . route("faq.destroy", $row->id) . "'\"><i class='fa fa-trash'></i></button>";
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('answer', function ($row) {
                return \Str::limit($row->answer,70);
            })
            ->rawColumns(['gambar', 'action',"answer"])
            ->make(true);
    }
}
