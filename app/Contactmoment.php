<?php
declare(strict_types=1);

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contactmoment extends Eloquent
{
    protected $table = 'contactmomenten';
    protected $dates = [
        'starttijd',
        'eindtijd'
    ];


    final public function les(): BelongsTo
    {
        return $this->belongsTo(Les::class);
    }

    final public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
