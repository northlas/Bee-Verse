<?php

namespace Database\Seeders;

use App\Models\Avatar;
use Illuminate\Database\Seeder;

class AvatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $avatar = new Avatar();
        $avatar->name = 'Default';
        $avatar->image = 'default-female.png';
        $avatar->price = 0;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Default';
        $avatar->image = 'default-male.png';
        $avatar->price = 0;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Pink Bear Anonymous';
        $avatar->image = 'bear_1.png';
        $avatar->price = 0;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Tosca Bear Anonymous';
        $avatar->image = 'bear_2.png';
        $avatar->price = 0;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Brown Bear Anonymous';
        $avatar->image = 'bear_3.png';
        $avatar->price = 0;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Green Bull';
        $avatar->image = 'bull_1.png';
        $avatar->price = 1000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Green Cat';
        $avatar->image = 'cat_1.png';
        $avatar->price = 1000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Neon Cat';
        $avatar->image = 'cat_2.png';
        $avatar->price = 2000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Brown Cat';
        $avatar->image = 'cat_3.png';
        $avatar->price = 500;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Green Dog';
        $avatar->image = 'dog_1.png';
        $avatar->price = 1000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Brown Dog';
        $avatar->image = 'dog_2.png';
        $avatar->price = 500;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Pink Dog';
        $avatar->image = 'dog_3.png';
        $avatar->price = 5000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Tosca Dog';
        $avatar->image = 'dog_4.png';
        $avatar->price = 3000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Neon Dog';
        $avatar->image = 'dog_5.png';
        $avatar->price = 2000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Brown Goat';
        $avatar->image = 'goat_1.png';
        $avatar->price = 1000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Polkadot Goat';
        $avatar->image = 'goat_2.png';
        $avatar->price = 3000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Green Goat';
        $avatar->image = 'goat_3.png';
        $avatar->price = 2000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Green Mouse';
        $avatar->image = 'mouse_1.png';
        $avatar->price = 1000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Neon Mouse';
        $avatar->image = 'mouse_2.png';
        $avatar->price = 2000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Green Pig';
        $avatar->image = 'pig_1.png';
        $avatar->price = 1000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Pink Reindeer';
        $avatar->image = 'reindeer_1.png';
        $avatar->price = 6000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Neon Reindeer';
        $avatar->image = 'reindeer_2.png';
        $avatar->price = 4000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Tosca Reindeer';
        $avatar->image = 'reindeer_3.png';
        $avatar->price = 3000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Brown Reindeer';
        $avatar->image = 'reindeer_4.png';
        $avatar->price = 2000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Pink Sheep';
        $avatar->image = 'sheep_1.png';
        $avatar->price = 3000;
        $avatar->save();

        $avatar = new Avatar();
        $avatar->name = 'Brown Sheep';
        $avatar->image = 'sheep_2.png';
        $avatar->price = 1000;
        $avatar->save();
    }
}
