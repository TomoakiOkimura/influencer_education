<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Curriculum extends Model
{
    // リレーションcurriculumが1でdeliveryTimeが多。外部キーを持つほうが多
    public function deliveryTimes()
{
    return $this->hasMany(DeliveryTime::class);
}

    use HasFactory;
    protected $fillable =[
        'title',
        'thumbnail',
        'description',
        'video_url',
        'alway_delivery_flg',
        'grade_id',
    ];
    
    protected $table = "curriculums";


// // 授業一覧画面表示 始めは小１の授業を表示
public function getCurriculumList(){
    $curriculums = DB::table('curriculums')
    ->join('grades','curriculums.grade_id','=','grades.id')
    // 普通のジョインだと配信期間が設定されてない場合に表示されなかったのでleftJoinにしてみた
    ->leftJoin('delivery_times','curriculums.id','=','delivery_times.curriculums_id')
    ->select('curriculums.*','grades.name','delivery_times.delivery_from','delivery_times.delivery_to','delivery_times.id as delivery_time_id')
    ->where('grade_id','=','1')
    ->get()
    ->groupBy('id');
    return $curriculums;
}

// // 配信期間を複数取得する
// public function getDelivery(){
//     $delivery_time = DB::table('delivery_times')
//         ->join('delivery_times', 'curriculums.id', '=', 'delivery_times.curriculums_id')
//         ->select('curriculums.*', 'delivery_times.delivery_from', 'delivery_times.delivery_to')
//         ->get()
//         ->groupBy('curriculums_id'); // カリキュラムごとに配信期間をグループ化

//         return $delivery_time ;
//     //   $delivery_times = DB::table('curriculums')
    
    // // 普通のジョインだと配信期間が設定されてない場合に表示されなかったのでleftJoinにしてみた
    // ->leftJoin('delivery_times','curriculums.id','=','delivery_times.curriculums_id')
    // ->select('curriculums.*','grades.name','delivery_times.delivery_from','delivery_times.delivery_to','delivery_times.id as delivery_time_id')
    // ->where('','=','1')
    // ->get();


    // return $delivery_times ;


 // 学年別授業表示--非同期処理
public function searchCurriculums($gradeId){
    
    $curriculums = DB::table('curriculums')
    ->join('grades','curriculums.grade_id','=','grades.id')
     // 普通のジョインだと配信期間が設定されてない場合に表示されなかったのでleftJoinにしてみた
    ->leftJoin('delivery_times','curriculums.id','=','delivery_times.curriculums_id')
    ->select('curriculums.*','grades.name','delivery_times.delivery_from','delivery_times.delivery_to')
    ->where('grade_id','=',$gradeId)
    ->get()
    ->groupBy('id');
        return $curriculums; 
}


// 授業内容登録機能
public function registCurriculum($request,$image_path) {
        // dd($request);
    //productテーブルに新規登録insertが新規登録のための命令文・更新の際はupdate.
     //'カラム名'　=>登録する値　$data（入力された値）->viewのinputタグname属性
        DB::table('curriculums')->insert([
            'title' => $request->title,
            'thumbnail' => $image_path,
            'video_url' =>$request -> video_url,
            'description' => $request->description,
            'alway_delivery_flg' => $request->alway_delivery_flg,
            'grade_id' => $request->grade_id,
           
        ]);
    }
    // 授業内容更新登録画面表示--idと紐づけしてPlaceholderでデータ表示
    public function getDetailCurriculum($id){
         $curriculum =DB::table('curriculums')
        ->join('grades','curriculums.grade_id','=','grades.id')
        ->select('curriculums.*','grades.name')
        ->where('curriculums.id','=',$id)
        ->first();
        return $curriculum;

    }

 // 授業内容更新登録画面表示--idと紐づけして 常時公開になってたらチェックが入って状態にする
    public function getFlg($id){
        $flg =DB::table('curriculums')
        ->select('curriculums.alway_delivery_flg')
        ->where('curriculums.id','=',$id)
        ->first();
        return $flg;

    }
    // 授業内容更新--登録処理
    public function updateCurriculum($request,$id,$image_path){

  // 更新するデータを連想配列にまとめる
  $data = [
    'title' => $request->title,
    'video_url' => $request->video_url,
    'description' => $request->description,
    'alway_delivery_flg' => $request->alway_delivery_flg,
    'grade_id' => $request->grade_id,
];

// 画像がアップロードされた場合のみ`thumbnail`を更新
if ($image_path) {
    $data['thumbnail'] = $image_path;
}

// データベースの更新
DB::table('curriculums')->where('id', $id)->update($data);


        // DB::table('curriculums')->where('id', $id)->update([
        // 'title' => $request->title,
        // 'thumbnail' => $image_path,
        // 'videl_url' =>$request -> video_url,
        // 'description' => $request->description,
        // 'alway_delivery_flg' => $request->alway_delivery_flg,
        // 'grade_id' => $request->grade_id,
        // ]);
        }


    }




