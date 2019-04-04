<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::where('name','admin')->first();
        $roleUser = Role::where('name','user')->first();
        $rolePM = Role::where('name', 'pm')->first();

        $superuser = new User();
        $superuser->name = 'Superuser';
        $superuser->company = 'Lexallo';
        $superuser->email = 'webmaster@lexallo.com';
        $superuser->password = bcrypt(env('ADMIN_PASSWORD'));
        $superuser->save();
        $superuser->roles()->attach($roleAdmin);

        $pmUser = new User();
        $pmUser->name = 'PM Test User';
        $pmUser->company = 'Test Company';
        $pmUser->email = 'testPM@company.com';
        $pmUser->password = bcrypt(env('PM_TEST_USER_PASSWORD'));
        $pmUser->save();
        $pmUser->roles()->attach($rolePM);

        $testUserOne = new User();
        $testUserOne->name = 'Test User One';
        $testUserOne->company = 'Test Company';
        $testUserOne->email = 'test1@company.com';
        $testUserOne->password = bcrypt(env('TEST_USER_ONE_PASSWORD'));
        $testUserOne->save();
        $testUserOne->roles()->attach($roleUser);

        $testUserTwo = new User();
        $testUserTwo->name = 'Test User Two';
        $testUserTwo->company = 'Test Company';
        $testUserTwo->email = 'test2@company.com';
        $testUserTwo->password = bcrypt(env('TEST_USER_TWO_PASSWORD'));
        $testUserTwo->save();
        $testUserTwo->roles()->attach($roleUser);
    }
}
