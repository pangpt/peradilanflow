<?php

namespace App\Http\Resources;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'questions_count' => $this->questions_count,
            'can_be' => [
                'updated' => $request->user() && $request->user()->can('update', Tag::class),
                'deleted' => $request->user() && $request->user()->can('delete', $this->resource),
            ]
        ];
    }
}
