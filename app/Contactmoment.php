<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contactmoment extends Model
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
}
