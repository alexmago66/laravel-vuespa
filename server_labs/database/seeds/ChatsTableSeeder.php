<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Chat;

class ChatsTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    $faker = Factory::create();
    Chat::truncate();
    for ($i = 1; $i < 500; $i++) {
      $senderId = mt_rand(1,16);
      $receiverId = mt_rand(1,16);
      if ($senderId != $receiverId) {
        Chat::create([
          'sender_id' => $senderId,
          'receiver_id' => $receiverId,
          'chat' => $faker->sentence,
          'read' => true
        ]);
      }
    }
  }
}
