<?php

namespace App\Http\Controllers\Api;

use App\Models\Modelcustomer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Facades\Validator;
use DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all data in table customer
        $data = DB::table('modelcustomers')->get();
        return $data;
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
            'nama' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'phone' => 'required'
        ]);

        // response error validation
        if ($validator->fails()) {
            return response()->json($validator->error(), 400);
        }

        // save into database
        $modelcustomer = Modelcustomer::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'phone' => $request->phone
        ]);
        return new CustomerResource($modelcustomer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Modelcustomer $modelcustomer)
    {
        $modelcustomer = Modelcustomer::find($request->customer);
        return new CustomerResource($modelcustomer);
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
    public function update(Request $request, Modelcustomer $modelcustomer)
    {
        //set validation
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'phone' => 'required'
        ]);

        // response error validation
        if ($validator->fails()) {
            return response()->json($validator->error(), 400);
        }
        
        $modelcustomer = Modelcustomer::find($request->customer);
        $modelcustomer->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'phone' => $request->phone
        ]);
        return new CustomerResource($modelcustomer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Modelproduk $modelproduk)
    {
        $modelcustomer = Modelcustomer::find($request->customer);
        if ($modelcustomer) {
            $modelcustomer->delete();
        }else{
            dd("data not found");
        }
        return new CustomerResource($modelcustomer);
    }
}
