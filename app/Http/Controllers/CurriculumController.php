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
         // バリデーションルールの定義
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'required|url',
            'description' => 'required|string',
            'grade_id' => 'required|exists:grades,id',
            'alway_delivery_flg' => 'nullable|boolean',
        ], [
            'title.required' => '授業名を入力してください。',
            'image.image' => '画像ファイルをアップロードしてください。',
            'image.mimes' => 'JPEG, PNG, JPG, GIF形式の画像をアップロードしてください。',
            'image.max' => '画像のサイズは2MB以下にしてください。',
            'video_url.required' => '動画urlを入力してください',
            'video_url.url' => '有効なurlを入力してください',
            'description' => '授業概要を入力してください',
            'grade_id.required' => '学年を選択してください。',
            'grade_id.exists' => '選択された学年は存在しません。',
        ]);

        DB::beginTransaction();
        try{ 
             // 画像ファイルの取得と保存
        $image_path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();
            $image->storeAs('public/images', $file_name);
            $image_path = 'storage/images/' . $file_name;
        }
            $model = new Curriculum();
             $model ->registCurriculum($request,$image_path);
             DB::commit();
             } catch(\Exception $e){
                DB::rollback();
                Log::error("登録処理エラー: " . $e->getMessage());
                return back()->withErrors(['error' => '登録処理に失敗しました。再度お試しください。']);
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

               // バリデーションルールの定義
                $request->validate([
                    'title' => 'required|string|max:255',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'video_url' => 'required|url',
                    'description' => 'required|string',
                    'grade_id' => 'required|exists:grades,id',
                    'alway_delivery_flg' => 'nullable|boolean',
                ], [
                    'title.required' => '授業名を入力してください。',
                    'image.image' => '画像ファイルをアップロードしてください。',
                    'image.mimes' => 'JPEG, PNG, JPG, GIF形式の画像をアップロードしてください。',
                    'image.max' => '画像のサイズは2MB以下にしてください。',
                    'video_url.required' => '動画urlを入力してください',
                    'video_url.url' => '有効なurlを入力してください',
                    'description' => '授業概要を入力してください',
                    'grade_id.required' => '学年を選択してください。',
                    'grade_id.exists' => '選択された学年は存在しません。',
                ]);
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
              // 登録後に現在更新登録している学年一覧へ戻るため学年情報の取得
            $grade_id = DB::table('curriculums')->where('id', $id)->value('grade_id');    
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
     return redirect()->route('admin.search.curriculum.list', ['gradeId' => $grade_id]);
    }

  
}