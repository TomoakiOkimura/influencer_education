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
  public function deliveryNewCreate(Request $request, $id)
  {
    // バリデーションルールの定義
    $errors = [];

    foreach ($request->delivery_from_date as $index => $from_date) {
        $from_time = $request->delivery_from_time[$index];
        $to_date = $request->delivery_to_date[$index];
        $to_time = $request->delivery_to_time[$index];

        if ($from_date || $from_time || $to_date || $to_time) {
            if (!$from_date || !$from_time || !$to_date || !$to_time) {
                $errors[] = "配信期間の行 " . ($index + 1) . " の情報を完全に入力してください。";
            } else {
                try {
                    $formattedFromDate = Carbon::createFromFormat('Ymd Hi', $from_date . ' ' . $from_time);
                    $formattedToDate = Carbon::createFromFormat('Ymd Hi', $to_date . ' ' . $to_time);
                    if ($formattedToDate->lt($formattedFromDate)) {
                        $errors[] = "配信期間の行 " . ($index + 1) . " で終了日時は開始日時以降でなければなりません。";
                    }
                } catch (\Exception $e) {
                    $errors[] = "配信期間の行 " . ($index + 1) . " で日付または時間の形式が無効です。";
                }
            }
        }
    }

    if ($errors) {
        return back()->withErrors($errors)->withInput();
    }

      DB::beginTransaction();
      try {
                // 登録後に現在更新登録している学年一覧へ戻るため学年情報の取得
     $grade_id = DB::table('curriculums')->where('id', $id)->value('grade_id');
          $deliveryTimes = [];
          foreach ($request->delivery_from_date as $index => $from_date) {
              $from_time = $request->delivery_from_time[$index] ?? '0000'; // デフォルト時間を設定
              $to_date = $request->delivery_to_date[$index] ?? null;
              $to_time = $request->delivery_to_time[$index] ?? '2359'; // デフォルト時間を設定
  
              if ($from_date && $from_time && $to_date && $to_time) {
                  try {
                      // 日付と時間を適切なフォーマットに変換
                      $formattedFromDate = substr($from_date, 0, 4) . '-' . substr($from_date, 4, 2) . '-' . substr($from_date, 6, 2);
                      $formattedFromTime = substr($from_time, 0, 2) . ':' . substr($from_time, 2, 2);
                      $formattedToDate = substr($to_date, 0, 4) . '-' . substr($to_date, 4, 2) . '-' . substr($to_date, 6, 2);
                      $formattedToTime = substr($to_time, 0, 2) . ':' . substr($to_time, 2, 2);
  
                      $deliveryFrom = Carbon::createFromFormat('Y-m-d H:i', $formattedFromDate . ' ' . $formattedFromTime);
                      $deliveryTo = Carbon::createFromFormat('Y-m-d H:i', $formattedToDate . ' ' . $formattedToTime);
  
                      $deliveryTimes[] = [
                          'curriculums_id' => $id,
                          'delivery_from' => $deliveryFrom,
                          'delivery_to' => $deliveryTo,
                          'created_at' => now(),
                          'updated_at' => now(),
                      ];
                  } catch (\Exception $e) {
                      Log::error("日時フォーマットエラー: " . $e->getMessage());
                      return back()->withErrors(['error' => '日付または時間の形式が正しくありません。']);
                  }
              }
          }
  
          // データベースへの挿入
          if (!empty($deliveryTimes)) {
              DeliveryTime::insert($deliveryTimes);
          }
  
          DB::commit();
      } catch(\Exception $e) {
          DB::rollback();
          Log::error("登録処理エラー: " . $e->getMessage());
          return back()->withErrors(['error' => '登録処理に失敗しました。再度お試しください。']);
      }
  
      return redirect()->route('admin.search.curriculum.list', ['gradeId' => $grade_id]);
  }
  

    // 配信期間設定--更新登録画面表示
    public function showDeliveryUpdate($id){
          $model = new DeliveryTime();
                $curriculum = $model ->searchDeliveryTime($id);
                // $curriculumから$delivery_timesを抽出
                $delivery_times = DB::table('delivery_times')->where('curriculums_id', $id)->get();
                //   dd($curriculum, $delivery_times);
         

        return view('delivery_update',['curriculum'=> $curriculum,'delivery_times'=>$delivery_times]);
    }

//    配信期間更新処理
public function deliveryUpdate(Request $request, $curriculum_id){
// {   １行は入力していないと駄目なバリテーション
     $errors = [];

    foreach ($request->delivery_from_date as $index => $from_date) {
        $from_time = $request->delivery_from_time[$index];
        $to_date = $request->delivery_to_date[$index];
        $to_time = $request->delivery_to_time[$index];

        if ($from_date || $from_time || $to_date || $to_time) {
            if (!$from_date || !$from_time || !$to_date || !$to_time) {
                $errors[] = "配信期間の行 " . ($index + 1) . " の情報を完全に入力してください。";
            } else {
                try {
                    $formattedFromDate = Carbon::createFromFormat('Ymd Hi', $from_date . ' ' . $from_time);
                    $formattedToDate = Carbon::createFromFormat('Ymd Hi', $to_date . ' ' . $to_time);
                    if ($formattedToDate->lt($formattedFromDate)) {
                        $errors[] = "配信期間の行 " . ($index + 1) . " で終了日時は開始日時以降でなければなりません。";
                    }
                } catch (\Exception $e) {
                    $errors[] = "配信期間の行 " . ($index + 1) . " で日付または時間の形式が無効です。";
                }
            }
        }
    }

    if ($errors) {
        return back()->withErrors($errors)->withInput();
    }

    DB::beginTransaction();
    try {
        // 登録後に現在更新登録している学年一覧へ戻るため学年情報の取得
        $grade_id = DB::table('curriculums')->where('id', $curriculum_id)->value('grade_id');
        
        // 既存の配信期間情報を削除
        DeliveryTime::where('curriculums_id', $curriculum_id)->delete();

        // 新しい配信期間情報を挿入
        $deliveryTimes = [];
        foreach ($request->delivery_from_date as $index => $from_date) {
            $from_time = $request->delivery_from_time[$index] ?? '00:00'; // デフォルト時間を設定
            $to_date = $request->delivery_to_date[$index] ?? null;
            $to_time = $request->delivery_to_time[$index] ?? '23:59'; // デフォルト時間を設定

            // デバッグ: 入力データをログに記録
            Log::info("From Date: $from_date, From Time: $from_time, To Date: $to_date, To Time: $to_time");

            // 日付と時間がすべて入力されている場合にのみ処理を行う
            if ($from_date && $from_time && $to_date && $to_time) {
                try {
                     // 日付と時間を適切なフォーマットに変換
                     $formattedFromDate = substr($from_date, 0, 4) . '-' . substr($from_date, 4, 2) . '-' . substr($from_date, 6, 2);
                     $formattedFromTime = substr($from_time, 0, 2) . ':' . substr($from_time, 2, 2);
                     $formattedToDate = substr($to_date, 0, 4) . '-' . substr($to_date, 4, 2) . '-' . substr($to_date, 6, 2);
                     $formattedToTime = substr($to_time, 0, 2) . ':' . substr($to_time, 2, 2);
 
                     $deliveryFrom = Carbon::createFromFormat('Y-m-d H:i', $formattedFromDate . ' ' . $formattedFromTime);
                     $deliveryTo = Carbon::createFromFormat('Y-m-d H:i', $formattedToDate . ' ' . $formattedToTime);
 

                    // フォーマットが成功した場合のみ配列に追加
                    $deliveryTimes[] = [
                        'curriculums_id' => $curriculum_id,
                        'delivery_from' => $deliveryFrom,
                        'delivery_to' => $deliveryTo,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                } catch (\Exception $e) {
                    Log::error("日時フォーマットエラー: " . $e->getMessage());
                    return back()->withErrors(['error' => '日付または時間の形式が正しくありません。']);
                }
            }
        }

        // データベースへの挿入
        if (!empty($deliveryTimes)) {
            DeliveryTime::insert($deliveryTimes);
        }

        DB::commit();
    } catch(\Exception $e) {
        DB::rollback();
        Log::error("登録処理エラー: " . $e->getMessage());
        return back()->withErrors(['error' => '登録処理に失敗しました。再度お試しください。']);
    }

    return redirect()->route('admin.search.curriculum.list', ['gradeId' => $grade_id]);
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