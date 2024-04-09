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

        // $qualifier->rate($rateable, random_int(1, 5));
        $qualifier->rate($rateable, 9);

        return response()->json([
            'data' => "El usuario $qualifier->name calificó el producto $rateable->name."
        ]);
    }

    public function unrateProduct($id)
    {
        $qualifier = User::inRandomOrder()->first();
        $rateable = Product::find($id);

        $success = "El usuario {$qualifier->name} retiró su calificación sobre el producto {$rateable->name}.";
        $failure = "El usuario {$qualifier->name} no ha calificado el producto {$rateable->name}.";

        $message = $qualifier->unrate($rateable) ? $success : $failure;

        return response()->json([
            'data' => $message
        ]);
    }
}
