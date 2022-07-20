<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'description', 'done', 'ends_at'
    ];

    use HasFactory;

    //relationships  

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
