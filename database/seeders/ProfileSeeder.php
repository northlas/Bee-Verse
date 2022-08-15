<?php

namespace Database\Seeders;

use App\Models\Avatar;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $avatars = array();

        foreach (User::all() as $user) {
            $rand = rand(6, count(Avatar::all()));

            $profile = new profile();
            $profile->user_id = $user->id;
            $profile->avatar_id = $rand;
            $profile->active = true;
            $profile->save();

            $avatars[$user->id] = array();
            array_push($avatars[$user->id], $rand);

            for ($i=0; $i < 4; $i++) { 
                $profile = new profile();
                $profile->user_id = $user->id;

                do {
                    $rand = rand(6, count(avatar::all()));
                } while (in_array($rand, $avatars[$user->id]));

                $profile->avatar_id = $rand;
                $profile->save();

                array_push($avatars[$user->id], $rand);
            }
        }
    }
}
