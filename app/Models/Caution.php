<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Caution extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'number',
        'check_number',
        'status',
        'reception_date',
        'return_date'
    ];

    protected $cast = [
        'status' => 'boolean',
        'reception_date' => 'datetime',
        'return_date' => 'datetime'
    ];

    /**
     * Get the location that owns the Caution
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
