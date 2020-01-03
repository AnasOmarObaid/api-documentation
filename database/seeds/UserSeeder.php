<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emails = ['anas@gmail.com', 'wesam@gmail.com', 'mohamod@gmail.com', 'osama@gmail.com'];
        $number = 0;
        foreach ($emails as $email) {
            ++$number;
            User::create([
                'name' => 'demo' . $number,
                'email' => $email,
                'password'  => sha1('123123123'),
            ]);
        } //-- end foreach
    } //-- end user seeder
}
