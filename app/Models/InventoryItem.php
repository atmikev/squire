<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InventoryItem
 * @package App
 * @property Character $character
 * @property int $quantity
 * @property int $item_id
 * @property int $item_type
 */
class InventoryItem extends Model
{

    protected $fillable = [
        'quantity',
    ];


    public function character() {
        return $this->belongsTo(Character::class);
    }

    public function item() {
        return $this->morphTo();
    }

}
