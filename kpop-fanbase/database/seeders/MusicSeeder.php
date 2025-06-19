<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\Music;

class MusicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bts = Group::where('name', 'BTS')->first();
        $blackpink = Group::where('name', 'BLACKPINK')->first();
        $exo = Group::where('name', 'EXO')->first();

        if ($bts) {
            Music::create([
                'group_id' => $bts->id,
                'title' => 'Dynamite',
                'duration' => '00:03:43',
                'youtube_link' => 'https://www.youtube.com/watch?v=gdZLi9oWNZg',
                'release_date' => '2020-08-21',
            ]);
            Music::create([
                'group_id' => $bts->id,
                'title' => 'Butter',
                'duration' => '00:02:44',
                'youtube_link' => 'https://www.youtube.com/watch?v=WMweEpGlu_U',
                'release_date' => '2021-05-21',
            ]);
        }

        if ($blackpink) {
            Music::create([
                'group_id' => $blackpink->id,
                'title' => 'DDU-DU DDU-DU',
                'duration' => '00:03:29',
                'youtube_link' => 'https://www.youtube.com/watch?v=IHNzOHi8sJs',
                'release_date' => '2018-06-15',
            ]);
            Music::create([
                'group_id' => $blackpink->id,
                'title' => 'Kill This Love',
                'duration' => '00:03:09',
                'youtube_link' => 'https://www.youtube.com/watch?v=2S24-y03-Fw',
                'release_date' => '2019-04-04',
            ]);
        }

        if ($exo) {
            Music::create([
                'group_id' => $exo->id,
                'title' => 'Growl',
                'duration' => '00:03:27',
                'youtube_link' => 'https://www.youtube.com/watch?v=I3dezFzsNig',
                'release_date' => '2013-08-01',
            ]);
        }
    }
}