<?php

namespace App\Http\Controllers\Api;

use App\Binary;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class BinaryController extends Controller
{
    public function index()
    {
        $topUser = Auth::user();
        $binaryLeft = Binary::where('up_line', Auth::user()->id)->where('position', 0)->first();
        $binaryRight = Binary::where('up_line', Auth::user()->id)->where('position', 1)->first();
        if ($binaryLeft) {
            $binaryLeft->data = User::find($binaryLeft->user);
            $binaryLeft->left = Binary::where('up_line', $binaryLeft->user)->where('position', 0)->first();
            if ($binaryLeft->left) {
                $binaryLeft->left->data = User::find($binaryLeft->left->user);
            }
            $binaryLeft->right = Binary::where('up_line', $binaryLeft->user)->where('position', 1)->first();
            if ($binaryLeft->right) {
                $binaryLeft->right->data = User::find($binaryLeft->right->user);
            }
        }
        if ($binaryRight) {
            $binaryRight->data = User::find($binaryRight->user);
            $binaryRight->left = Binary::where('up_line', $binaryRight->user)->where('position', 0)->first();
            if ($binaryRight->left) {
                $binaryRight->left->data = User::find($binaryRight->left->user);
            }
            $binaryRight->right = Binary::where('up_line', $binaryRight->user)->where('position', 1)->first();
            if ($binaryRight->right) {
                $binaryRight->right->data = User::find($binaryRight->right->user);
            }
        }

        $data = [
            'topUser' => $topUser,
            'binaryLeft' => $binaryLeft,
            'binaryRight' => $binaryRight,
        ];

        return response()->json($data, 200);
    }
}
