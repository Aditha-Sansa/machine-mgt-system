<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MachineHourLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'machine_id',
        'hours_added',
        'is_reset'
    ];

    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }
}
