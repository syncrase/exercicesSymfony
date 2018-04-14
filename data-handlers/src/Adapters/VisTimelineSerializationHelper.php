<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Adapters;

/**
 * Description of VisTimelineSerializationHelper
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
        
        var_dump($content);
    }

    private $start;

    public function getStart() {
        return $this->start;
    }

//    public function getSplitedStart() {
//        
//    }

    public function setStart($start) {
        $this->start = $start;
//        var_dump(gettype($start));
//        $d = strtotime($start);
//        return $d && $d->format($format) == $date;
//        $date = date_parse($start);
        var_dump($start);
    }

    private $end;

    public function getEnd() {
        return $this->end;
    }

//    public function getSplitedEnd() {
//        
//    }

    public function setEnd($end) {
        $this->end = $end;
        var_dump($end);
    }

}
