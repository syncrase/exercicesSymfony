<?php

namespace App\Adapters;

class VisTimelineItem {

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

    public function getSplitedStart() {
        $start = str_replace('new Date(', '', $this->start);
        $start = str_replace(')', '', $start);
        return explode(',', $start);
    }

    public function setStart($start) {
        if (strpos($start, ',') !== false) {
            // Dans le cas où la valeur vient de la base de données
            $array = explode(',', $start);
        } elseif (strpos($start, '/') !== false) {
            // Dans le cas où la valeur vient du formulaire
            $array = explode('/', $start);
        } else {
            // Dans le cas où l'on vient du formulaire et que l'on a renseigné que l'année
            $array[] = $start;
        }

        if (count($array) === 3) {
            $this->start = 'new Date(' . $array[0] . ',' . $array[1] . ',' . $array[2] . ')';
        } elseif (count($array) === 1) {
            $this->start = 'new Date(' . $array[0] . ',00,00)';
        } else {
            //throw exception
        }
    }

    private $end;

    public function getEnd() {
        return $this->end;
    }

    public function getSplitedEnd() {
        if ($this->end === '') {
            return null;
        } else {
            $end = str_replace('new Date(', '', $this->end);
            $end = str_replace(')', '', $end);
            return explode(',', $end);
        }
    }

    public function setEnd($end) {
        if (null === $end) {
            $this->end = '';
        } else {
            if (strpos($end, ',') !== false) {
                // Dans le cas où la valeur vient de la base de données
                $array = explode(',', $end);
            }
            if (strpos($end, '/') !== false) {
                // Dans le cas où la valeur vient du formulaire
                $array = explode('/', $end);
            } else {
                // Dans le cas où l'on vient du formulaire et que l'on a renseigné que l'année
                $array[] = $end;
            }

            if (count($array) === 3) {
                $this->end = 'new Date(' . $array[0] . ',' . $array[1] . ',' . $array[2] . ')';
            } elseif (count($array) === 1) {
                $this->end = 'new Date(' . $array[0] . ',00,00)';
            } else {
                //throw exception
            }
        }
    }

    public function getDataSet() {
//        Retourne une information de type
//        [{id: 1, content: 'Platon', start: new Date(-428,00,00), end:new Date(-348,00,00)},
//        {id: 2, content: '1ère guerre mondiale', start: new Date(1914,07,28), end:new Date(1918,11,11)},
//        {id: 3, content: '2nde guerre mondiale', start: new Date(1939,09,01), end:new Date(1945,09,02)},
//        {id: 4, content: 'déclaration Balfour', start: new Date(1917,11,2)}] 
//        Cette information est censée être traitée par du Javascript
        $dataSet = '';
        $dataSet .= '{'
                . 'id: ' . $this->id
                . ', content: \'' . $this->content . '\''
                . ', start: ' . $this->start;
        if (null !== $this->end && '' !== $this->end) {
            $dataSet .= ', end:' . $this->end;
        }
        $dataSet .= '}';
        return $dataSet;
    }

}
