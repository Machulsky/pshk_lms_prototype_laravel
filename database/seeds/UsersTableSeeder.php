<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $teacherRole = Role::where('name', 'teacher') -> first();
        $studentRole = Role::where('name', 'student')->first();

        $admin = User::create([
        	'username' => 'admin',
        	'firstname' => 'Петр',
        	'lastname' => 'Мачульский',
        	'patronym' => 'Владимирович',
        	'password' => bcrypt('admin')
        ]);

        $teacher = User::create([
        	'username' => 'teacher',
        	'firstname' => 'Елена',
        	'lastname' => 'Ольховская',
        	'patronym' => 'Павловна',
        	'password' => bcrypt('teacher')
        ]);

        $student = User::create([
        	'username' => 'student',
        	'firstname' => 'Даниил',
        	'lastname' => 'Ткалич',
        	'patronym' => 'Алексеевич',
        	'password' => bcrypt('student')
        ]);

        $admin->roles()->attach($adminRole);
        $teacher->roles()->attach($teacherRole);
        $student->roles()->attach($studentRole);
    }
}
