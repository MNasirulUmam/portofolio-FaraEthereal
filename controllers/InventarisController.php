<?php

namespace controllers;

class InventarisController
{
    public function index(Request $request)
    {
        $page = 'master';
        $data = About::all();
        if($request->ajax()){
            return DataTables::of($data)
                ->addColumn('title', function($row){
                    return $row->title;
                })
                ->addColumn('description', function($row){
                    return Str::limit($row->description,20);
                })
                ->addColumn('action', function($row){
                    $button  = '';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a  href="javascript:void(0)" onclick="updateItem(this)" data-id="'.$row->id.'" class="btn btn-sm btn-warning btn-icon btn-round"><i class="bx bx-edit-alt"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a  href="javascript:void(0)" onclick="showItem(this)" data-id="'.$row->id.'" class="btn btn-sm btn-info btn-icon btn-round"><i class="bx bx-show-alt"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button onclick="deleteItem(this)" data-name="'.$row->title.'" data-id="'.$row->id.'" class="btn btn-sm btn-danger btn-icon btn-round"><i class="bx bx-trash-alt"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('pages.abouts.index',compact('page'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|unique:abouts,title|max:100',
            'description'    => 'required'
        ],[
            'title.required'            => 'Title harus terisi',
            'title.unique'              => 'Title sudah terdaftar sebelumnya ',
            'title.max'                 => 'Title idak boleh lebih dari 100 karakter',
            'description.required'      => 'Deskripsi harus terisi',
        ]);

        $data = $request->all();
        $about = About::create($data);
        if($about){
            return response()->json([
                'code'      => 200,
                'message'   => 'Data berhasil disimpan.'
            ]);
        }else{
            return response()->json([
                'code'      => 400,
                'message'   => 'Data gagal disimpan.'
            ]);
        }
    }

    public function show(int $id)
    {
        return response()->json(About::findOrFail($id));
    }

    public function edit(int $id)
    {
        return response()->json(About::findOrFail($id));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'title'          => 'required|max:100|unique:abouts,title,'.$id,
            'description'    => 'required'
        ],[
            'title.required'            => 'Title harus terisi',
            'title.max'                 => 'Title idak boleh lebih dari 100 karakter',
            'title.unique'              => 'Title sudah terdaftar sebelumnya ',
            'description.required'      => 'Deskripsi harus terisi',
        ]);

        $about = About::findOrFail($id);
        $data = $request->all();
        $about->update($data);

        if($about){
            return response()->json([
                'code'      => 200,
                'message'   => 'Data berhasil di update.'
            ]);
        }else{
            return response()->json([
                'code'      => 400,
                'message'   => 'Data gagal di update.'
            ]);
        }
    }

    public function destroy(int $id)
    {
        $about = About::findOrFail($id);

        if($about){
            $about->delete();
            return response()->json([
                'code'      => 200,
                'message'   => 'Data berhasil di hapus.'
            ]);
        }else{
            return response()->json([
                'code'      => 400,
                'message'   => 'Data gagal di hapus.'
            ]);
        }
    }
    
}
