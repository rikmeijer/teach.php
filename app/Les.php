<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Les extends Model
{
    protected $table = 'lessen';

    final public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_naam', 'naam');
    }

    final public function lesweek(): BelongsTo
    {
        return $this->belongsTo(Lesweek::class);
    }
}
