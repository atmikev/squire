<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EquipmentItem
 * @package App
 * @property EquipmentCategory $equipmentCategory
 * @property EquipmentSubcategory $equipmentSubcategory
 * @property mixed $item
 */
class EquipmentItem extends Model
{

    public function equipmentCategory()
    {
        return $this->belongsTo(EquipmentCategory::class);
    }

    public function equipmentSubcategory()
    {
        return $this->belongsTo(EquipmentSubcategory::class);
    }

    public function item()
    {
        return $this->morphTo();
    }
}

//This might not be a valid class anymore.
