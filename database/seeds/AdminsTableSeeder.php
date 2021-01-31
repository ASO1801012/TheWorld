<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $adminName = [
            '教師太郎'
        ];
        $adminEmail = [
            '1001001@s.asojuku.ac.jp',

        ];
        $adminPassword = [
            Hash::make('00000000')
        ];
        $adminAdminsId = [
            '0000001'
        ];
        $adminAdminsSchool_id= [
            '1'
        ];

        for($i = 0; $i < count($adminName); $i++){
            DB::table('admins')->insert([
                'name' => $adminName[$i],
                'email' => $adminEmail[$i],
                'password' => $adminPassword[$i],
                'adminsId' => $adminAdminsId[$i],
                'school_id' => $adminAdminsSchool_id[$i]
            ]);
        }
    }
}
