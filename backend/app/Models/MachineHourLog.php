<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MachineHourLog extends Model
{
    use HasFactory;
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
