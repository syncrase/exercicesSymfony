<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

//use Doctrine\ODM\MongoDB\Mapping\Annotations\Date;
/**
 * @MongoDB\Document(repositoryClass="App\Repository\TimelineItemRepository")
 */
class TimelineItem {
    /*
     * TODO pour l'instant j'hardcode les champs mais il faudra voir pour 
     * n'avoir qu'un champs fields contenant tous les champs et un autre 
     * fichier (ou db) fournissant les intitulés des champs
     * !!! Mettre les dates en format date et pas String
     */

    /**
     * @MongoDB\Id
     * @ ORM\GeneratedValue()
     * @ ORM\Column(type="integer")
     */
    private $id;

    public function getId() {
        return $this->id;
    }

    /**
     * @MongoDB\Field(type="string")
     */
    private $content;

    public function getContent() {//: ?string 
        return $this->content;
    }

    public function setContent(string $name): self {
        $this->content = $name;

        return $this;
    }

    /**
     * @MongoDB\Field(type="string")
     * format y,m,d
     */
    private $start;

//    private $startYear, $startMonth, $startDay;

    public function getStart() {//: ?string 
        return $this->start;
    }

    /**
     * 
     * @param string $year
     * @param string $month
     * @param string $day
     * @return \self
     */
    public function setStart($year, $month = null, $day = null): self {
        if (null === $month) {
            $month = '00';
        }
        if (null === $day) {
            $day = '00';
        }
//        preg_match('/-?[0-9]+/', $year);
        $this->start = $year . ',' . $month . ',' . $day;
//        $this->startYear = $year;
//        $this->startMonth = $month;
//        $this->startDay = $day;
        return $this;
    }

    /**
     * @MongoDB\Field(type="string")
     * format y,m,d
     */
    private $end;

//    private $endYear, $endMonth, $endDay;

    public function getEnd() {//: ?string 
        return $this->end;
    }

    /*
     * Unable to set default values directly usable: 
     * https://stackoverflow.com/questions/9166914/using-default-arguments-in-a-function
     */

    public function setEnd($year, $month = null, $day = null): self {
        if (null === $month) {
            $month = '00';
        }
        if (null === $day) {
            $day = '00';
        }

        $this->end = $year . ',' . $month . ',' . $day;
//        $this->endYear = $year;
//        $this->endMonth = $month;
//        $this->endDay = $day;
        return $this;
    }

    /**
     * 
     * @return boolean
     */
    public function hasEnd() {
        if (isset($this->end) && $this->end !== '') {
            return true;
        } else {
            return false;
        }
    }

    
    public function equalize($similarObject){
        $this->id = $similarObject->getId();
        $this->content = $similarObject->getContent();
        $this->start = $similarObject->getStart();
        $this->end = $similarObject->getEnd();
    }
}
