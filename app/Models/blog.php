<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\comments;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class blog extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'description', 'content','thunmail'];
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function comments():HasMany{
        return $this->hasMany(comments::class);
    }
}
