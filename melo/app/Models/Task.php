<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// Add this line below to fix the red error:
use App\Models\User; 

class Task extends Model
{
  protected $fillable = [
    'title', 
    'description', 
    'category', 
    'due_date', 
    'priority', 
    'user_id', 
    'is_completed'
];

   public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}