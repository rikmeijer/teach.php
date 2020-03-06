<?php
declare(strict_types=1);

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesweek extends Eloquent
{
    protected $table = 'lesweken';
    public $timestamps = false;

    final public function lessen(): HasMany
    {
        return $this->hasMany(Les::class, 'lesweek_id');
    }
}
