<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'category_id',
        'created_by',
        'deleted_by',
        'title',
        'description',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($task) {
            // Set deleted_by sebelum soft delete
            if (auth()->check()) {
                $task->deleted_by = auth()->id();
                $task->save();
            }
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'ILIKE', "%{$search}%")
                    ->orWhere('description', 'ILIKE', "%{$search}%");
    }

    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeDueSoon($query, $days = 7)
    {
        return $query->whereNull('deleted_at')
                    ->where('due_date', '<=', now()->addDays($days))
                    ->where('due_date', '>=', now())
                    ->orderBy('due_date', 'asc');
    }
}
