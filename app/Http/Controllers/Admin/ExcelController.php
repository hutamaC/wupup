<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller as Controller;
// use App\Model\Member\MemberFollow;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Goods;
use App\Models\Field;
use Excel;

class ExcelController extends Controller
{

    protected $importArr;
    protected $diffs;

    public function __construct(){

    }

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
        // $CERT_id = Field::where('field_name','CERT')->first()->id;
        // dd($CERT_id);
            $filePath = 'storage/exports/new.xls';
            Excel::load($filePath, function($reader) {
            $data = $reader->all()->toArray();

            $excel_goods_name = array_column($data[0],'goods_name');
            
            $goods_name = Goods::pluck('goods_name')->toArray();

            $this->diffs=array_diff($excel_goods_name,$goods_name);//取差集
            
            $this->importArr = $data[0];
            $re = $this->insertArr();
            // dd($re);
            $this->insert($re);
        });
    }


    public function insertArr(){


        $Arr = [
            'cat_id' => '50',
            'brand_id'=>'7',
            'goods_number'=>'1',
        ];

        //dd($insertArr);

        array_walk($this->importArr, function (&$value, $key, $Arr) {
                            if(!in_array($value['goods_name'],$this->diffs)){
                                unset($this->importArr[$key]);
                                return;
                            }
                            $value = array_merge($value, $Arr);
                        }, $Arr);

        return $this->importArr;

    }


    public function insert($arr){
        //dd($arr);

        $CERT_id = Field::where('field_name','CERT')->first()->id;

        $Shape_id = Field::where('field_name','形状')->first()->id;

        $Color_id = Field::where('field_name','颜色')->first()->id;

        $Clarity_id = Field::where('field_name','透明度')->first()->id;

        $Cut_id = Field::where('field_name','CUT')->first()->id;

        $Pol_id = Field::where('field_name','POL')->first()->id;


        $Sym_id = Field::where('field_name','SYM')->first()->id;


        $Fluor_id = Field::where('field_name','FLURO')->first()->id;



        foreach($arr as $k=>$v){
            if($model = Goods::create($v)){
                $field = [];
                $field[]=['goods_id'=>$model->id,'field_id'=>$CERT_id,'field_value'=>$v['cert']];
                $field[]=['goods_id'=>$model->id,'field_id'=>$Shape_id,'field_value'=>$v['shape']];
                $field[]=['goods_id'=>$model->id,'field_id'=>$Color_id,'field_value'=>$v['color']];
                $field[]=['goods_id'=>$model->id,'field_id'=>$Clarity_id,'field_value'=>$v['clarity']];
                $field[]=['goods_id'=>$model->id,'field_id'=>$Cut_id,'field_value'=>$v['cut']];
                $field[]=['goods_id'=>$model->id,'field_id'=>$Pol_id,'field_value'=>$v['pol']];
                $field[]=['goods_id'=>$model->id,'field_id'=>$Sym_id,'field_value'=>$v['sym']];
                $field[]=['goods_id'=>$model->id,'field_id'=>$Fluor_id,'field_value'=>$v['fluor']];
                // dd($field);
                $model->field()->insert($field);

            }
       }

       return true;
    }

}
