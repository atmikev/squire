<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Damage
 * @package App
 * @property Dice $dice
 * @property int $dice_count
 * @property DamageType $damageType
 */
class Damage extends Model
{

    public function dice()
    {
        return $this->belongsTo(Dice::class);
    }

    public function damageType()
    {
        return $this->belongsTo(DamageType::class);
    }

    public function description()
    {
        return $this->dice_count . '' . $this->dice->name . ' ' . $this->damageType->name;
    }

}
