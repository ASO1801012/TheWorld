<?php

use Illuminate\Database\Seeder;

class LessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $lessonAttendDate = [
            '2020-12-24',
            '2020-12-25',
            '2020-12-26',
            '2020-12-27',
            '2020-12-28',
            '2020-12-29',
            '2020-12-30',
            '2020-12-31',
            '2021-1-1',
            '2021-1-2'
        ];
        $lessonReview = [
            '2',
            '3',
            '4',
            '5',
            '1',
            '2',
            '3',
            '4',
            '5',
            '0'
        ];
        $lessonIntro = [
            'クリスマスイブに幸せな夜を共に過ごしましょう！',
            '今日はクリスマスです。Merry Xmas.',
            'よろしくお願いします！26日',
            'よろしくお願いします！',
            'よろしくお願いします！',
            'よろしくお願いします！',
            'よろしくお願いします！',
            'よろしくお願いします！',
            'よろしくお願いします！',
            'よろしくお願いします！'
        ];
        $lessonUser_id = [
            '1',
            '1',
            '2',
            '2',
            '3',
            '3',
            '4',
            '4',
            '5',
            '5'
        ];
        $lessonLanguage_id = [
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10'
        ];
        $lessonTimetype_id = [
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10'
        ];

        for($i = 0; $i < count($lessonAttendDate); $i++){
            DB::table('lessons')->insert([
                'attendDate' => $lessonAttendDate[$i],
                'review' => $lessonReview[$i],
                'intro' => $lessonIntro[$i],
                'user_id' => $lessonUser_id[$i],
                'language_id' => $lessonUser_id[$i],
                'timetype_id' => $lessonTimetype_id[$i]
            ]);
        }
    }
}
