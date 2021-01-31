<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $userName = [
            '江崎光',
            '河津翔太',
            '佐々木優斗',
            '山村篤志',
            '田辺元気(はあと)',
            '村上果鈴',
            'Grenier Alec Garza'
        ];
        $userEmail = [
            '1801007@s.asojuku.ac.jp',
            '1801012@s.asojuku.ac.jp',
            '2001055@s.asojuku.ac.jp',
            '1801034@s.asojuku.ac.jp',
            '1801023@s.asojuku.ac.jp',
            '1901104@s.asojuku.ac.jp',
            '1801041@s.asojuku.ac.jp'
        ];
        $userStudent_number = [
            '1801007',
            '1801012',
            '2001055',
            '1801034',
            '1801023',
            '1901104',
            '1801041'
        ];

        for($i = 0; $i < count($userName); $i++){
            DB::table('users')->insert([
                'name' => $userName[$i],
                'email' => $userEmail[$i],
                'password' => Hash::make('00000000'),
                'student_number' => $userStudent_number[$i],
                'picturePass' => 'noImage.png',
                'intro' => 'よろしくお願いします！',
                'firstLogin' => 0,
                'school_id' => 1,
                'language_id' => 1,
                'one_pass' => 0
            ]);
        }
    }
}
