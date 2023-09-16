<?php
 if(! function_exists('commentsWritten')){
     /**
      * commentsWritten
      * achievements based on number of comments written, number represented by array keys
      * @return string[]
      */
     function commentsWritten(): array
     {
         return [
             1 => 'First Comment Written',
             3 => '3 Comments Written',
             5 => '5 Comments Written',
             10 => '10 Comments Written',
             20 => '20 Comments Written',
         ];
     }
 }

if(! function_exists('lessonsWatched')){
    /**
     * lessonsWatched
     * achievements based on number of lessons watched, number represented by array keys
     * @return string[]
     */
    function lessonsWatched(): array
    {
        return [
            1 => 'First Lesson Watched',
            5 => '5 Lessons Watched',
            10 => '10 Lessons Watched',
            25 => '25 Lessons Watched',
            50 => '50 Lessons Watched',
        ];
    }
}

if(! function_exists('badgesAvailable')){
    /**
     * badgesAvailable
     * determined by number of achievements, represented by array keys
     * @return string[]
     */
    function badgesAvailable(): array
    {
        return [
            0 => 'Beginner',
            4 => 'Intermediate',
            8 => 'Advanced',
            10 => 'Master',
        ];
    }
}
