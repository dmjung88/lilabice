<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    public function wholesale(Request $request) { // 도매장 저장
        $validator = Validator::make($request->all(), [ // Form_validation
            'iceNum' => 'required|numeric|max:10|min:1',
            'wholeCode'  => 'required',
            'wholeName'  => 'required',
            'wholePhone' => 'required',
            'wholeBiz'   => 'required',
            'wholeBizNum' => 'required',
            'wholeType'  => 'required',
            'wholeAddress' => 'required',
            'wholeZipcode' => 'required',
            'wholeEmail' => 'required',
            'wholeUseYN' => 'required',
            'note'       => 'required',
            'add1'       => 'required',
        ]);
        $response = array('response' => '', 'success'=> false);
        if ($validator->fails()) {
            $response['response'] = $validator->messages();
        } else {
            DB::table('MASTER_WHOLESALE')->insert([
                'ICE_NUM' => $request->input('iceNum'),
                'WHOLE_CODE' => $request->input('wholeCode'),
                'WHOLE_NAME' => $request->input('wholeName'),
                'WHOLE_PHONE' => $request->input('wholePhone'),
                'WHOLE_CEO' => $request->input('wholeCeo'),
                'WHOLE_BIZ' => $request->input('wholeBiz'),
                'WHOLE_BIZ_NUM' => $request->input('wholeBizNum'),
                'WHOLE_TYPE' => $request->input('wholeType'),
                'WHOLE_ADDRESS' => $request->input('wholeAddress'),
                'WHOLE_ZIPCODE' => $request->input('wholeZipcode'),
                'WHOLE_EMAIL' => $request->input('wholeEmail'),
                'WHOLE_USEYN' => $request->input('wholeUseYN'),
                'NOTE' => $request->input('note'),
                'ADD1' => $request->input('add1'),
            ]);
            $response['response'] = ["message"=> "도매장저장 성공" ];
            $response['success'] = true;
        }
        return Response::json($response, 201);
    }
    public function store(Request $request) { // 업소 저장
        $rules = [
            'iceNum'=>'required|numeric|max:10|min:1',
            'storeCode'=>'required',
            'storeName'=>'required',
            'wholeCode'=>'required',
            'storePhone'=>'required',
            'storeCeo' =>'required', 
            'storeBizNum'=>'required', 
            'storeBiz'=>'required', 
            'storeBizNum' =>'required',
            'storeType'=>'required',
            'companyEmp' => 'required',
            'storeAddress' =>'required',
            'storeAddress' =>'required',
            'storeZipcode' =>'required',
            'storeEmail' =>'required',
            'storeUseYN' =>'required',
            'note' =>'required',
        ];
        $response = array('response' => '', 'success'=> false);
        $validator = Validator::make($request->all(), $rules); // Form_validation
        if ($validator->fails()) {
            $response['response'] = $validator->messages();
        } else {
            DB::table('MASTER_STORE')->insert([
                'ICE_NUM' => $request->get('iceNum'),
                'STORE_CODE' => $request->get('storeCode'),
                'STORE_NAME' => $request->get('storeName'),
                'WHOLE_CODE' => $request->get('wholeCode'),
                'STORE_PHONE' => $request->get('storePhone'),
                'STORE_CEO' => $request->get('storeCeo'),
                'STORE_BIZ_NUM' => $request->get('storeBizNum'),
                'STORE_BIZ' => $request->get('storeBiz'),
                'STORE_TYPE' => $request->get('storeType'),
                'COMPANY_EMP' => $request->get('companyEmp'),
                'STORE_ADDRESS' => $request->get('storeAddress'),
                'STORE_ZIPCODE' => $request->get('storeZipcode'),
                'STORE_EMAIL' => $request->get('storeEmail'),
                'STORE_USEYN' => $request->get('storeUseYN'),
                'NOTE' => $request->get('note'),
            ]);
            $response['response'] = ["message"=> "업소저장 성공"];
            $response['success'] = true;
        }
        return Response::json($response, 201);
    }
    public function goods(Request $request) { //상품 저장
        $validator = Validator::make($request->all(), [ // Form_validation
            'iceNum' => 'required|numeric|max:10|min:1',
            'goodsCode'  => 'required',
            'goodsName'  => 'required',
            'wholeCode'  => 'required',
            'goodsMaker' => 'required',
            'goodsDiv'   => 'required',
            'goodsNick'  => 'required',
            'goodsVol'   => 'required',
            'goodsType'  => 'required',
            'lastModify' => 'required',
            'purchCost'  => 'required',
            'goodsUseYN' => 'required',
            'note'       => 'required',
        ]);
        $response = ['response' => '', 'success'=> false];
        if ($validator->fails()) {
            $response['response'] = $validator->messages();
        } else {
            DB::table('MASTER_GOODS')->insert([
                'ICE_NUM' => $request->input('iceNum'),
                'GOODS_CODE' => $request->input('goodsCode'),
                'GOODS_NAME' => $request->input('goodsName'),
                'WHOLE_CODE' => $request->input('wholeCode'),
                'GOODS_MAKER' => $request->input('goodsMaker'),
                'GOODS_DIV' => $request->input('goodsDiv'),
                'GOODS_NICK' => $request->input('goodsNick'),
                'GOODS_VOL' => $request->input('goodsVol'),
                'GOODS_TYPE' => $request->input('goodsType'),
                'LAST_MODIFY' => $request->input('lastModify'),
                'PURCH_COST' => $request->input('purchCost'),
                'GOODS_USEYN' => $request->input('goodsUseYN'),
                'NOTE' => $request->note,
            ]);
            $response['response'] = ["message"=> "상품 저장 성공" ];
            $response['success'] = true;
        }
        return Response::json($response, 201);
    }
}
