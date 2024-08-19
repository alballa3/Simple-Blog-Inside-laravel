<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class comments extends Model
{
    use HasFactory;
    protected $fillable=[
        'text',
        'user_id',
        'blog_id'
    ];
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function blog(): BelongsTo{
        return $this->belongsTo(blog::class);
    }
}
