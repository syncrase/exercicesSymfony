<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Core\VisJS\Timeline;

use App\Document\TimelineItem;

/**
 * Les attributs de cet objets sont dédiés à reçevoir les valeurs du JSON 
 * représentant la timeline puis à les mettre en forme avant la persistence
 * Provide methods to get data in shape 
 * 
 *
 * @author Pierre
 */
class VisTimelineSerializationHelper {

    private $id;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    private $content;

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    private $start;

    public function getStart() {
        return $this->start;
    }

    public function setStart($start) {
        $this->start = $start;
    }

    private $end;

    public function getEnd() {
        return $this->end;
    }

    public function setEnd($end) {
        $this->end = $end;
    }

    private $timelineItem;

    public function initTimelineItem() {
        $this->timelineItem = new TimelineItem();
        $this->timelineItem->setContent($this->content);

        // Match date format like: Sat Dec 31 1149 00:00:00 GMT+0100 (Paris, Madrid)
        if (preg_match('/^\w{3} \w{3} \d{2} -?\d{1,6} \d{2}:\d{2}:\d{2} GMT\+0(100 \(Paris, Madrid\)|200)$/', $this->start) === 1) {
            $start = explode(' ', $this->start);
            $startYear = $start[3];
            $startMonth = $this->convertMonthAsNumber($start[1]);
            $startDay = $start[2];


            // Match date format like: -000426-01-01 ou 2012-12-31
        } elseif (preg_match('/^-?\d{1,6}-\d{2}-\d{2}$/', $this->start) === 1) {

            $isBC = $this->start[0] === '-';
            // documentation http://php.net/ltrim
            $this->start = ltrim($this->start, '-');
            $start = explode('-', $this->start);
            $startYear = ($isBC ? '-' : '') . $start[0];
            $startMonth = $start[1];
            $startDay = $start[2];
        } else {
            var_dump('Start Date (' . (string) $this->start . ') non prise en charge');
        }
        $this->timelineItem->setStartYear($startYear);
        $this->timelineItem->setStartMonth($startMonth);
        $this->timelineItem->setStartDay($startDay);

        if ($this->end !== null) {
            // Match date format like: Sat Dec 31 1149 00:00:00 GMT+0100 (Paris, Madrid)
            if (preg_match('/^\w{3} \w{3} \d{2} -?\d{1,6} \d{2}:\d{2}:\d{2} GMT\+0(100 \(Paris, Madrid\)|200)$/', $this->end) === 1) {
                $end = explode(' ', $this->end);
                $endYear = $end[3];
                $endMonth = $this->convertMonthAsNumber($end[1]);
                $endDay = $end[2];


                // Match date format like: -000426-01-01 ou 2012-12-31
            } elseif (preg_match('/^-?\d{1,6}-\d{2}-\d{2}$/', $this->end) === 1) {

                $isBC = $this->end[0] === '-';
                // documentation http://php.net/ltrim
                $this->end = ltrim($this->end, '-');
                $end = explode('-', $this->end);
                $endYear = ($isBC ? '-' : '') . $end[0];
                $endMonth = $end[1];
                $endDay = $end[2];
            } else {
                var_dump('End Date (' . (string) $this->end . ') non prise en charge');
            }
            $this->timelineItem->setEndYear($endYear);
            $this->timelineItem->setEndMonth($endMonth);
            $this->timelineItem->setEndDay($endDay);
        }
    }

    public function getTimelineItem() {
        return $this->timelineItem;
    }

    public function unadapt($visFriendlyCodes) {
        // Start date
        $startCode = $visFriendlyCodes['start'];
        if ($startCode >= 4) {
            // L'année n'est pas null
            $startCode -= 4;
        } else {
            // Should never append!!!
            // Here, an exception have to be thrown
            $this->timelineItem->setStartYear(null);
        }
        if ($startCode >= 2) {
            // Le mois n'est pas null
            $startCode -= 2;
        } else {
            $this->timelineItem->setStartMonth(null);
        }
        if ($startCode >= 1) {
            // Le mois n'est pas null
            $startCode -= 1;
        } else {
            $this->timelineItem->setStartDay(null);
        }
        // End date
        $endCode = $visFriendlyCodes['end'];
        if ($endCode >= 4) {
            // L'année n'est pas null
            $endCode -= 4;
        } else {
            // Here, an exception have to be thrown
            $this->timelineItem->setEndYear(null);
        }
        if ($endCode >= 2) {
            // Le mois n'est pas null
            $endCode -= 2;
        } else {
            $this->timelineItem->setEndMonth(null);
        }
        if ($endCode >= 1) {
            // Le mois n'est pas null
            $endCode -= 1;
        } else {
            $this->timelineItem->setEndDay(null);
        }
    }

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
