<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionOrderController extends Controller
{
    /**
     * Menangani pembaruan urutan pertanyaan untuk survei tertentu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, Survey $survey)
    {
        // Validasi: Pastikan data yang masuk adalah array dan setiap item adalah ID yang ada
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:questions,id',
        ]);

        // Gunakan transaction untuk memastikan semua pembaruan berhasil atau tidak sama sekali
        DB::transaction(function () use ($validated, $survey) {
            foreach ($validated['order'] as $index => $questionId) {
                // Update hanya pertanyaan yang dimiliki oleh survei ini untuk keamanan
                $survey->questions()
                    ->where('id', $questionId)
                    ->update(['order_column' => $index + 1]);
            }
        });

        // Kirim respons sukses dalam format JSON
        return response()->json(['status' => 'success', 'message' => 'Urutan pertanyaan berhasil diperbarui.']);
    }
}
