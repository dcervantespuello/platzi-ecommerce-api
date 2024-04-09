<?php

namespace App\Exceptions;

use Exception;

class InvalidScore extends Exception
{
    private $from;
    private $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function render() {
        return response()->json([
            __('rating.invalidScore', [
                'from' => $this->from,
                'to' => $this->to,
            ])
        ]);
    }
}
