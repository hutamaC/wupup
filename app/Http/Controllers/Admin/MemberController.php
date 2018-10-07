<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller as Controller;
// use App\Model\Member\MemberFollow;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Excel;

class ExcelController extends Controller
{
    /**
     *
     * Excel导出
     */
    // public function export()
    // {
    //     ini_set('memory_limit','500M');
    //     set_time_limit(0);//设置超时限制为0分钟
    //     $cellData = MemberFollow::select('xt_name','sex','face')->limit(5)->get()->toArray();
    //     $cellData[0] = array('昵称','性别','头像');
    //     for($i=0;$i<count($cellData);$i++){
    //         $cellData[$i] = array_values($cellData[$i]);
    //         $cellData[$i][0] = str_replace('=',' '.'=',$cellData[$i][0]);
    //     }
    //     //dd($cellData);
    //     Excel::create('用户信息',function($excel) use ($cellData){
    //         $excel->sheet('score', function($sheet) use ($cellData){
    //             $sheet->rows($cellData);
    //         });
    //     })->export('xls');
    //     die;
    // }
	/**
     *
     * Excel导入
     */
    public function import(){
            $filePath = 'storage/exports/111.xls';
        Excel::load($filePath, function($reader) {
            $data = $reader->all();
            dd($data);
        });
    }
}
