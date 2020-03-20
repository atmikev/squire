<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EquipmentSubcategory
 * @package App
 * @property int $id
 * @property EquipmentCategory $category
 * @property string $name
 */
class EquipmentSubcategory extends Model
{

    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class);
    }

    public function items()
    {
        return $this->hasMany(EquipmentItem::class);
    }

}
