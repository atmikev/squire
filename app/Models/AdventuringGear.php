<?php

namespace App;

use App\Interfaces\ItemDescriptionInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class AdventuringGear
 * @package App
 * @property integer $id
 * @property string $name
 * @property EquipmentCategory $equipmentCategory
 * @property EquipmentSubcategory $equipmentSubcategory
 * @property float $weight
 * @property string $description
 */
class AdventuringGear extends Model implements ItemDescriptionInterface
{

    public function equipmentCategory()
    {
        return $this->belongsTo(EquipmentCategory::class);
    }

    public function equipmentSubcategory()
    {
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
            'Description'
        ]);
    }

    public function itemDescription(): Collection
    {
        return collect([
            $this->name,
            $this->weight,
            $this->description,
        ]);
    }

}
