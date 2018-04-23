<?php

namespace App\Core\VisJS\Timeline;

use App\Core\VisJS\Timeline\VisTimelineItem;

/**
 * This is the dataset generator. 
 * Formate data specifically for the vis.js use.
 */
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

    /**
     *
     * @var array[visId][mongoId]
     */
    private $visFriendlyIds = [];

    public function getVisFriendlyIds() {
        return $this->visFriendlyIds;
    }

    /**
     * 
     * @var array[visId][initialDateFormatCode]
     */
    private $visFriendlyDates = [];

    public function getVisFriendlyDates() {
        return $this->visFriendlyDates;
    }

    private $visTimelineItems;

    public function getVisTimelineItems() {
        return $this->visTimelineItems;
    }

    /**
     * Récupère les informations reçues du document Mongo et les formate pour
     * leur utilisation par vis.js
     * @param TimelineItem[] $evenements
     */
    public function initTimeline($evenements) {
        $visTimelineItems = [];
        $id = 1;
        foreach ($evenements as $ev) {
            $visTimelineItem = new VisTimelineItem();
            $this->visFriendlyDates[$id] = $visTimelineItem->adapt($ev);
            $visTimelineItem->setId($id);
            $visTimelineItems[] = $visTimelineItem;

            // Fill associative array
            $this->visFriendlyIds[$id] = $ev->getId();
            $id++;
        }
        $this->visTimelineItems = $visTimelineItems;
    }

    /**
     * 
     * @return string à donner en paramètre au constructeur JavaScript 
     * vis.DataSet({{ getDataSet() }})
     */
    public function getDataSet() {
        $dataSet = '[';
        foreach ($this->visTimelineItems as $item) {
            $dataSet .= $item->getDataSet();
            $dataSet .= ',';
        }
        //Remove the last coma
        $dataSet = substr($dataSet, 0, -1);
        $dataSet .= ']';
        return $dataSet;
    }

    /**
     * 
     * @return string Les options de la timeline
     */
    public function getOption() {
//    start: '2014-01-10',  Calculer la date la plus reculée
//    end: '2014-02-10',    Calculer la date la plus avancée
//    editable: true,
//    showCurrentTime: true
        $options = '';
        // add: true,         // add new items by double tapping
        // updateTime: true,  // drag items horizontally
        // updateGroup: true, // drag items from one group to another
        // remove: true,       // delete an item by tapping the delete button top right
        // overrideItems: false  // allow these options to override item.editable
        $options .= 'editable: { add: false, updateTime: false, remove: true }, ';
        // L'utilisateur doit cliquer sur la timeline pour pouvoir l'utiliser
        $options .= 'clickToUse: true, ';
//        $options .= 'onInitialDrawComplete: function() { logEvent(\'Timeline initial draw completed\', {}); }, ';
        // N'affiche pas la date d'aujourd'hui
        $options .= 'showCurrentTime: false';
        return $options;
    }

}
