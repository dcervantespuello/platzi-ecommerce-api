<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;

class QualificationController extends Controller
{
    public function rateUser($id)
    {
        $qualifier = User::inRandomOrder()->first();
        $rateable = User::find($id);

        $qualifier->rate($rateable, random_int(1, 5));

        return response()->json([
            'data' => "El usuario $qualifier->name calificó al usuario $rateable->name."
        ]);
    }

    public function rateProduct($id)
    {
        $qualifier = User::inRandomOrder()->first();
        $rateable = Product::find($id);

        $qualifier->rate($rateable, random_int(1, 5));

        return response()->json([
            'data' => "El usuario $qualifier->name calificó el producto $rateable->name."
        ]);
    }
}
