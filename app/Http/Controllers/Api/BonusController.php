<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Bonus;
use Auth;

class BonusController extends Controller
{
    public function index()
    {
        $vocerPoint = Bonus::where('user', Auth::user()->id)->take(100)->get();
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
                'response' => "Anda tidak memiliki vocer point",
            ];
            return response()->json($data, 422);
        }
    }
}
