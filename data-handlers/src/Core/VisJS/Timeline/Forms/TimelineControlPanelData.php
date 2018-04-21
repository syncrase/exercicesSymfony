<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Core\VisJS\Timeline\Forms;

/**
 * Description of TimelineControlPanelData
 *
 * @author Pierre
 */
class TimelineControlPanelData {

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

    private $notes;

    public function getNotes() {
        return $this->notes;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
    }

    private $start;

    public function getStart() {
        return $this->start;
    }

    public function getSplitedStart() {
        // TODO is usefull?
        $start = str_replace('new Date(', '', $this->start);
        $start = str_replace(')', '', $start);
        return explode(',', $start);
    }

    /**
     * 
     * @param type $start
     */
    public function setStart($start) {
        // TODO This is a copy paste. MUST BE REIMPLEMENT!!!
        if (strpos($start, ',') !== false) {
            // Dans le cas où la valeur vient de la base de données
            $array = explode(',', $start);
        } elseif (strpos($start, '/') !== false) {
            // Dans le cas où la valeur vient du formulaire
            $array = explode('/', $start);
        } else {
            // Dans le cas où l'on vient du formulaire mais que l'on a renseigné que l'année
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
        // TODO is usefull?
        if ($this->end === '') {
            return null;
        } else {
            $end = str_replace('new Date(', '', $this->end);
            $end = str_replace(')', '', $end);
            return explode(',', $end);
        }
    }

    public function setEnd($end) {
        // This is a copy paste. MUST BE REIMPLEMENT!!!
        if (null === $end) {
            $this->end = '';
        } else {
            if (strpos($end, ',') !== false) {
                // Dans le cas où la valeur vient de la base de données
                $array = explode(',', $end);
            } elseif (strpos($end, '/') !== false) {
                // Dans le cas où la valeur vient du formulaire
                $array = explode('/', $end);
            } else {
                // Dans le cas où l'on vient du formulaire mais que l'on a renseigné que l'année
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

}
