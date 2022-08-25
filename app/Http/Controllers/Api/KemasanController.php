<?php

namespace App\Http\Controllers\Api;

use App\Models\Modelkemasan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\KemasanResource;
use Illuminate\Support\Facades\Validator;
use DB;

class KemasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new KemasanResource(Modelkemasan::all());
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
            'nama_kemasan' => 'required'
        ]);

        // response error validation
        if ($validator->fails()) {
            return response()->json($validator->error(), 400);
        }

        // save into database
        $modelkemasan = Modelkemasan::create([
            'nama_kemasan' => $request->kemasan
        ]);
        return new KemasanResource($modelkemasan);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $modelkemasan = Modelkemasan::find($request->kemasan);
        return new KemasanResource($modelkemasan);
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
    public function update(Request $request, Modelkemasan $modelkemasan)
    {
        //set validation
        $validator = Validator::make($request->all(),[
            'nama_kemasan' => 'required'
        ]);

        // response error validation
        if ($validator->fails()) {
            return response()->json($validator->error(), 400);
        }

        $modelkemasan = Modelkemasan::find($request->kemasan);
        $modelkemasan->update([
            'nama_kemasan' => $request->kemasan
        ]);
        return new KemasanResource($modelkemasan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Modelkemasan $modelkemasan)
    {
        $modelkemasan = Modelkemasan::find($request->kemasan);
        if ($modelkemasan) {
            $modelkemasan->delete();
        }else{
            dd("data not found");
        }
        return new KemasanResource($modelkemasan);
    }
}
