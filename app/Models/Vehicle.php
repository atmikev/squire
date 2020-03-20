<?php

namespace App;

use App\Interfaces\ItemDescriptionInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Vehicle
 * @package App
 * @property integer $id
 * @property string $name
 * @property float $capacity
 * @property string $description
 * @property int $speed
 * @property EquipmentCategory $equipmentCategory
 * @property EquipmentSubcategory $equipmentSubcategory

 */
class Vehicle extends Model implements ItemDescriptionInterface
{
    protected $fillable = [
        'name',
        'capacity',
        'speed',
        'description',
    ];

    public function equipmentItems()
    {
        return $this->morphMany('App\EquipmentItem', 'item');
    }

    public static function itemHeaders(): Collection
    {
        return collect([
          'Name',
          'Speed',
          'Capacity',
          'Description',
        ]);
    }

    public function itemDescription(): Collection
    {
        return collect([
          $this->name,
          $this->speed,
          $this->capacity,
          $this->description
        ]);
    }
}
