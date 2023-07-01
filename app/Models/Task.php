<?php

namespace App\Models;

use App\Models\TaskExecutant;
use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
      'title', 'description', 'manager_id', 'deadline', 'priority', 'group_id', 'completed', 'canceled'
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function executants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_executants', 'task_id', 'executant_id');
    }

    public function taskGroup(): BelongsTo
    {
        return $this->belongsTo(TaskGroup::class, 'group_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(TaskAttachment::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function checkIfexecutantComplete($executant_id)
    {
        return TaskExecutant::where('task_id', $this->id)->where('executant_id', $executant_id)->first();

    }
}
