<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    /**
     * Badge User
     * @return BelongsTo
     */
    public  function  user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
