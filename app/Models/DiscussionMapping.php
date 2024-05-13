<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscussionMapping extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'mappings' => AsArrayObject::class,
        ];
    }

    /**
     * Gets the user that owns the discussion mapping.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
