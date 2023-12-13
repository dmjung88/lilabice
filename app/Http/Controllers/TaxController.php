<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UserExport;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailer;
use DB;
use PDF;
use Excel;


class TaxController extends Controller
{
    public function taxExcelSearch($wholesaleCode) {
        DB::table('users')->paginate(10);
        // {{ $변수s->links() }}
        return response()->json($wholesaleCode,200);
    }

    /** 엑셀 다운로드 
    * https://www.youtube.com/watch?v=CoQa_Iaa320
    * https://stackoverflow.com/questions/75285913/badmethodcallexception-method-illuminate-foundation-applicationshare-does-not
    */
    public function exportToExcel() {
        return Excel::download(new UserExport, 'user-excel.xls');
    }

    /* PDF 다운로드
    * https://www.youtube.com/watch?v=baUslJ_OnnY
    * https://github.com/barryvdh/laravel-dompdf
    */
    public function exportPdf () {
        $data = ['data1' => '데이타1','data2' => '데이타2'] ;
        $pdf = PDF::loadview('welcome',compact('data'));
        return $pdf->download('home.pdf');   
        //return view('welcome',compact('data'));
    }

    public function eMailSend() {
        Mail::to('wjdehans3@naver.com')->send(new Mailer('marine'));
        return view('welcome');
    }
}
