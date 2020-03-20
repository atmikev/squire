<?php

namespace App\Console\Commands;

use App\AbilityScore;
use App\AdventuringGear;
use App\Armor;
use App\ArmorClass;
use App\Character;
use App\CharacterClass;
use App\CharacterStat;
use App\Damage;
use App\DamageType;
use App\Dice;
use App\EquipmentCategory;
use App\EquipmentItem;
use App\EquipmentSubcategory;
use App\MagicSchool;
use App\Spell;
use App\Tool;
use App\Vehicle;
use App\Weapon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ImportSRD extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'squire:import-srd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate and Re-Import the System Reference Document related tables';

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
        $this->info('Starting the import...');

        $this->truncateTables();

        $this->parseCharacterClasses();
        $this->parseMagicSchools();
        $this->parseDamageTypes();
        $this->parseEquipment();
        $this->parseWeapons();
        $this->parseSpells();

        $this->info('Import completed!');

        return;
    }

    private function jsonFromFile(string $fileName)
    {
        $file = file_get_contents(storage_path() . '/app/json/5E_SRD/' . $fileName);

        return collect(json_decode($file, true));
    }

    private function truncateTables() {

        $this->info('Truncating old data...');

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        $tables = [
            'armors',
            'armor_classes',
            'tools',
            'adventuring_gears',
            'damage_types',
            'damages',
            'weapons',
            'spells',
            'character_classes',
            'magic_schools',
            'equipment_categories',
            'equipment_subcategories',
            'vehicles',
            'equipment_items',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }

    private function parseCharacterClasses()
    {
        $this->warn('Fake Parsing Classes (need to read the real file still)...');

        $classNames = explode(',','Wizard,Sorcerer,Cleric,Paladin,Ranger,Bard,Druid,Warlock');

        foreach ($classNames as $name) {
            $this->line($name);

            $characterClass = new CharacterClass();
            $characterClass->name = $name;

            $characterClass->save();
        }

    }

    private function parseMagicSchools()
    {

        $this->warn('Fake Parsing Magic Schools (need to read the real file still)...');

        $schoolNames = explode(',', 'Evocation,Conjuration,Abjuration,Transmutation,Enchantment,Necromancy,Divination,Illusion');

        foreach($schoolNames as $name) {
            $this->line($name);

            $school = new MagicSchool();
            $school->name = $name;

            $school->save();
        }

    }

    private function parseSpells()
    {
        $this->info('Parsing Spells...');

        $spellsJSON = $this->jsonFromFile('5e-SRD-Spells.json');

        foreach ($spellsJSON as $json) {


            /** @var Spell $spell */
            $spell = new Spell();
            $spell->name = $json['name'];
            $spell->description = $json['desc'][0];
            if (isset($json['higher_level'])) {
                $spell->higher_level = $json['higher_level'][0];
            }
            $spell->page = $json['page'];
            $spell->range = $json['range'];
            $spell->duration = $json['duration'];
            $spell->casting_time = $json['casting_time'];
            $spell->level = $json['level'];

            /** @var MagicSchool $school */
            $school = MagicSchool::where('name', $json['school']['name'])->firstOrFail();
            $spell->magicSchool()->associate($school);

            $spell->save();

            $classNames = collect($json['classes'])->pluck('name');
            /** @var Collection $classes */
            $classes = CharacterClass::whereIn('name', $classNames)->get();

            $spell->characterClasses()->attach($classes->pluck('id'));
        }

    }

    private function parseDamageTypes()
    {

        $this->info('Parsing Damage Types...');

        $damageTypes = $this->jsonFromFile('5e-SRD-Damage-Types.json');

        foreach($damageTypes as $type) {

            /** @var DamageType $damageType */
            $damageType = new DamageType();
            $damageType->name = $type['name'];
            $damageType->description = $type['desc'][0];
            $damageType->save();
        }

    }

    private function parseWeapons()
    {
        $this->info('Parsing Weapons...');

        $equipmentJSON = $this->jsonFromFile('5e-SRD-Equipment.json');

        $weaponsJSON = $equipmentJSON->where('equipment_category', 'Weapon');

        foreach($weaponsJSON as $weaponJSON) {

            $this->line('Creating ' . $weaponJSON['name']);

            //create damage
            $damageJSON = $weaponJSON['damage'];

            $diceName = 'd' . $damageJSON['dice_value'];

            /** @var Dice $dice */
            $dice = Dice::where('name', $diceName)->firstOrFail();

            $damageName = $damageJSON['damage_type']['name'];

            /** @var DamageType $damageType */
            $damageType = DamageType::where('name', $damageName)->firstOrFail();

            /** @var Damage $damage */
            $damage = new Damage();
            $damage->damageType()->associate($damageType);
            $damage->dice()->associate($dice);
            $damage->dice_count = $damageJSON['dice_count'];
            $damage->save();

            /** @var Weapon $weapon */
            $weapon = new Weapon();
            $weapon->name = $weaponJSON['name'];
            $weapon->weight = $weaponJSON['weight'];
            $weapon->damage()->associate($damage);

            $weapon->save();

            $this->createEquipmentItem('weapon', $weaponJSON['weapon_category:'], $weapon);

        }

    }

    private function createEquipmentItem(string $categoryName, string $subcategoryName, $item) {

        /** @var EquipmentItem $equipmentItem */
        $equipmentItem = new EquipmentItem();

        /** @var EquipmentCategory $category */
        $category = EquipmentCategory::where('name', $categoryName)->first();
        $equipmentItem->equipmentCategory()->associate($category);

        /** @var EquipmentSubcategory $subcategory */
        $subcategory = EquipmentSubcategory::where('name', $subcategoryName)->first();
        $equipmentItem->equipmentSubcategory()->associate($subcategory);

        $equipmentItem->item()->associate($item);

        $equipmentItem->save();

    }

    private function parseCategories(Collection $equipment)
    {
        $this->info('Parsing Categories');

        $category_names = $equipment->map( function($item) {
            $item = collect($item);
            return $item['equipment_category'];
        })->unique();

        foreach ($category_names as $name) {
            $category = new EquipmentCategory();
            $category->name = $name;
            $category->save();
        }

        $this->info('Categories complete');

    }

    private function parseSubcategories(Collection $equipment) {
        $this->info('Parsing Subcategories');

        $subcategory_keys = $equipment->map( function($item) {
            $item = collect($item);
            return $item->keys();
        })
            ->flatten()
            ->filter( function($key) {
                return str_contains($key, 'category')
                    && !starts_with($key, 'equipment')
                    && !starts_with($key, 'category');
            })
            ->unique();

        $this->info('Found keys:');

        $subcategory_keys->each( function($key) use($equipment) {

            $this->info($key);

            $filtered_equipment = $equipment->filter( function($item) use ($key) {
                return isset($item[$key]);
            });

            $subcategory_names = $filtered_equipment->pluck($key)
                ->unique();

            /** @var EquipmentCategory $category */
            $category = EquipmentCategory::where('name', $filtered_equipment->first()['equipment_category'])->firstOrFail();

            $subcategory_names->each(function($name) use ($category) {
                /** string $name */

                /** @var EquipmentSubcategory $subcategory */
                $subcategory = new EquipmentSubcategory();
                $name = trim($name, ':');
                $subcategory->name = $name;
                $category->subcategories()->save($subcategory);

            });


        });

        $this->info('Subcategories complete');

    }

    private function parseAdventuringGear(Collection $equipment) {

        $this->info('Parsing adventuring gear...');

        $gear = $equipment->where('equipment_category', 'Adventuring Gear')
                          ->whereNotIn('gear_category', ['Equipment Pack']);

        foreach($gear as $itemJSON) {

            $item = new AdventuringGear();
            $item->name = $itemJSON['name'];

            if (isset($itemJSON['weight'])) {
                $item->weight = $itemJSON['weight'];
                $this->info( $item->name . ' has weight');
            } else {
                $this->warn( $item->name . ' has no weight');
            }

            if (isset($itemJSON['desc'])) {
                $item->description = $itemJSON['desc'][0];
                $this->info( $item->name . ' has description');
            } else {
                $this->warn( $item->name . ' has no description');
            }

            $item->save();

            $this->createEquipmentItem($itemJSON['equipment_category'], $itemJSON['gear_category'], $item);

        }

        $this->info('Adventuring gear complete!');

    }

    private function parseTools($equipment)
    {

        $this->info('Parsing tools...');

        $toolsJSON = $equipment->where('equipment_category', 'Tools');

        foreach($toolsJSON as $itemJSON) {

            /** @var Tool $item */
            $item = new Tool();
            $item->name = $itemJSON['name'];

            if (isset($itemJSON['weight'])) {
                $item->weight = $itemJSON['weight'];
                $this->info( $item->name . ' has weight');
            } else {
                $this->warn( $item->name . ' has no weight');
            }

            if (isset($itemJSON['desc'])) {
                $item->description = $itemJSON['desc'][0];
                $this->info( $item->name . ' has description');
            } else {
                $this->warn( $item->name . ' has no description');
            }

            $item->save();

            $this->createEquipmentItem($itemJSON['equipment_category'], $itemJSON['tool_category'], $item);


        }

        $this->info('Tools completed!');
    }

    private function parseArmor($equipment)
    {
        $this->info('Parsing Armor...');

        $armorJSON = $equipment->where('equipment_category', 'Armor');

        foreach($armorJSON as $json) {

            //Get the ArmorClass
            $ac_json = $json['armor_class'];
            $armor_class = ArmorClass::where('base', $ac_json['base'])
                ->where('dex_bonus', $ac_json['dex_bonus'])
                ->where('max_bonus', $ac_json['max_bonus'])
                ->first();

            if (isset($armor_class) === false) {
                $armor_class = new ArmorClass($ac_json);
                $armor_class->save();
            }

            $armor = new Armor($json);
            $armor->armorClass()->associate($armor_class);

            $armor->save();

            $this->createEquipmentItem($json['equipment_category'], $json['armor_category'], $armor);

        }

        $this->info('Armor created!');
    }

    private function parseVehicles($equipment) {

        $this->info('Parsing Mounts and Vehicles...');

        $vehicleJSONs = $equipment->where('equipment_category', 'Mounts and Vehicles');

        foreach ($vehicleJSONs as $json) {
            $fillable = collect($json)->except(['speed','capacity'])->toArray();

            $vehicle = Vehicle::where('name', $json['name'])->first();
            if ( isset($vehicle) ) {
                continue;
            }

            $vehicle = new Vehicle($fillable);
            if (isset($json['speed'])){
                $speed_json = $json['speed'];
                $vehicle->speed = $speed_json['quantity'];
            }

            if (isset($json['capacity'])) {
                /** @var string $capacity_string */
                $capacity_string = explode(' ', $json['capacity'])[0];
                $vehicle->capacity =  (int)$capacity_string;
            }

            $vehicle->save();

            $this->createEquipmentItem($json['equipment_category'], $json['vehicle_category'], $vehicle);

        }

        $this->info('Mounts and Vehicles complete!');
    }

    private function parseEquipment()
    {
        $this->info('Parsing Equipment');

        $equipment = $this->jsonFromFile('5e-SRD-Equipment.json');

        $this->parseCategories($equipment);
        $this->parseSubcategories($equipment);
        $this->parseAdventuringGear($equipment);
        $this->parseTools($equipment);
        $this->parseArmor($equipment);
        $this->parseVehicles($equipment);

    }

    private function dumpKeysFor($json) {
        $keys = $json->map( function($item) {
            $item = collect($item);
            return $item->keys();
        })
            ->flatten()
            ->unique();

        dd($keys);
    }
}
