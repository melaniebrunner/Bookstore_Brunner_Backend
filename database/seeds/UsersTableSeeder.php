<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //BackendUser
        $user = new App\User();
        $user->name = 'Testuser';
        $user->email = 'test@gmail.com';
        $user->password = bcrypt('secret');
        $user->firstName = 'Test';
        $user->lastName = 'User';
        $user->address = 'Softwarepark 10, 4232 Hagenberg, A';
        $user->flag = '0';
        $user->save();

        //FrontendUser1
        $user1 = new App\User();
        $user1->name = 'MelanieBrunner';
        $user1->email = 'melanie.brunner@gmail.com';
        $user1->password = bcrypt('melanie');
        $user1->firstName = 'Melanie';
        $user1->lastName = 'Brunner';
        $user1->address = 'Hinterklam 1, 5133 Gilgenberg, A';
        $user1->flag = '1';
        $user1->save();

        //FrontendUser2
        $user2 = new App\User();
        $user2->name = 'MaxMustermann';
        $user2->email = 'max.mustermann@gmail.com';
        $user2->password = bcrypt('max');
        $user2->firstName = 'Max';
        $user2->lastName = 'Mustermann';
        $user2->address = 'Musterstraße 6, 1234 Muster, A';
        $user2->flag = '1';
        $user2->save();
    }
}
