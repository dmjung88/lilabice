<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\MasterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| 응용 프로그램의 API 경로를 등록할 수 있는 곳입니다
| 루트가 그룹 내에서 RouteServiceProvider에 의해 로드됩니다
| 'API' 미들웨어 그룹으로 지정되었습니다. API 구축을 즐겨보세요!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//CommonController
Route::prefix('common/search')->group(function () {
    Route::post('/wholesale', [CommonController::class, 'wholeSale']);
    Route::post('/wholesaleBizNum', [CommonController::class, 'wholesaleBizNum']);
    Route::get('/store', [CommonController::class, 'store']);
    Route::get('/goods', [CommonController::class, 'goods']);
    Route::get('/maker', [CommonController::class, 'maker']);
    Route::get('/goodsType', [CommonController::class, 'goodsType']);
    Route::post('/assignWholesale', [CommonController::class, 'assignWholesale']);
});

//MasterController
Route::prefix('master')->group(function () {
    Route::post('/wholesale', [MasterController::class, 'wholesale']);
    Route::post('/store', [MasterController::class, 'store']);
    Route::post('/goods', [MasterController::class, 'goods']);
});