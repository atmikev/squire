<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CharacterClass
 * @package App
 * @property string $name
 */
class CharacterClass extends Model
{

    public function spells()
    {
        return $this->belongsToMany(Spell::class);
    }

}
