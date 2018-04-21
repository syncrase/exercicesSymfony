<?php

namespace App\Core\VisJS\Timeline;

/**
 * Reçoit une chaîne de caractère représentant une date pour en extraire les 
 * valeurs nécessaires
 *
 * @author Pierre
 */
class Date {

    function __construct($date) {
        // Match date format like: Sat Dec 31 1149 00:00:00 GMT+0100 (Paris, Madrid)
        // This is the format when dynamically created by vis.js
        if (preg_match('/^\w{3} \w{3} \d{2} -?\d{1,6} \d{2}:\d{2}:\d{2} GMT\+0(100 \(Paris, Madrid\)|200)$/', $date) === 1) {
            $splittedDate = explode(' ', $date);
            $this->year = $splittedDate[3];
            $this->month = $this->convertMonthAsNumber($splittedDate[1]);
            $this->day = $splittedDate[2];


            // Match date format like: -000426-01-01 ou 2012-12-31
            // This the persisted format !
        } elseif (preg_match('/^-?\d{1,6}-\d{2}-\d{2}$/', $date) === 1) {

            $isBC = $date[0] === '-';
            // documentation http://php.net/ltrim
            $date = ltrim($date, '-');
            $splittedDate = explode('-', $date);
            $this->year = ($isBC ? '-' : '') . $splittedDate[0];
            $this->month = $splittedDate[1];
            $this->day = $splittedDate[2];
        } else {
            var_dump('Date (' . (string) $date . ') non prise en charge');
        }
    }

    private $year;

    public function setYear($year) {
        $this->year = $year;
    }

    public function getYear() {
        return $this->year;
    }

    private $month;

    public function setMonth($month) {
        $this->month = $month;
    }

    public function getMonth() {
        return $this->month;
    }

    private $day;

    public function setDay($day) {
        $this->day = $day;
    }

    public function getDay() {
        return $this->day;
    }

    /*     * *******************************************************************
     * ************************ PRIVATE FUNCTIONS ******************************
     * ********************************************************************** */

    private function convertMonthAsNumber($monthWithLetters) {
        switch ($monthWithLetters) {
            case 'Jan':
                return '01';
            case 'Feb':
                return '02';
            case 'Mar':
                return '03';
            case 'Apr':
                return '04';
            case 'May':
                return '05';
            case 'Jun':
                return '06';
            case 'Jul':
                return '07';
            case 'Aug':
                return '08';
            case 'Sep':
                return '09';
            case 'Oct':
                return '10';
            case 'Nov':
                return '11';
            case 'Dec':
                return '12';
            default:
                return'00';
        }
    }

}
