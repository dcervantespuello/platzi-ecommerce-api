<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Rating extends MorphPivot
{
    use HasFactory;

    public $incrementing = true;

    protected $table = 'ratings';

    public function rateable(): MorphTo
    {
        return $this->morphTo();
    }

    public function qualifier(): MorphTo
    {
        return $this->morphTo();
    }

    public function approve()
    {
        $this->approved_at = now();
    }
}
