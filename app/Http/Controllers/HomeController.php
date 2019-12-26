<?php

namespace App\Http\Controllers;

use App\Binary;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $binaryLeft = Binary::where('sponsor', Auth::user()->id)->where('position', 0)->first();
        $binaryRight = Binary::where('sponsor', Auth::user()->id)->where('position', 1)->first();
        if ($binaryLeft) {
            $binaryLeft->data = User::find($binaryLeft->user);
            $binaryLeft->left = Binary::where('sponsor', $binaryLeft->user)->where('position', 0)->first();
            if ($binaryLeft->left) {
                $binaryLeft->left->data = User::find($binaryLeft->left->user);
            }
            $binaryLeft->right = Binary::where('sponsor', $binaryLeft->user)->where('position', 1)->first();
            if ($binaryLeft->right) {
                $binaryLeft->right->data = User::find($binaryLeft->right->user);
            }
        }
        if ($binaryRight) {
            $binaryRight->data = User::find($binaryRight->user);
            $binaryRight->left = Binary::where('sponsor', $binaryRight->user)->where('position', 0)->first();
            if ($binaryRight->left) {
                $binaryRight->left->data = User::find($binaryRight->left->user);
            }
            $binaryRight->right = Binary::where('sponsor', $binaryRight->user)->where('position', 1)->first();
            if ($binaryRight->right) {
                $binaryRight->right->data = User::find($binaryRight->right->user);
            }
        }

        $data = [
            'binaryLeft' => $binaryLeft,
            'binaryRight' => $binaryRight,
        ];
        return view('home', $data);
    }
}
