<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;

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

    public function profile_update(UserRequest $request, User $user){
        try {
            Log::info('profile_update started'); // デバッグログ追加
            $validatedData = $request->validated();
            Log::info('Data validated', ['validatedData' => $validatedData]); // デバッグログ追加
            
            // updateArticleメソッドが存在しない場合は、標準のupdateメソッドを使用
            $user->update($validatedData);
            Log::info('User updated', ['user' => $user]); // デバッグログ追加
            
            return redirect()->route('user.profile_list')
                ->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating user', ['error' => $e->getMessage()]); // デバッグログ追加
            
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
            ->with('warning', 'パスワードが違います');
        }

        // 新規パスワードの確認
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        Log::info('New password validated for user: ' . $user->id);

        $user->password = Hash::make($request->new_password);
        $user->save();

        Log::info('Password updated for user: ' . $user->id);

        return redirect('user/profile_edit')
        ->with('status', 'パスワードの変更が終了しました');
    }
}
