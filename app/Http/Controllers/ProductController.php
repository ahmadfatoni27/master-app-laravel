<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// $sess = $request->session()->get('name');
		// if ($sess !== null) {
		return view('products.index');
		// } else {
		// 	return redirect('/sigin');
		// }
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	// done
	public function getDataAll(Request $request)
	{
		print_r($request);
		die();
		$filtervalue = $request->input('filtervalue');
		$filtertext = $request->input('filtertext');
		$start 		= $request->input('start');
		$length 	= $request->input('length');

		// FILTERED DATA IN LIST DATA - FRONT END

		// main Query.		
		$sql = DB::table('products')
			->select(DB::raw('id,name,price,stock,description,created_at'))
			->where('' . $filtervalue . '', 'like', '%' . $filtertext . '%')
			->limit($length, $start);

		$queryall = $sql->get();
		$data  	  = $queryall;
		$total 	  = $sql->count();
		$dataRecord = array(
			"RecordsTotal" => $total,
			"RecordsFiltered" => $total,
			"Data" => $data,
		);
		return json_encode($dataRecord);
	}

	// done
	public function GetDataSelect(Request $request)
	{
		$data = $request->input('id');
		// print_r($data);die();
		// main Query.
		$sql  = DB::table('products')
			->select(DB::raw('products.*'))
			->where('products.id', '=', $data['id']);
		$res = $sql->get();
		return json_decode($res);
	}

	// done
	public function Insert(Request $request)
	{
		// main data insert.
		$Data = [
			'name'        => $request->input('name'),
			'price'       => $request->input('price'),
			'stock'       => $request->input('stock'),
			'description' => $request->input('description'),
		];

		DB::table("products")
			->insert($Data);
		$status = "Inserted";


		return json_encode(array("result" => $status));
	}

	public function Update(Request $request)
	{
		$d = $request->input('id');
		// main data insert.
		$Data = [
			'name'        => $request->input('name'),
			'price'       => $request->input('price'),
			'stock'       => $request->input('stock'),
			'description' => $request->input('description'),
		];
		// UPDATE - if Mode == "Update"
		DB::table('products')
			->where('id', $d)->update($Data);
		$status = "Updated";

		return json_encode(array("result" => $status));
	}

	// done
	public function destroy(Request $request)
	{ // DONE
		$id = $request->input('id');
		DB::table('products')->where('id', '=', $id)->delete();
		return json_encode(array("result" => "OK"));
	}

	// done
	public function functionSelect(Request $request)
	{ // DONE
		$sql  = DB::table('products')
			->select(DB::raw('products.*'));
		$res = $sql->get();

		return $res;
	}
}
