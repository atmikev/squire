<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface ItemDescriptionInterface
{
    public static function itemHeaders(): Collection;
    public function itemDescription(): Collection;
}