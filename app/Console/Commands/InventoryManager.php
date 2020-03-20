<?php

namespace App\Console\Commands;

use App\Character;
use App\EquipmentCategory;
use App\EquipmentItem;
use App\EquipmentSubcategory;
use App\Interfaces\ItemDescriptionInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class InventoryManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'squire:inventory-manager 
                            {character_id : The id of the character you want to use.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'An interactive program to manage a character\'s inventory';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var EquipmentCategory $category */
        $category = $this->selectEquipmentCategories();

        /** @var EquipmentSubcategory $subcategory */
        $subcategory = $this->selectEquipmentSubcategory($category);

        $selectedEquipmentItem = $this->selectItemFromSubcategory($subcategory);

        /** @var Character $character */
        $character = Character::findOrFail($this->argument('character_id'));

        $quantity = $this->ask('How many?');

        $this->addItemToInventory($selectedEquipmentItem, $quantity, $character);

    }

    private function addItemToInventory(EquipmentItem $equipmentItem, int $quantity, Character $character) {

        $character->addEquipmentItem($equipmentItem, $quantity);

        $this->info('Added ' . $equipmentItem->item->name . ' (' . $quantity . ') to the inventory of ' . $character->name);

    }

    private function askForSelection(string $title, Collection $selections, string $question)
    {
        $selection_strings = collect();
        foreach ($selections as $index => $selection) {
            $selection_strings->push([$index . ': ' . $selection]);
        }

        $this->table([$title], $selection_strings->toArray());

        $result = $this->ask($question);

        return $result;
    }

    private function selectEquipmentCategories(): EquipmentCategory
    {

        /** @var Collection $names */
        $names = collect();

        /** @var Collection $categories */
        $categories = EquipmentCategory::all(['id','name']);

        foreach ($categories as $category) {
            $names->push($category->name);
        }

        $question = 'Select a category:';
        $selectionIndex = $this->askForSelection('Equipment Categories', $names, $question);

        return $categories[$selectionIndex];
    }

    private function selectEquipmentSubcategory(EquipmentCategory $category): EquipmentSubcategory
    {

        /** @var EquipmentCategory $category */
        $category = EquipmentCategory::findOrFail($category->id);

        /** @var Collection $names */
        $names = collect();

        /** @var Collection $subcategories */
        $subcategories = $category->subcategories;

        foreach ($subcategories as $subcategory) {
            $names->push($subcategory->name);
        }

        $title = $category->name . ' Subcategories';

        $question = 'Select a subcategory:';

        $selectionIndex = $this->askForSelection($title, $names, $question);

        return $subcategories[$selectionIndex];
    }

    /**
     * @param EquipmentSubcategory $subcategory
     * @return EquipmentItem
     * @throws \Exception
     */
    private function selectItemFromSubcategory(EquipmentSubcategory $subcategory): EquipmentItem
    {

        $subcategory = EquipmentSubcategory::findOrFail($subcategory->id);

        /** @var Collection $equipmentItems */
        $equipmentItems = EquipmentItem::where('equipment_subcategory_id', $subcategory->id)->get();

        /** @var Collection $descriptions */
        $descriptions = collect();


        foreach ($equipmentItems as $index => $equipmentItem) {

            /** @var EquipmentItem $equipmentItem */
            $item = $equipmentItem->item;

            if ($item instanceof ItemDescriptionInterface) {
                /** @var ItemDescriptionInterface $item */

                /** @var Collection $description */
                $description = $item->itemDescription();
                $description->prepend($index);
                $descriptions->push($description);
            } else {
                throw new \Exception(get_class($item) . ' does not implement ItemDescriptionInterface');
            }

        }

        /** @var ItemDescriptionInterface $class */
        $class = get_class($equipmentItems->first()->item);
        $headers = $class::itemHeaders();
        $headers = $headers->prepend(' ');

        $this->table($headers->toArray(), $descriptions->toArray());

        $question = "Which item do you want?";

        $index = $this->ask($question);

        return $equipmentItems[$index];
    }

}
