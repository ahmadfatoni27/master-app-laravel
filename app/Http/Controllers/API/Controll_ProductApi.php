<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\API\ProductApi;
use Illuminate\Support\Facades\DB;


class Controll_ProductApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sql = DB::table('products')
            ->select(DB::raw('id,name,price,stock,description,created_at'))
            ->paginate(15);
        return json_encode($sql);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required'
        ]);

        $result = DB::table('products')->insert([
            'name'        => $request->input('name'),
            'price'       => $request->input('price'),
            'stock'       => $request->input('stock'),
            'description' => $request->input('description'),
        ]);

        return json_encode($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = DB::table('products')->find($id);
        $msg = [
            "message" => "data not found",
        ];
        return empty($result) ? json_encode($msg) : $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required'
        ]);

        $result = DB::table('products')
            ->where('id', $id)
            ->update([
                'name'        => $request->input('name'),
                'price'       => $request->input('price'),
                'stock'       => $request->input('stock'),
                'description' => $request->input('description'),
            ]);

        return json_encode($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $result = DB::table('products')->destroy($id);
        $result = DB::table('products')->where('id', $id)->delete();
        return $result;
    }

    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($searchBy, $Value)
    {
        $sql = DB::table('products')
            ->select(DB::raw('id,name,price,stock,description,created_at'))
            ->where('' . $searchBy . '', 'like', '%' . $Value . '%')->get();
        return json_encode($sql);
    }
}
