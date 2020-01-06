<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\VocerPoint;
use Auth;

class VocerPointController extends Controller
{
    public function index()
    {
        $vocerPoint = VocerPoint::where('user', Auth::user()->id)->take(100)->get();
        if ($vocerPoint->count()) {
            $vocerPoint->map(function ($item) {
                $item->debit = "Rp " . number_format($item->debit, 0, ',', '.');
                $item->credit = "Rp " . number_format($item->credit, 0, ',', '.');
                return $item;
            });

            $data = [
                'response' => $vocerPoint,
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'The given data was invalid.',
                'errors' => [
                    'vocer' => ["Anda tidak memiliki vocer point"],
                ],
            ];
            return response()->json($data, 422);
        }
    }
}
