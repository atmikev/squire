<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Spell
 * @package App
 * @property string $name
 * @property string $description
 * @property string $higher_level
 * @property string $page
 * @property string $range
 * @property string $duration
 * @property string $casting_time
 * @property integer $level
 */
class Spell extends Model
{

    public function characterClasses()
    {
        return $this->belongsToMany(CharacterClass::class);
    }

    public function magicSchool()
    {
        return $this->belongsTo(MagicSchool::class);
    }

}
