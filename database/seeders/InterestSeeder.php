<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\Interest;
use App\Models\User;
use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fields = array();

        foreach (User::all() as $user) {
            $rand = rand(1, count(Field::all()));

            $interest = new Interest();
            $interest->user_id = $user->id;
            $interest->field_id = $rand;
            $interest->save();

            $fields[$user->id] = array();
            array_push($fields[$user->id], $rand);

            for ($i=0; $i < 2; $i++) { 
                $interest = new Interest();
                $interest->user_id = $user->id;

                do {
                    $rand = rand(1, count(Field::all()));
                } while (in_array($rand, $fields[$user->id]));

                $interest->field_id = $rand;
                $interest->save();

                array_push($fields[$user->id], $rand);
            }
        }
    }
}
