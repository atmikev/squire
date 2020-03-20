<?php

namespace App\Console\Commands;

use App\AbilityScore;
use App\Character;
use App\CharacterStat;
use Illuminate\Console\Command;

class CreateCharacter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'squire:create-character';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new character';

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
        $this->introduceSquire();

        /** @var Character $character */
        $character = $this->getCharacterInfo();

        /** @var AbilityScore $abilityScores */
        $abilityScores = $this->startAbilityEntry();
        $abilityScores->save();

        /** @var CharacterStat $characterStats */
        $characterStats = new CharacterStat();
        $characterStats->abilityScore()->associate($abilityScores)->save();
        $characterStats->save();

        $character->characterStat()->associate($characterStats)->save();
        $character->save();

        $this->bidFarewell($character);
    }

    private function introduceSquire()
    {
        $this->info("Greetings, adventurer! Welcome to the beginning of your heroic journey!");
        $this->info("I am Squire, your humble servant.");
        $this->info("My job is to take care of the tediousness during your adventures.");
    }

    private function bidFarewell(Character $character)
    {
        $this->info("That is all for now, {$character->name}. Let us hurry off.");
        $this->info("Adventure awaits!");
    }

    private function getCharacterInfo(): Character
    {
        $this->info("Forgive me, but I'm unable to tell your ancestry.");

        /** @var Character $character */
        $character = new Character();

        $character->name = $this->ask('What should I call you?');

        $this->info("{$character->name}... a name that will go down in the annals history!");

        return $character;
    }

    private function startAbilityEntry()
    {
        $this->info('Now lets figure out your abilities!');

        $roll = $this->choice('Do you want to roll your abilities, or would you like me to do it?', ['I\'ll roll them.', 'You roll them.']);

        if ($roll === 0) {
            $abilityScores = $this->manuallyEnterAbilityScores();
        } else {
            $abilityScores = $this->autoRollAbilityScores();
        }

        return $abilityScores;
    }

    private function manuallyEnterAbilityScores(): AbilityScore
    {

        $this->info('On a scale of 1 to 30...');

        $abilityScores = new AbilityScore();

        $abilityScores->strength = $this->ask('How strong are you?');
        $abilityScores->dexterity = $this->ask('How dexterous are you?');
        $abilityScores->constitution = $this->ask('How strong is your constitution?');
        $abilityScores->intelligence = $this->ask('How intelligent are you?');
        $abilityScores->wisdom = $this->ask('How wise are you?');
        $abilityScores->charisma = $this->ask('How charismatic are you?');

        $this->info('Excellent! And since we just met, I have no reason to assume you lied!');

        return $abilityScores;
    }

    private function autoRollAbilityScores(): AbilityScore
    {

        $this->info('Why thank you! I do believe I am a good judge of character, so let me just see here...');

        $abilityScores = new AbilityScore();

        $abilityScores->strength = $this->rollForAbility("strength");
        $abilityScores->dexterity = $this->rollForAbility("dexterity");
        $abilityScores->constitution = $this->rollForAbility("constitution");
        $abilityScores->intelligence = $this->rollForAbility("intelligence");
        $abilityScores->wisdom = $this->rollForAbility("wisdom");
        $abilityScores->charisma = $this->rollForAbility("charisma");

        $this->info('There now, I have you as');

        $headers = [
            'Ability',
            'Score'
        ];

        $abilities = collect([
            'Strength',
            'Dexterity',
            'Constitution',
            'Intelligence',
            'Wisdom'
        ]);

        $scores = [
            $abilityScores->strength,
            $abilityScores->dexterity,
            $abilityScores->constitution,
            $abilityScores->intelligence,
            $abilityScores->wisdom
        ];

        $values = $abilities->zip($scores);

        $this->table($headers, $values);

        return $abilityScores;

    }

    private function rollForAbility(string $abilityName): int
    {
        $this->info("For your {$abilityName}...");
        $roll = $this->calculateScore();
        $reaction = $this->reactToRoll($roll);
        $this->info($reaction);

        return $roll;
    }

    private function calculateScore(): int
    {
        $rolls = collect([rand(1, 6), rand(1, 6), rand(1, 6), rand(1, 6)]);

        $rolls->sort(function ($v1, $v2) {
            return $v1 > $v2;
        });

        $rolls->pop();

        return $rolls->sum();
    }

    private function reactToRoll(int $value): string
    {

        if ($value > 16) {
            return "Oh my!";
        }

        if ($value > 10) {
            return "That's about right.";
        }

        return "Oh dear...";
    }


}
