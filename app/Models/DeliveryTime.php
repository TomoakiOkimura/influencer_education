<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class DeliveryTime extends Model
{
   use HasFactory;
   protected $fillable = ['curriculums_id', 'delivery_from', 'delivery_to'];
   
 // リレーションcurriculumが1でdeliveryTimeが多。外部キーを持つほうが多
   public function curriculum()
   {
       return $this->belongsTo(Curriculum::class,'curriculum_id');
   }
    
    // 配信期間新規登録画面に--curriculum.idが選択したものと一致するデータを返すための処理
    public function showDeliveryNewCreate($id){
        $curriculum = DB::table('curriculums')->where('id',$id)->first();
         return $curriculum;
    }

    // 配信期間新規登録処理--inputタグ2つ年月日と時間それを1つのカラムに登録 かつ複数の配信日を入力された場合配列にしてforeachで回す
    public function registDelivery($request, $id){
        // foreachで回しデータを取得からのcarbonでデータベース挿入用にフォーマット形成
        foreach ($request->input('delivery_from_date') as $key => $formDate) {
            $deliveryFromDate = $request->input('delivery_from_date')[$key];
            $deliveryFromTime = $request->input('delivery_from_time')[$key];
            $deliveryToDate = $request->input('delivery_to_date')[$key];
            $deliveryToTime = $request->input('delivery_to_time')[$key];
    
            $deliveryFrom = $deliveryFromDate && $deliveryFromTime ? Carbon::createFromFormat('Y-m-d H:i', $deliveryFromDate . ' ' . $deliveryFromTime) : null;
            $deliveryTo = $deliveryToDate && $deliveryToTime ? Carbon::createFromFormat('Y-m-d H:i', $deliveryToDate . ' ' . $deliveryToTime) : null;
                                //memo デバッグ1 ddでデータを表示
                                // dd([
                                //     'deliveryFromDate' => $deliveryFromDate,
                                //     'deliveryFromTime' => $deliveryFromTime,
                                //     'deliveryToDate' => $deliveryToDate,
                                //     'deliveryToTime' => $deliveryToTime,
                                //     'deliveryFrom' => $deliveryFrom,
                                //     'deliveryTo' => $deliveryTo ]);
                                // memo デバック2 logでデータベース挿入前にデータを確認する
                                // Log::info('Inserting delivery time', [
                                //     'curriculums_id' => $id,
                                //     'delivery_from' => $deliveryFrom,
                                //     'delivery_to' => $deliveryTo
                                // ]);
            DB::table('delivery_times')->insert([
                'curriculums_id' => $id,
                'delivery_from' => $deliveryFrom,
                'delivery_to' => $deliveryTo,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

     // 配信期間更新登録画面に--表示時既存のDBのデータを引っ張ってくる処理
    public function searchDeliveryTime($id){
    $curriculum = DB::table('curriculums')
    ->leftJoin('delivery_times','curriculums.id','=','delivery_times.curriculums_id')
    ->select('delivery_times.*','curriculums.*')
    ->where('curriculums.id','=',$id)
    ->first();
    return $curriculum;
    }
 
  // 配信期間更新登録処理① -------カリキュラムIDに関連する配信期間を削除
  public static function deleteByCurriculumId($id)
  {
      DB::table('delivery_times')
          ->where('curriculums_id', $id)
          ->delete();
  }

  //配信期間更新登録処理② ------- 新しい配信期間を挿入
  public static function insertDeliveryTimes($curriculumId, $deliveryTimes)
  {
     
    foreach ($deliveryTimes as $time) {
        // デバッグ1入力データの確認
        // dd($time['from_date'], $time['from_time'], $time['to_date'], $time['to_time']);

        // delivery_fromのinputタグへの入力値が年月日、時間ともに入力があればCarbonでフォーマットして変数に代入、なければnullをかえす
        if (!empty($time['from_date']) && !empty($time['from_time'])) {
            $deliveryFrom = Carbon::createFromFormat('Y-m-d H:i', $time['from_date'] . ' ' . $time['from_time']);
        } else {
            $deliveryFrom = null;
        }
        // delivery_toのinputタグへの入力値が年月日、時間ともに入力があればCarbonでフォーマットして変数に代入、なければnullをかえす
        if (!empty($time['to_date']) && !empty($time['to_time'])) {
            $deliveryTo = Carbon::createFromFormat('Y-m-d H:i', $time['to_date'] . ' ' . $time['to_time']);
        } else {
            // デフォルトの処理、またはエラーハンドリング
            $deliveryTo = null;
        }
        // 上記のCarbonでフォーマットしたあとに代入した変数$deliveryFromと$deliveryToと最初に渡した変数curriculumIdをインサートで登録処理
        if ($deliveryFrom && $deliveryTo) {
            DB::table('delivery_times')->insert([
                'curriculums_id' => $curriculumId,
                'delivery_from' => $deliveryFrom,
                'delivery_to' => $deliveryTo,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
  }}

}

    






