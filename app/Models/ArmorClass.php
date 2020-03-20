<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ArmorClass
 * @package App
 * @property integer $base
 * @property integer $dex_bonus
 * @property integer $max_bonus
 */
class ArmorClass extends Model
{
    protected $fillable = [
        'base',
        'dex_bonus',
        'max_bonus',
    ];

    public function armors() {
        return $this->hasMany(Armor::class);
    }
}
