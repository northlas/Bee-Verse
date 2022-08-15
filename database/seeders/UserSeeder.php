<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Alfredo Lorentiar Santonanda";
        $user->email = "alfredo_lorentiar@gmail.com";
        $user->password = bcrypt("alfredo");
        $user->username = "alfredo-lorentiar-s";
        $user->gender = "Male";
        $user->mobile = "08123456781";
        $user->balance = rand(1, 10)*1000;
        $user->slug = Str::slug("Alfredo Lorentiar Santonanda");
        $user->save();

        $user = new User();
        $user->name = "Fernando Clemente";
        $user->email = "fernando_clemente@gmail.com";
        $user->password = bcrypt("fernando");
        $user->username = "fernando-clemente-a909b11b6";
        $user->gender = "Male";
        $user->mobile = "08123456782";
        $user->balance = rand(1, 10)*1000;
        $user->slug = Str::slug("Fernando Clemente");
        $user->save();

        $user = new User();
        $user->name = "Jason Imanuel";
        $user->email = "jason_imanuel@gmail.com";
        $user->password = bcrypt("jason");
        $user->username = "jason-imanuel-ab5657211";
        $user->gender = "Male";
        $user->mobile = "08123456783";
        $user->balance = rand(1, 10)*1000;
        $user->slug = Str::slug("Jason Imanuel");
        $user->save();

        $user = new User();
        $user->name = "Lusia Kintanswari";
        $user->email = "12lusiakintanswari@gmail.com";
        $user->password = bcrypt("lusia");
        $user->username = "lusia-kintanswari-3978a1207";
        $user->gender = "Female";
        $user->mobile = "08123456784";
        $user->balance = rand(1, 10)*1000;
        $user->slug = Str::slug("Lusia Kintanswari");
        $user->save();

        $user = new User();
        $user->name = "Mulyani";
        $user->email = "mulyani@gmail.com";
        $user->password = bcrypt("mulyani");
        $user->username = "mulyani-m-b39a71129";
        $user->gender = "Female";
        $user->mobile = "08123456785";
        $user->balance = rand(1, 10)*1000;
        $user->slug = Str::slug("Mulyani");
        $user->save();

        $user = new User();
        $user->name = "Pascal Wilman";
        $user->email = "pascwalwilman87@gmail.com";
        $user->password = bcrypt("pascal");
        $user->username = "pascal-wilman-40a4b7148";
        $user->gender = "Male";
        $user->mobile = "08123456786";
        $user->balance = rand(1, 10)*1000;
        $user->slug = Str::slug("Pascal Wilman");
        $user->save();

        $user = new User();
        $user->name = "Vincentius Johnathan";
        $user->email = "vincentius.johnathan@gmail.com";
        $user->password = bcrypt("vincentius");
        $user->username = "vincentius-johnathan-4a250a209";
        $user->gender = "Male";
        $user->mobile = "0812345678";
        $user->balance = rand(1, 10)*1000;
        $user->slug = Str::slug("Vincentius Johnathan");
        $user->save();
    }
}
