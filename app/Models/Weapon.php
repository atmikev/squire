<?php

namespace App;

use App\Interfaces\ItemDescriptionInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Weapon
 * @package App
 * @property int $id
 * @property Damage $damage
 * @property string $name
 * @property float $weight
 * @property EquipmentCategory $equipmentCategory
 * @property EquipmentSubcategory $equipmentSubcategory
 */
class Weapon extends Model implements ItemDescriptionInterface
{

    public function damage()
    {
        return $this->belongsTo(Damage::class);
    }

    public function rollDamage()
    {
        return $this->damage->dice->roll();
    }

    public function equipmentItems()
    {
        return $this->morphMany('App\EquipmentItem', 'item');
    }

    public static function itemHeaders(): Collection
    {
        return collect([
          'Name',
          'Weight',
          'Damage',
        ]);
    }

    public function itemDescription(): Collection
    {
        return collect([
            $this->name,
            $this->weight,
            $this->damage->description(),
        ]);
    }
}
