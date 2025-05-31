<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArrayTaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tasks = [];

        for ($i = 0; $i < count($this->resource); $i++) {
            array_push($tasks, [
                'id' => $this->resource[$i]->id,
                'title' => $this->resource[$i]->title,
                'description' => $this->resource[$i]->description,
                'status' => $this->resource[$i]->status,
                'priority' => $this->resource[$i]->priority,
                'order' => $this->resource[$i]->order,
                'created_at' => $this->resource[$i]->created_at,
                'updated_at' => $this->resource[$i]->updated_at,
            ]);
        }

        return $tasks;
    }
}
