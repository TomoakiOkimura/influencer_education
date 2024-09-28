<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use DB;

class ProfileController extends Controller
{
    public function profile_edit(){
        // $id = Auth::id();
        $id = 1;
        $user = User::find($id);

        return view('user/profile_edit',compact('user'));
    }

    public function password_edit(){
        return view('user/password_edit');
    }

    public function profile_update(UserRequest $request, $id){
        try {
            Log::info('profile_update started');
            $validatedData = $request->validated();
            Log::info('Data validated', ['validatedData' => $validatedData]);
    
            $user = User::find(1);
            if (!$user) {
                Log::warning('User not found', ['id' => $id]);
                return redirect()->back()->with('error', 'ユーザーが見つかりませんでした');
            }
    
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $path = $file->store('profile_images', 'public');
                $validatedData['profile_image'] = $path;
            }
    
            DB::transaction(function () use ($validatedData, $user) {
                if ($user->update($validatedData)) {
                    Log::info('User update successful', ['user' => $user]);
                } else {
                    Log::warning('User update failed', ['user' => $user]);
                }
            });
    
            return redirect()->route('user.profile_edit')
                ->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating user', ['error' => $e->getMessage()]);
    
            return redirect()->back()
                ->with('error', '更新できませんでした');
        }
    }

    public function password_update(Request $request)
    {
        Log::info('Update method called');

        $id = 1;
        $user = User::find($id);

        if ($user) {
            Log::info('User retrieved: ' . $user->id);
        } else {
            Log::error('User not found');
            return redirect('user/password_edit')
            ->with('error', 'ユーザーが見つかりません');
        }

        if (!Hash::check($request->old_password, $user->password)) {
            Log::warning('Old password does not match for user: ' . $user->id);
            return redirect('user/password_edit')
            ->withErrors(['old_password' => '旧パスワードが一致しません']);
        }

        // 新規パスワードの確認
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ],[
            'new_password.confirmed' => '新パスワードが一致しません',
        ]);

        Log::info('New password validated for user: ' . $user->id);

        $user->password = Hash::make($request->new_password);
        $user->save();

        Log::info('Password updated for user: ' . $user->id);

        return redirect('user/profile_edit')
        ->with('status', 'パスワードの変更が終了しました');
    }

    //紀谷が追加したパスワードhash課処理。必要なくなれば決してください。
    public function showPasswordToHash() {
        $user = User::all();
        return view('password_hash', ['users' => $user]);
    }

    public function updatePassWordToHash(Request $request){
        // dd($request);
        $user = User::find($request->input('user_id'));
        $hashPW = Hash::make($request->input('password'));
        try {
            DB::beginTransaction();
            $user->password = $hashPW;
            $user->save();
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            \Log::error($e);
        }


        return redirect(route('show.password.hash'));
    }
}
