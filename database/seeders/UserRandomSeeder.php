<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserRandomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = array(
            "Adji Budhi", "Alfredo Lorentiar", "Calista Daphne", "Daniel Wijaya", "Ethan Wang",
            "Exaudina Glory", "Felesia Lo", "Fernando Clemente", "Cicila Margono", "Hirokhi Kalas",
            "Ivanco Gratio", "Jason Immanuel", "Jossen Clinson", "Lusia Kintanswari", "Martin Marvelino",
            "Michael Stanley", "Michelle Pauline", "Monica Ruth", "Mulyani Angel", "Pascal Wilman",
            "Rachmat Kurniawan", "Ricky Nathaniel", "Sharon Cedila", "Steven Gunawan", "Vanessa Augustine", 
            "Vincent ", "Vincentius Johnathan", "Vincy ", "Winata Liadylova", "Yohanes ", "Yovita Phoebe", 
        );

        $gender = array("Female", "Male");

        foreach ($name as $key => $item) {
            $user = new User();
            $user->name = $item;
            $user->email = strtolower(str_replace(' ','_',$item)).'@gmail.com';
            $user->password = bcrypt(strtolower(substr($item, 0, strpos($item, ' '))));
            $user->username = strtolower(substr($item, 0, strpos($item, ' ')));
            $user->gender = $gender[array_rand($gender)];
            $user->mobile = '0812345678'.$key;
            $user->balance = rand(1, 10)*1000;
            $user->slug = Str::slug($item);
            $user->save();
        }
    }
}
