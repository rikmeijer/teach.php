<?php
declare(strict_types=1);

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Les extends Eloquent
{
    protected $table = 'lessen';

    protected $fillable = [
        'lesweek_id',
        'module_naam'
    ];

    final public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_naam', 'naam');
    }

    final public function lesweek(): BelongsTo
    {
        return $this->belongsTo(Lesweek::class);
    }
}
