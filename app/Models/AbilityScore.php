<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AbilityScore
 * @package App
 * @property int $strength
 * @property int $dexterity
 * @property int $constitution
 * @property int $intelligence
 * @property int $wisdom
 * @property int $charisma
 */
class AbilityScore extends Model
{
    public function characterStat()
    {
        return $this->belongsTo(CharacterStat::class);
    }
}
