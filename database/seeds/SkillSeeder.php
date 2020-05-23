<?php

use App\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Skill::class)->create(['name' => 'HTML']);
        factory(Skill::class)->create(['name' => 'SQL']);
        factory(Skill::class)->create(['name' => 'CSS']);
        factory(Skill::class)->create(['name' => 'Laravel']);
        factory(Skill::class)->create(['name' => 'Vue']);
        factory(Skill::class)->create(['name' => 'DB']);
        factory(Skill::class)->create(['name' => 'JS']);
    }
}
