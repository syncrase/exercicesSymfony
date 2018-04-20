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

//    public function setId($id) {
//        $this->id = $id;
//    }

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
     */
    private $startYear;

    /**
     * @MongoDB\Field(type="string")
     */
    private $startMonth;

    /**
     * @MongoDB\Field(type="string")
     */
    private $startDay;

    public function getStartYear() {//: ?string 
        return $this->startYear;
    }

    public function getStartMonth() {//: ?string 
        return $this->startMonth;
    }

    public function getStartDay() {//: ?string 
        return $this->startDay;
    }

    public function setStartYear($startYear) {//: ?string 
        // TODO vérifier qu'il y a 4 ou 6 chiffres
        $this->startYear = $startYear;
    }

    public function setStartMonth($startMonth) {//: ?string 
        // TODO vérifier qu'il y a deux chiffres contenus entre 01 et 12
        $this->startMonth = $startMonth;
    }

    public function setStartDay($startDay) {//: ?string 
        // TODO vérifier qu'il y a deux chiffres contenus entre 01 et 31
        $this->startDay = $startDay;
    }

    /**
     * @MongoDB\Field(type="string")
     */
    private $endYear;

    /**
     * @MongoDB\Field(type="string")
     */
    private $endMonth;

    /**
     * @MongoDB\Field(type="string")
     */
    private $endDay;

    public function getEndYear() {//: ?string 
        return $this->endYear;
    }

    public function getEndMonth() {//: ?string 
        return $this->endMonth;
    }

    public function getEndDay() {//: ?string 
        return $this->endDay;
    }

    public function setEndYear($endYear) {//: ?string 
        // TODO vérifier qu'il y a 4 ou 6 chiffres
        $this->endYear = $endYear;
    }

    public function setEndMonth($endMonth) {//: ?string 
        // TODO vérifier qu'il y a deux chiffres contenus entre 01 et 12
        $this->endMonth = $endMonth;
    }

    public function setEndDay($endDay) {//: ?string 
        // TODO vérifier qu'il y a deux chiffres contenus entre 01 et 31
        $this->endDay = $endDay;
    }

    /**
     * 
     * @return boolean
     */
    public function hasEnd() {
        if (isset($this->endYear) && $this->endYear !== '') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Specific to the used patern. 
     * Parceque l'on utilise plusieurs classe représentant la même mais a des fins différentes
     * on a besoins de pouvoir "changer" de classe pour avoir accès à des méthodes différentes
     * TODO un design patern (Decorator?) serait peut-être une bonne idée!
     * @param type $similarObject
     */
    public function updateFields($similarObject) {
        $this->content = $similarObject->getContent();
        // start date
        $this->startYear = $similarObject->getStartYear();
        $this->startMonth = $similarObject->getStartMonth();
        $this->startDay = $similarObject->getStartDay();
        // end date
        $this->endYear = $similarObject->getEndYear();
        $this->endMonth = $similarObject->getEndMonth();
        $this->endDay = $similarObject->getEndDay();
    }

    public function equals($similarObject) {
        $isEquals = $this->content === $similarObject->getContent() &&
                $this->startYear === $similarObject->getStartYear() &&
                $this->startMonth === $similarObject->getStartMonth() &&
                $this->startDay === $similarObject->getStartDay() &&
                $this->endYear === $similarObject->getEndYear() &&
                $this->endMonth === $similarObject->getEndMonth() &&
                $this->endDay === $similarObject->getEndDay();
        return $isEquals;
    }

}
