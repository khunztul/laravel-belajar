<?php

namespace App\Http\Controllers\Api;

use App\Models\Modelproduk;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProdukResource;
use Illuminate\Support\Facades\Validator;
use DB;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return new ProdukResource(Modelproduk::all());
        // dd("test");
        $result = [];
        $data =  DB::table('modelproduks')
            ->join(
                'modelkategoris',
                'modelproduks.kategori',
                '=',
                'modelkategoris.id'
            )
            ->join(
                'modelkemasans',
                'modelproduks.kemasan',
                '=',
                'modelkemasans.id'
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
            'product' => 'required',
            'kategori' => 'required',
            'kemasan' => 'required'
        ]);

        // response error validation
        if ($validator->fails()) {
            return response()->json($validator->error(), 400);
        }

        // save into database
        $modelproduk = Modelproduk::create([
            'product' => $request->product,
            'description' => $request->description,
            'kategori' => $request->kategori,
            'kemasan' => $request->kemasan
        ]);
        return new ProdukResource($modelproduk);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Modelproduk $modelproduk)
    {

        // dd($request->produk);
        $modelproduk = Modelproduk::find($request->produk);
        return new ProdukResource($modelproduk);
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
    public function update(Request $request, Modelproduk $modelproduk)
    {
        // dd($request->produk);
        //set validation
        $validator = Validator::make($request->all(),[
            'product' => 'required',
            'kategori' => 'kategori',
            'kemasan' => 'kemasan'
        ]);

        // response error validation
        if ($validator->fails()) {
            return response()->json($validator->error(), 400);
        }
        
        $modelproduk = Modelproduk::find($request->produk);
        $modelproduk->update([
            'product' => $request->product,
            'description' => $request->description,
            'kategori' => $request->kategori,
            'kemasan' => $request->kemasan
        ]);
        return new ProdukResource($modelproduk);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Modelproduk $modelproduk)
    {
        $modelproduk = ModelProduk::find($request->produk);
        if ($modelproduk) {
            $modelproduk->delete();
        }else{
            dd("data not found");
        }
        return new ProdukResource($modelproduk);
    }
}
