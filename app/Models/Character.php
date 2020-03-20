<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Character
 * @package App
 * @property int $id
 * @property CharacterStat $characterStat
 * @property string $name
 */
class Character extends Model
{
    public function characterStat()
    {
        return $this->belongsTo(CharacterStat::class);
    }

    public function inventoryItems() {
        return $this->hasMany(InventoryItem::class);
    }

    public function addEquipmentItem(EquipmentItem $equipmentItem, int $quantity) {
        $inventoryItem = new InventoryItem([
            'quantity' => $quantity,
        ]);

        $inventoryItem->item()->associate($equipmentItem->item);

        $this->inventoryItems()->save($inventoryItem);

    }
}
