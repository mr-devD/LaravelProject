<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskGroup extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'name',
            'description',
        ];

    public function task()
    {
        $this->belongsTo(Task::class);
    }
}
