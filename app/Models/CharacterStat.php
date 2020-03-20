<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CharacterStat
 * @package App
 * @property int $id
 * @property AbilityScore $abilityScore
 */
class CharacterStat extends Model
{

    public function abilityScore()
    {
        return $this->belongsTo(AbilityScore::class);
    }

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

}
