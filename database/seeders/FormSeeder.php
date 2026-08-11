<?php

namespace Database\Seeders;

use App\Models\Form;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $form = Form::create([
            'title' => 'Survey Form',
            'description' => 'Please complete the survey below.'
        ]);

        $form->fields()->createMany([
            ['label' => 'Name', 'type' => 'text', 'required' => true],
            ['label' => 'Gender', 'type' => 'radio', 'required' => true],
            ['label' => 'Country', 'type' => 'select', 'required' => true],
        ]);
    }
}
