<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Relations\MorphOne;
// use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Utils\CanBeRated;
use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    use HasFactory, CanBeRated;

    protected $guarded = [];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // public function rating(): MorphOne
    // {
    //     return $this->morphOne(Rating::class, 'rateable');
    // }

    // public function ratings(): MorphMany
    // {
    //     return $this->morphMany(Rating::class, 'rateable');
    // }

    // protected static function booted()
    // {
    //     static::creating(function(Product $product) {
    //         $faker = \Faker\Factory()->create();
    //         $product->image_url = $faker->imageUrl();
    //         $product->user()->associate(auth()->user());
    //     });
    // }
}
