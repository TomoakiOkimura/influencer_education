<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\Request;
use App\Models\DeliveryTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class DeliveryController extends Controller
{
    //配信期間--新規登録画面表示
    public function showDeliveryNewCreate($id){
            $model = new DeliveryTime();
            $curriculum = $model -> showDeliveryNewCreate($id); 
            return view('delivery_new_create',['curriculum' => $curriculum]);
        }

     // 配信期間新規登録処理idにはカリキュラムのidが入っている
    public function deliveryNewCreate(Request $request,$id){
                // dd($request->all());
                DB::beginTransaction();
             try{ 
                    $model = new DeliveryTime();
                    $model ->registDelivery($request,$id);
                    DB::commit();
                    } catch(\Exception $e){
                        DB::rollBack();
                                    // memoエラーメッセージをログに記録
                                    // Log::error('Delivery registration failed: ' . $e->getMessage());
                                    // return response()->json(['message' => '登録に失敗しました。'], 500);
                    }
            return redirect(route('admin.show.curriculum.list'))->with('新規登録完了');
            }

    // 配信期間設定--更新登録画面表示
    public function showDeliveryUpdate($id){
        DB::beginTransaction();
        try{
                $model = new DeliveryTime();
                $curriculum = $model ->searchDeliveryTime($id);
                // $curriculumから$delivery_timesを抽出
                $delivery_times = DB::table('delivery_times')->where('curriculums_id', $id)->get();
                //   dd($curriculum, $delivery_times);DB::commit();
            } catch(\Exception $e){
                DB::rollBack();}

        return view('delivery_update',['curriculum'=> $curriculum,'delivery_times'=>$delivery_times]);
    }

    // 配信期間設定--更新登録処理
    public function deliveryUpdate(Request $request,$id){
        DB::beginTransaction();
        try{
          // 既存の配信期間情報を削除
            DeliveryTime::deleteByCurriculumId($id);
            // 新しい配信期間情報を挿入
            $deliveryTimes = [];
            foreach ($request->delivery_from_date as $index => $from_date) {
            $deliveryTimes[] = [
                'from_date' => $from_date,
                'from_time' => $request->delivery_from_time[$index],
                'to_date' => $request->delivery_to_date[$index],
                'to_time' => $request->delivery_to_time[$index],
            ];
        }
        DeliveryTime::insertDeliveryTimes($id, $deliveryTimes);
    } catch(\Exception $e){
        DB::rollBack();}

        return redirect()->route('admin.show.curriculum.list')->with('status', '配信期間が更新されました');
    }
    // 削除ボタン押下後データがあった際の削除処理
    public function destroy($id)
    {
        $deliveryTime = DeliveryTime::find($id);
        if ($deliveryTime) {
            $deliveryTime->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }


}