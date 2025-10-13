<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

class QuestionOrderController extends Controller
{
    use AuthorizesRequests; 

    /**
     */
    public function __invoke(Request $request, Survey $survey)
    {
        $this->authorize('update', $survey);

        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:questions,id',
        ]);

        DB::transaction(function () use ($validated, $survey) {
            foreach ($validated['order'] as $index => $questionId) {
                // Update hanya pertanyaan yang dimiliki oleh survei ini untuk keamanan
                $survey->questions()
                    ->where('id', $questionId)
                    ->update(['order_column' => $index + 1]);
            }
        });

        return response()->json(['status' => 'success', 'message' => 'Urutan pertanyaan berhasil diperbarui.']);
    }
}
