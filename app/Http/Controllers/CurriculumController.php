<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\DeliveryTime;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CurriculumController extends Controller
{
    // 一覧画面表示
    public function showCurriculumList(){
        $model= new Curriculum();
        $curriculums = $model -> getCurriculumList();
        $delivery_times = DeliveryTime::all();
        // dd($delivery_time);
        $grademodel= new Grade();
        $grades = $grademodel-> getGradeFirst();
        // 授業一覧画面学年リストで色を変える処理
        $grades = Grade::all();
        // 表示中の学年名の取得
        $currentGradeName = 
        DB::table('grades')->where('id',1)->value('name');
       
        return view('curriculum_list',['curriculums'=>$curriculums,'grades'=>$grades, 'delivery_times'=>$delivery_times,'currentGradeName'=>$currentGradeName]);
    }
    // 学年別授業表示--非同期処理
    public function getCurriculum($gradeId)
    {  
        $grades = Grade::all();
        $model= new Curriculum();
        $curriculums = $model -> searchCurriculums($gradeId);
        $delivery_times = DeliveryTime::all();
        // 表示中の学年名の取得
        $currentGradeName = 
        DB::table('grades')->where('id',$gradeId)->value('name');
        Log::info($currentGradeName);

        return view('curriculum_list', ['curriculums' => $curriculums,'grades'=>$grades, 'delivery_times'=>$delivery_times, 'currentGradeName'=>$currentGradeName])->render();
    }
  
    // 授業登録画面表示
    public function showCurriculumCreate(){
        $grademodel= new Grade();
        $grades = $grademodel-> showGrade();
        return view('curriculum_create',['grades'=>$grades]);
    }
    
      // 授業新規登録処理
    public function curriculumCreate(Request $request){
        DB::beginTransaction();
                    //①画像ファイルの取得
                    $image = $request->file('image');
                    
                    //②画像ファイルのファイル名を取得
                    $file_name = $image->getClientOriginalName();
                    
                    //③storage/app/public/imagesフォルダ内に、取得したファイル名で保存
                    $image->storeAs('public/images', $file_name);
                    
                    //④データベース登録用に、ファイルパスを作成
                    $image_path = 'storage/images/' . $file_name;

                  
        try{ 
            $model = new Curriculum();
             $model ->registCurriculum($request,$image_path);
             DB::commit();
             } catch(\Exception $e){

             DB::rollback();
            return back();
            }
                 // 処理が完了したらcurriculum_listの画面ににリダイレクト
                    return redirect()->route('admin.show.curriculum.list');
    }

    

    // 授業更新登録画面表示
    public function showCurriculumEdit($id){
        DB::beginTransaction();
        try{ 
        $model = new Curriculum();
        $curriculum = $model -> getDetailCurriculum($id);
        // dd($curriculum);
        $grades=Grade::all(); 
        $flg = $model ->getFlg($id);
        DB::commit();
    } catch(\Exception $e){
        
        DB::rollback();
        return back();
        }

        return view('curriculum_edit',['curriculum'=> $curriculum, 'grades'  =>$grades,'flg'=> $flg]);
    }
    // 授業更新登録処理
    public function curriculumEdit(Request $request, $id){
        // 画像ファイルの取得
    $image = $request->file('image');
    $image_path = null;

    if ($image) {
        // 画像ファイルのファイル名を取得
        $file_name = time() . '_' . $image->getClientOriginalName();

        // 画像ファイルの保存
        $image->storeAs('public/images', $file_name);

        // データベース登録用にファイルパスを作成
        $image_path = 'storage/images/' . $file_name;
    }

        DB::beginTransaction();
        try{
            
            $model = new Curriculum();
             $model ->updateCurriculum($request,$id,$image_path);
             DB::commit();
             } catch(\Exception $e){
                                    // memoエラーメッセージをログに記録
                                    Log::error('Delivery registration failed: ' . $e->getMessage());
                                    return response()->json(['message' => '登録に失敗しました。'], 500);
             DB::rollback();
            return back();
            }
     // 処理が完了したらcurriculum_listの画面ににリダイレクト
     return redirect()->route('admin.show.curriculum.list');
    }

  
}