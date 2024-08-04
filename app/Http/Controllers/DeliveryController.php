<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Models\CurriculumProgress;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function show($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $user = Auth::user();
        $progress = CurriculumProgress::where('user_id', $user->id)->where('curriculum_id', $id)->first();

        return view('layout.delivery', compact('curriculum', 'progress'));
    }

    public function complete(Request $request, $id)
    {
        $user = Auth::user();
        $progress = CurriculumProgress::updateOrCreate(
            ['user_id' => $user->id, 'curriculum_id' => $id],
            ['clear_flag' => 1]
        );

        return response()->json(['message' => '受講済みとしてマークされました。']);
    }
}
