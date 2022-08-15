<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $field = new Field();
        $field->name = 'Entrepreneur';
        $field->save();

        $field = new Field();
        $field->name = 'Freelancer';
        $field->save();

        $field = new Field();
        $field->name = 'Athlete';
        $field->save();

        $field = new Field();
        $field->name = 'Accountant';
        $field->save();

        $field = new Field();
        $field->name = 'Budget Analyst';
        $field->save();

        $field = new Field();
        $field->name = 'Health Educator';
        $field->save();

        $field = new Field();
        $field->name = 'Farmworker';
        $field->save();

        $field = new Field();
        $field->name = 'Chef';
        $field->save();

        $field = new Field();
        $field->name = 'Bartender';
        $field->save();

        $field = new Field();
        $field->name = 'Barista';
        $field->save();

        $field = new Field();
        $field->name = 'Judge';
        $field->save();

        $field = new Field();
        $field->name = 'Lawyer';
        $field->save();

        $field = new Field();
        $field->name = 'Archeologist';
        $field->save();

        $field = new Field();
        $field->name = 'Historian';
        $field->save();

        $field = new Field();
        $field->name = 'Infantry';
        $field->save();

        $field = new Field();
        $field->name = 'Professional Gamer';
        $field->save();

        $field = new Field();
        $field->name = 'Front End Developer';
        $field->save();

        $field = new Field();
        $field->name = 'Back End Developer';
        $field->save();

        $field = new Field();
        $field->name = 'UX Designer';
        $field->save();

        $field = new Field();
        $field->name = 'Architect';
        $field->save();
    }
}
