<?php

use Illuminate\Database\Seeder;
use App\AnswerType;
class AnswerTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnswerType::truncate();
        AnswerType::create(['name' => 'text', 'displayname' => 'Текстовый ответ']);
        AnswerType::create(['name' => 'file', 'displayname' => 'Ответ в виде файлов']);
        AnswerType::create(['name' => 'textfile', 'displayname' => 'Текст и файлы']);
        //
    }
}
