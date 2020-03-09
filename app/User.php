<?php
declare(strict_types=1);

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Sabre\VObject\Component\VCalendar;

/** @mixin Eloquent */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    final public function contactmomentenVandaag(): HasMany
    {
        return $this->hasMany(Contactmoment::class, 'eigenaar_id');
    }

    final public function readVCalendar(): VCalendar
    {
        return new VCalendar();
    }
}
