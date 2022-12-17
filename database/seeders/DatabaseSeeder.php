<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // user
        DB::table('user')->insert([
            'id' => '1',
            'email' => 'user@user.user',
            'password' => Hash::make('user'),
            'username' => 'user',
        ]);
        DB::table('user')->insert([
            'id' => '2',
            'email' => 'user2@user2.user2',
            'password' => Hash::make('user2'),
            'username' => 'user2',
        ]);

        
        DB::table('form')->insert([
            'id' => '1',
            'user_id' => '1',
            'urlToken' => 'ABC123',
            'questions' => json_encode([1=>'this is question 1',2=>'second question HERE :)']),
        ]);
        DB::table('form')->insert([
            'id' => '2',
            'user_id' => '1',
            'urlToken' => 'DEF456',
            'password' => 'abc',
            'questions' => json_encode([1=>'1 question to rule them all']),
        ]);
        
        DB::table('answer')->insert([
            'userToken' => 'USERTOKEN_HERE',
            'question_id' => '1',
            'answeredTime' => date("Y-m-d H:i:s"),
            'answers' => json_encode([1=>'answer 1',2=>'answer 2']),
        ]);

        DB::table('answer')->insert([
            'userToken' => 'USERTOKEN2_HERE',
            'question_id' => '1',
            'answeredTime' => date("Y-m-d H:i:s"),
            'answers' => json_encode([1=>'answer2 blkadiebladiebla',2=>'answer2 blalba']),
        ]);
    }
}
