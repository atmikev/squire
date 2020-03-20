<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DamageType
 * @package App
 * @property int $id
 * @property string $name
 * @property string $description
 */
class DamageType extends Model
{

    public function damages()
    {
        return $this->hasMany(Damage::class);
    }

}
