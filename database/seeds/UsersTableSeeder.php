<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Entities\Human;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $user = User::create([
          'type'     => 'admin',
          'email'    => 'admin@npj.com',
          'password' =>bcrypt('admin'),
      ]);

      $human = Human::create([
          'status'    => 'active',
          'name'      => 'Neylanio Soares',
          'gender'    => 'Masculino',
          'user_id'   => $user->id
      ]);

    }
}
