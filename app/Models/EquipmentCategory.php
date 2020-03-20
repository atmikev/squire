<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class EquipmentCategory
 * @package App
 * @property int $id
 * @property string $name
 * @property Collection $subcategories
 */
class EquipmentCategory extends Model
{

    public function items()
    {
        return $this->hasMany(EquipmentItem::class);
    }

    public function subcategories() {
        return $this->hasMany(EquipmentSubcategory::class);
    }

}
