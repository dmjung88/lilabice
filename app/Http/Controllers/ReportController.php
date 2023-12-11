<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // 24 - 1 신품발행 조회 (사용자가 날짜 + 도매장 전부입력했을때)
    public function reportNewSearch(Request $request) {
        $sql = "SELECT 
        g.REG_DATE ,s.STORE_NAME ,s.STORE_ADDRESS ,s.STORE_PHONE
        ,g.GOODS_NAME ,g.GOODS_TYPE ,g.note ,g.PURCH_COST      
        FROM 
        t_master_goods g, t_master_store s  WHERE g.WHOLE_CODE = s.WHOLE_CODE
        AND g.reg_date >= ? AND g.reg_date <= ? AND s.STORE_NAME LIKE ? ";
        $reportNewSearch = DB::select($sql , [$request->startDate, $request->lastDate,"%$request->storeName%"]);
        $response = array('response' => ["message"=> "발행-신품 : 조회일자 + 도매장 으로 검색", "data"=> $reportNewSearch], 'success'=> true);
        return Response::json($response, 200);
    }
    // 24 - 2 신품발행 조회 (사용자가 날짜만 입력시)
    public function reportNewSearchNoWhole(Request $request) {
        $sql = "SELECT 
        g.REG_DATE ,s.STORE_NAME ,s.STORE_ADDRESS ,s.STORE_PHONE
        ,g.GOODS_NAME ,g.GOODS_TYPE ,g.note ,g.PURCH_COST      
        FROM 
        t_master_goods g, t_master_store s  WHERE g.WHOLE_CODE = s.WHOLE_CODE
        AND g.reg_date >= ? AND g.reg_date <= ? ";
        $reportNewSearch = DB::select($sql , [$request->startDate, $request->lastDate]);
        $response = array('response' => ["message"=> "발행-신품 : 조회일자로 검색", "data"=> $reportNewSearch], 'success'=> true);
        return Response::json($response, 200);
    }
}
