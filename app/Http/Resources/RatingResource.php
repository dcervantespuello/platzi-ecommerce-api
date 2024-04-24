<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'score' => $this->score,
            'comments' => $this->comments,
            'rateable' => $this->rateable,
            'qualifier' => $this->qualifier,
            'createdAt' => $this->created_at,
            'approved_at' => $this->approved_at
        ];
    }
}
