<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Common;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function wholeSale(Request $request)   {
        $wholeCode = $request->wholeCode; //도매장코드
        $wholeName = $request->wholeName; //도매장명
        $wholeCode = str_replace('-', '', $wholeCode);
        $wholeSale = DB::table('MASTER_WHOLESALE')
        ->where('WHOLE_CODE', $wholeCode)
        ->orwhere('WHOLE_NAME', $wholeName)
        ->get();
        $response = array('response' => ["message"=> "도매장검색", "data"=> $wholeSale], 'success'=> true);
        return Response::json($response, 200);
    }

    public function wholesaleBizNum(Request $request) {
        $wholeBizNum = str_replace('-', '', $request->wholeBizNum); //도매장 사업자번호
        $wholesaleBizNum = DB::table('MASTER_WHOLESALE')
        ->where('WHOLE_BIZ_NUM',$wholeBizNum)
        ->get(); 
        $response = array('response' => ["message"=> "도매장 사업자번호", "data"=> $wholesaleBizNum], 'success'=> true);
        return Response::json($response, 200);

    }
    public function store() {
        $store = Common::get();
        $response = array('response' => ["message"=> "업소명 검색", "data"=> $store], 'success'=> true);
        return Response::json($response, 200);
    }

    public function goods() {
        $goods = Common::get();
        $response = array('response' => ["message"=> "상품명 검색", "data"=> $goods], 'success'=> true);
        return Response::json($response, 200);
    }
    public function maker() {
        $maker = Common::get();
        $response = array('response' => ["message"=> "제조사명 검색", "data"=> $maker], 'success'=> true);
        return Response::json($response, 200);
    }
    public function goodsType() {
        $goodsType = Common::get();
        $response = array('response' => ["message"=> "상품 구분", "data"=> $goodsType], 'success'=> true);
        return Response::json($response, 200);
    }
    public function assignWholesale(Request $request) {
        $assignWholesale = DB::table('MASTER_WHOLESALE')
        ->join('MASTER_STORE', 'master_wholesale.WHOLE_CODE', '=', 'master_store.WHOLE_CODE')
        ->select('MASTER_WHOLESALE.*', 'master_store.*', )
        ->where('master_store.STORE_NAME',$request->storeName)
        ->get();
        $response = array('response' => ["message"=> "업소의 소속 도매장", "data"=> $assignWholesale], 'success'=> true);
        return Response::json($response, 200);
    }

    
}
