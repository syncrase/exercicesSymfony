<?php

namespace App\Adapters;

use App\Adapters\VisTimelineItem;

class VisTimeline {

// Cet objet me permet d'avoir un adapter qui me permet de distinguer l'objet 
// inscrit en base de données et l'objet serialisé à l'utilisation de vis timeline.
// Si je n'utilise pas l'adapter j'obtiens ceci :
//    [{"id":"5acdf9f115c8b92484000df6","content":"Platon","start":"-428,00,00",
//    "visFriendlyStart":"new Date(-428,00,00)","end":"-348,00,00",
//    "visFriendlyEnd":"new Date(-348,00,00)"},{"id":"5acdf9f115c8b92484000df7",
//    "content":"1\u00e8re guerre mondiale","start":"1914,07,28",
//    "visFriendlyStart":"new Date(1914,07,28)","end":"1918,11,11",
//    "visFriendlyEnd":"new Date(1918,11,11)"},{"id":"5acdf9f115c8b92484000df8",
//    "content":"2nde guerre mondiale","start":"1939,09,01","visFriendlyStart":
//    "new Date(1939,09,01)","end":"1945,09,02","visFriendlyEnd":
//    "new Date(1945,09,02)"},{"id":"5acdf9f115c8b92484000df9",
//    "content":"d\u00e9claration Balfour","start":"1917,11,2",
//    "visFriendlyStart":"new Date(1917,11,2)","end":null,"visFriendlyEnd":""}]
//    ...
//    Je pourrais utiliser les groupes pour choisir ce que je veux mais je vais 
//    préférer mutualiser toutes les méthodes relatives a vis timeline dans cet 
//    objet.
//    


    private $items;

    public function createTimeline($evenements) {
        $items = [];
        $id = 1;
        foreach ($evenements as $ev) {
            $item = new VisTimelineItem();
            $item->setId($id++);
            $item->setContent($ev->getContent());
            $item->setStart($ev->getStart());
            $item->setEnd($ev->getEnd());
            $items[] = $item;
        }
        $this->items = $items;
    }

    public function getDataSet() {
        $dataSet = '[';
        foreach ($this->items as $item) {
            $dataSet .= $item->getDataSet();
            $dataSet .= ',';
        }
        //Revome the last coma
        $dataSet = substr($dataSet, 0, -1);
        $dataSet .= ']';
        return $dataSet;
    }

    public function getOption() {
//    start: '2014-01-10',  Calculer la date la plus reculée
//    end: '2014-02-10',    Calculer la date la plus avancée
//    editable: true,
//    showCurrentTime: true
        $options = '';
        $options .= 'editable: true, ';
        $options .= 'showCurrentTime: false';
        return $options;
    }

}
