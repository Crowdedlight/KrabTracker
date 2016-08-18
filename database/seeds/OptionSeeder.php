<?php

use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->insert([
                // Allowed corps
                [
                    'type' => 'allowed_corps',
                    'key' => 'king_krab_koalition',
                    'value' => '98469561',
                    'label' => 'King Krab Koalition',
                ],
                //LastUpdatedTime
                [
                    'type' => 'lastUpdated',
                    'key' => 'sigs_last_updated',
                    'value' => '',
                    'label' => 'Last updated time for sigs'
                ]
            ]
        );
    }
}
