<?php

namespace App\Core\VisJS\Timeline;

use App\Core\VisJS\Timeline\VisTimelineItem;

/**
 * This is the dataset generator. 
 * Get data in shape specifically for the vis.js use.
 */
class VisTimeline {

    /**
     * List of get in shape timeline items
     * @var VisTimelineItem[] 
     */
    private $visTimelineItems;

    public function getVisTimelineItems() {
        return $this->visTimelineItems;
    }

    /**
     * Contains all information relative to a timeline item 
     * It's an associative array like
     * 'visId' =>  [
     *          'mongoId' => '',
     *          'notes' => '',
     *          'content' => '',
     *          'startDate' => [
     *              'code' => ''
     *               'year' => ''
     *               'month' => ''
     *               'day' => ''
     *            ],
     *          'endDate' => [
     *              'code' => ''
     *               'year' => ''
     *               'month' => ''
     *               'day' => ''
     *            ],
     *          'action' => 'no'|'create'|'update'|'delete'
     *         ]
     * @var VisTimelineItem[] 
     */
    private $metaTimeline;

    public function getMetaTimeline() {
        return $this->metaTimeline;
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
            $visTimelineItem->setId($id);
            $adaptationCode = $visTimelineItem->adapt($ev);
            $visTimelineItems[] = $visTimelineItem;

            /**
             * FILL META ARRAY
             */
            $this->metaTimeline[$id]['mongoId'] = $ev->getId();
            $this->metaTimeline[$id]['notes'] = $ev->getNotes();
            $this->metaTimeline[$id]['content'] = $ev->getContent();
            
            $this->metaTimeline[$id]['startDate']['code'] = $adaptationCode['startCode'];
            $this->metaTimeline[$id]['startDate']['year'] = $ev->getStartYear();
            $this->metaTimeline[$id]['startDate']['month'] = $ev->getStartMonth();
            $this->metaTimeline[$id]['startDate']['day'] = $ev->getStartDay();
            
            $this->metaTimeline[$id]['endDate']['code'] = $adaptationCode['endCode'];
            $this->metaTimeline[$id]['endDate']['year'] = $ev->getEndYear();
            $this->metaTimeline[$id]['endDate']['month'] = $ev->getEndMonth();
            $this->metaTimeline[$id]['endDate']['day'] = $ev->getEndDay();
            
            $this->metaTimeline[$id]['action'] = 'no';

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
