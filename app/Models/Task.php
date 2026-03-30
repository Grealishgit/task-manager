<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'due_date',
        'priority',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    /**
     * Status transition map — each status can only move forward one step
     */
    public static array $statusFlow = [
        'pending'     => 'in_progress',
        'in_progress' => 'done',
    ];

    /**
     * Returns the next allowed status, or null if already at 'done'
     */
    public function nextStatus(): ?string
    {
        return self::$statusFlow[$this->status] ?? null;
    }
}
