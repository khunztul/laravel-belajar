<?php

namespace App\Http\Controllers\Api;

use App\Models\Modelkategori;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\KategoriResource;
use Illuminate\Support\Facades\Validator;
use DB;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return new KategoriResource(Modelkategori::all());
        $result = [];
        $data =  DB::table('modelkategoris')
            ->join(
                'modelproduks',
                'modelproduks.kategori',
                '=',
                'modelkategoris.id'
            )
            ->get();
        for ($d = 0; $d < count($data); $d++) {
            $p = $data[$d];
            array_push($result, $p);
        }
        return response()->json(['status' => 'success', 'data' => $result, 'code' => 200]);
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
        //set validation
        $validator = Validator::make($request->all(),[
            'nama_kategori' => 'required'
        ]);

        // response error validation
        if ($validator->fails()) {
            return response()->json($validator->error(), 400);
        }

        // save into database
        $modelkategori = Modelkategori::create([
            'nama_kategori' => $request->kategori
        ]);
        return new KategoriResource($modelkategori);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $modelkategori = Modelkategori::find($request->kategori);
        return new KategoriResource($modelkategori);
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
    public function update(Request $request, Modelkategori $modelkategori)
    {
        //set validation
        $validator = Validator::make($request->all(),[
            'nama_kategori' => 'required'
        ]);

        // response error validation
        if ($validator->fails()) {
            return response()->json($validator->error(), 400);
        }

        $modelkategori = Modelkategori::find($request->kategori);
        $modelkategori->update([
            'nama_kategori' => $request->kategori
        ]);
        return new KategoriResource($modelkategori);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Modelkategori $modelkategori)
    {
        $modelkategori = Modelkategori::find($request->kategori);
        if ($modelkategori) {
            $modelkategori->delete();
        }else{
            dd("data not found");
        }
        return new KategoriResource($modelkategori);
    }
}
