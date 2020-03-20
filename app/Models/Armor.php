<?php

namespace App;

use App\Interfaces\ItemDescriptionInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Armor
 * @package App
 * @property integer $id
 * @property string $name
 * @property integer $str_minimum
 * @property boolean $stealth_disadvantage
 * @property float $weight
 * @property EquipmentCategory $equipmentCategory
 * @property EquipmentSubcategory $equipmentSubcategory

 */
class Armor extends Model implements ItemDescriptionInterface
{
    protected $fillable = [
        'name',
        'str_minimum',
        'stealth_disadvantage',
        'weight',

    ];

    public function armorClass() {
        return $this->belongsTo(ArmorClass::class);
    }

    public function equipmentCategory() {
        return $this->belongsTo(EquipmentCategory::class);
    }

    public function equipmentSubcategory() {
        return $this->belongsTo(EquipmentSubcategory::class);
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
          'Strength Minimum',
          'Stealth Disadvantage',
        ]);

    }

    public function itemDescription(): Collection
    {
        return collect([
          $this->name,
          $this->weight,
          $this->str_minimum,
          $this->stealth_disadvantage
        ]);
    }
}
