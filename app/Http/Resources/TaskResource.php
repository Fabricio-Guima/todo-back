<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'todo_id' => $this->todo_id,
            'done' => $this->done,
            'description' => $this->description,
            'ends_at' => $this->ends_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'todo' => $this->todo

        ];
    }
}
