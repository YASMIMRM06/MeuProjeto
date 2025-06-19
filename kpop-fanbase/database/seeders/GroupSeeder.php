<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
            'name' => 'BTS',
            'formation_date' => '2013-06-13',
            'company' => 'Big Hit Music',
            'description' => 'A South Korean boy band formed in 2010 and debuted in 2013.',
            'photo' => 'bts.jpg',
        ]);

        Group::create([
            'name' => 'BLACKPINK',
            'formation_date' => '2016-08-08',
            'company' => 'YG Entertainment',
            'description' => 'A South Korean girl group formed by YG Entertainment.',
            'photo' => 'blackpink.jpg',
        ]);

        Group::create([
            'name' => 'EXO',
            'formation_date' => '2012-04-08',
            'company' => 'SM Entertainment',
            'description' => 'A South Korean-Chinese boy band formed by SM Entertainment.',
            'photo' => 'exo.jpg',
        ]);
    }
}