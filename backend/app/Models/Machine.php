<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'purchase_date',
        'purchase_price',
        'category',
        'brand'
    ];


    public function hourLogs(): HasMany
    {
        return $this->hasMany(MachineHourLog::class)->latest('id');
    }

    // This is to get the total hours from the last reset time
    public function getTotalHoursAttribute(): float
    {
        $lastResetId = $this->hourLogs()->where('is_reset', true)->max('id');

        return $this->hourLogs()
            ->when($lastResetId, function ($query) use ($lastResetId) {
                $query->where('id', '>', $lastResetId);
            })->sum('hours_added');
    }
}
