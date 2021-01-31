<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TodoTask
 * @package App\Models
 */
class TodoTask extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'label', 'is_complete'
    ];

    /**
     * @return BelongsTo
     */
    public function todo(): BelongsTo
    {
        $this->belongsTo(Todo::class);
    }
}
