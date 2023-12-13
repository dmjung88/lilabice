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
        T_MASTER_GOODS g, T_MASTER_STORE s, T_MASTER_WHOLESALE w 
        WHERE g.WHOLE_CODE = s.WHOLE_CODE AND w.WHOLE_CODE = s.WHOLE_CODE
        AND g.REG_DATE >= ? AND g.REG_DATE <= ? AND w.WHOLE_NAME LIKE ? ";
        $reportNewSearch = DB::select($sql , [$request->startDate, $request->lastDate,"%{$request->wholeName}%"]);
        $response = array('response' => ["message"=> "발행-신품 : 조회일자 + 도매장 으로 검색", "data"=> $reportNewSearch], 'success'=> true);
        return Response::json($response, 200);
    }
    // 24 - 2 신품발행 조회 (사용자가 날짜만 입력시)
    public function reportNewSearchNoWhole(Request $request) {
        $sql = "SELECT 
        g.REG_DATE ,s.STORE_NAME ,s.STORE_ADDRESS ,s.STORE_PHONE
        ,g.GOODS_NAME ,g.GOODS_TYPE ,g.note ,g.PURCH_COST      
        FROM 
        T_MASTER_GOODS g, T_MASTER_STORE s  WHERE g.WHOLE_CODE = s.WHOLE_CODE
        AND g.REG_DATE >= ? AND g.REG_DATE <= ? ";
        $reportNewSearch = DB::select($sql , [$request->startDate, $request->lastDate]);
        $response = array('response' => ["message"=> "발행-신품 : 조회일자로 검색", "data"=> $reportNewSearch], 'success'=> true);
        return Response::json($response, 200);
    }

    //25 -1 발행 = 재고현황 조회 (날짜 + 도매장)
    public function reportStockSearch(Request $request) {
        $stock = DB::table('T_MASTER_GOODS','g')
        ->join('T_MASTER_STORE AS s', 'g.WHOLE_CODE','=','s.WHOLE_CODE')
        ->join('T_MASTER_WHOLESALE AS w', 'w.WHOLE_CODE', '=', 's.WHOLE_CODE')
        ->join('T_MASTER_FIX as f', 'f.REG_ID', '=', 's.REG_ID')
        ->select("s.STORE_NAME","g.REG_DATE","s.STORE_ADDRESS","s.STORE_PHONE","g.GOODS_NAME"
        ,"g.GOODS_MODEL_YEAR","g.NOTE","f.SALES_COST","f.PURCH_COST" )
        ->whereRaw("s.REG_DATE >= ? AND s.REG_DATE <= ? AND w.WHOLE_NAME LIKE ? ",[$request->startDate, $request->lastDate,"%$request->storeName%"])
        ->get();
        $response = array('response' => ["message"=> "재고현황 : 조회일자 + 도매장명 으로 검색", "data"=> $stock], 'success'=> true);
        return Response::json($response, 200);
    }

    

    //25 -2 발행 재고현황 조회(날짜만)
    public function reportStockSearchNoWhole(Request $request) {
        $stock = DB::table('T_MASTER_GOODS','g')
        ->join('T_MASTER_STORE AS s', 'g.WHOLE_CODE','=','s.WHOLE_CODE')
        ->join('T_MASTER_FIX as f', 'f.REG_ID', '=', 's.REG_ID')
        ->select("s.STORE_NAME","g.REG_DATE","s.STORE_ADDRESS","s.STORE_PHONE","g.GOODS_NAME"
        ,"g.GOODS_MODEL_YEAR","g.NOTE","f.SALES_COST","f.PURCH_COST" )
        ->where([
            ['s.REG_DATE', '>=', $request->startDate],
            ['s.REG_DATE', '<=', $request->lastDate],
        ])->get();

        $response = array('response' => ["message"=> "재고현황 : 조회일자로 검색", "data"=> $stock], 'success'=> true);
        return Response::json($response, 200);
    }
    // 발행 간편출고 현황(날짜 + 도매장)
    public function reportOutputSearch(Request $request) {
        $output = DB::table('T_MASTER_GOODS','g')
        ->join('T_MASTER_STORE AS s', 'g.WHOLE_CODE','=','s.WHOLE_CODE')
        ->join('T_MASTER_FIX as f', 'f.REG_ID', '=', 's.REG_ID')
        ->join('T_MASTER_WHOLESALE AS w', 'w.WHOLE_CODE', '=', 's.WHOLE_CODE')
        ->select("s.STORE_NAME","S.REG_DATE","s.STORE_ADDRESS","s.STORE_PHONE","g.GOODS_NAME"
        ,"g.GOODS_MODEL_YEAR","g.NOTE","f.SALES_COST","f.PURCH_COST","f.NOTE")
        ->where([
            ['g.REG_DATE', '>=', $request->startDate],
            ['g.REG_DATE', '<=', $request->lastDate],
            ['w.WHOLE_NAME', 'like', "%$request->wholeName%"],
        ])->get();

        $response = array('response' => ["message"=> "간편출고현황 날짜 + 도매장 검색", "data"=> $output], 'success'=> true);
        return Response::json($response, 200);
    }
    // 발행 간편출고 현황(날짜만)
    public function reportOutputSearchNoWhole(Request $request) {
        $output = DB::table('T_MASTER_GOODS','g')
        ->join('T_MASTER_STORE AS s', 'g.WHOLE_CODE','=','s.WHOLE_CODE')
        ->join('T_MASTER_FIX as f', 'f.REG_ID', '=', 's.REG_ID')
        ->select('s.*', 'g.*' ,'f.*' )
        ->whereDate('g.REG_DATE', '>=', $request->startDate)
        ->whereDate('g.REG_DATE', '<=', $request->lastDate)
        ->get();
        $response = array('response' => ["message"=> "간편출고현황 날짜 검색", "data"=> $output], 'success'=> true);
        return Response::json($response, 200);
    }

    // 발행 회수 현황(날짜 + 도매장)
    public function reportWithdrawalSearch(Request $request) {
        $withdrawal = DB::table('T_MASTER_GOODS','g')
        ->join('T_MASTER_STORE AS s', 'g.WHOLE_CODE','=','s.WHOLE_CODE')
        ->join('T_MASTER_FIX as f', 'f.REG_ID', '=', 's.REG_ID')
        ->select('s.*', 'g.*' ,'f.*' )
        ->where([
            ['g.REG_DATE', '>=', $request->startDate],
            ['g.REG_DATE', '<=', $request->lastDate],
            ['g.WHOLE_CODE', 'like', "%$request->wholeName%"],
        ])->get();

        $response = array('response' => ["message"=> "발행 회수 현황 날짜 + 도매장 검색", "data"=> $withdrawal], 'success'=> true);
        return Response::json($response, 200);
    }
    // 발행 회수 현황(날짜만)
    public function reportWithdrawalSearchNoWhole(Request $request) {
        $withdrawal = DB::table('T_MASTER_GOODS','g')
        ->join('T_MASTER_STORE AS s', 'g.WHOLE_CODE','=','s.WHOLE_CODE')
        ->join('T_MASTER_FIX as f', 'f.REG_ID', '=', 's.REG_ID')
        ->select('s.*', 'g.*' ,'f.*' )
        ->whereDate('g.REG_DATE', '>=', $request->startDate)
        ->whereDate('g.REG_DATE', '<=', $request->lastDate)
        ->get();
        $response = ['response' => ["message"=> "발행 회수 현황 날짜 검색", "data"=> $withdrawal], 'success'=> true];
        return Response::json($response, 200);
    }
    // 매출처별 집계현황(날짜 + 도매장)
    public function reportTotalSearch(Request $request) {
       return '집게';
    }
    // 매출처별 집계현황(날짜만)
    public function reportTotalSearchNoWhole(Request $request) {
        print '집게';
    }
    
     // A/S 회수 현황(날짜 + 도매장)
     public function reporWarrantySearch(Request $request) {
        $warranty = DB::table('T_MASTER_GOODS','g')
        ->join('T_MASTER_STORE AS s', 'g.WHOLE_CODE','=','s.WHOLE_CODE')
        ->join('T_MASTER_FIX as f', 'f.REG_ID', '=', 's.REG_ID')
        ->select('s.*', 'g.*' ,'f.*' )
        ->where([
            ['g.REG_DATE', '>=', $request->startDate],
            ['g.REG_DATE', '<=', $request->lastDate],
            ['g.WHOLE_CODE', 'like', "%$request->wholeName%"],
        ])->get();

        $response = array('response' => ["message"=> "A/S 회수 현황 날짜 + 도매장 검색", "data"=> $warranty], 'success'=> true);
        return Response::json($response, 200);
    }
    // A/S 회수 현황 회수 현황(날짜만)
    public function reportWarrantySearchNoWhole(Request $request) {
        $warranty = DB::table('T_MASTER_GOODS','g')
        ->join('T_MASTER_STORE AS s', 'g.WHOLE_CODE','=','s.WHOLE_CODE')
        ->join('T_MASTER_FIX as f', 'f.REG_ID', '=', 's.REG_ID')
        ->select('s.*', 'g.*' ,'f.*' )
        ->whereDate('g.REG_DATE', '>=', $request->startDate)
        ->whereDate('g.REG_DATE', '<=', $request->lastDate)
        ->get();
        $response = ['response' => ["message"=> "A/S 회수 현황 날짜 검색", "data"=> $warranty], 'success'=> true];
        return Response::json($response, 200);
    }

     // 매출처별 집계 현황(날짜 + 도매장)
     public function clientTotalSearch(Request $request) {
        $warranty = DB::table('T_MASTER_GOODS','g')
        ->join('T_MASTER_STORE AS s', 'g.WHOLE_CODE','=','s.WHOLE_CODE')
        ->join('T_MASTER_FIX as f', 'f.REG_ID', '=', 's.REG_ID')
        ->select('s.*', 'g.*' ,'f.*' )
        ->where([
            ['g.REG_DATE', '>=', $request->startDate],
            ['g.REG_DATE', '<=', $request->lastDate],
            ['g.WHOLE_CODE', 'like', "%$request->wholeName%"],
        ])->get();

        $response = array('response' => ["message"=> "매출처별 집계 현황 날짜 + 도매장 검색", "data"=> $warranty], 'success'=> true);
        return Response::json($response, 200);
    }
    // 매출처별 집계 현황 현황(날짜만)
    public function clientTotalSearchNoWhole(Request $request) {
        $warranty = DB::table('T_MASTER_GOODS','g')
        ->join('T_MASTER_STORE AS s', 'g.WHOLE_CODE','=','s.WHOLE_CODE')
        ->join('T_MASTER_FIX as f', 'f.REG_ID', '=', 's.REG_ID')
        ->select('s.*', 'g.*' ,'f.*' )
        ->whereDate('g.REG_DATE', '>=', $request->startDate)
        ->whereDate('g.REG_DATE', '<=', $request->lastDate)
        ->get();
        $response = ['response' => ["message"=> "매출처별 집계 현황 날짜 검색", "data"=> $warranty], 'success'=> true];
        return Response::json($response, 200);
    }

}
