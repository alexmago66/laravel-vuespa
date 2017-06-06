<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    User::truncate();
    $user1 = [
      'name' => 'Alessandro Fratini',
      'email' => 'alex.fratini@tiscali.it',
      'password' => Hash::make('fre66ngo')
    ];
    User::create($user1);
    factory(App\User::class, 15)->create();
  }
}
