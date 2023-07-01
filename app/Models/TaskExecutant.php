<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskExecutant extends Model
{
    protected $fillable = [
      'task_id',
      'executant_id',
      'completed'
    ];
}
