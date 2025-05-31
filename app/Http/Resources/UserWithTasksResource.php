<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWithTasksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'role' => $this->role->code,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'username' => $this->username,
            'pending_tasks_count' => $this->pending_tasks_count,
            'in_progress_tasks_count' => $this->in_progress_tasks_count,
            'completed_tasks_count' => $this->completed_tasks_count,
            'tasks' => new ArrayTaskResource($this->tasks)
        ];
    }
}
