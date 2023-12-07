<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class WorkController extends Controller
{
    // 19 접수 저장
    public function receiveSave() {
        print "receiveSave";
    }

    //20 업무코드별 데이터 조회
    public function codeSearch($storeCode) {
        echo $storeCode;
    }
    //21 매출내용 등록
    public function salesSave ($storeCode) {
        die($storeCode);
    }

    //22 해당업무 저장
    public function workSave($storeCode) {
        var_dump($storeCode);
    }
    //23 업소수정 (항목별)
    public function workModify($storeCode, $type=null) {
        echo "업소코드 : ".$storeCode." 저장항목 : ".$type;
    }
}
