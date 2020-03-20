<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Dice
 * @package App
 * @property int $id
 * @property string $name
 * @property int $min_value
 * @property int $max_value
 */
class Dice extends Model
{
    protected $table = "dice";

    public function roll()
    {
        try {
            return random_int($this->min_value, $this->max_value);
        } catch (Exception $exception) {
            return rand($this->min_value, $this->max_value);
        }

    }

    public function damages()
    {
        return $this->hasMany(Damage::class);
    }

}
