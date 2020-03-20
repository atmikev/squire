<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MagicSchool
 * @package App
 * @property $name
 */
class MagicSchool extends Model
{

    public function spells()
    {
        return $this->hasMany(Spell::class);
    }

}
