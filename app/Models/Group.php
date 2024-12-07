<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'specialization_id',
        'group_year'
    ];

    /**
     * Получить специальность, к которой относится эта группа.
     */
    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }
}
