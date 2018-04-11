<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

//use Doctrine\ODM\MongoDB\Mapping\Annotations\Date;
/**
 * @MongoDB\Document(repositoryClass="App\Repository\EvenementRepository")
 */
class Evenement {
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
    private $name;

    public function getName() {//: ?string 
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    /**
     * @MongoDB\Field(type="string")
     * format y,m,d
     */
    private $startDate;
    private $startYear, $startMonth, $startDay;

    public function getStartDate() {//: ?string 
        return $this->startDate;
    }

    public function getVisFriendlyStartDate() {//: ?string 
        if (!isset($this->startYear)) {
            $array = explode(',', $this->startDate);
            $this->startYear = $array[0];
            $this->startMonth = $array[1];
            $this->startDay = $array[2];
        }
        return 'new Date(' . $this->startYear . ',' . $this->startMonth . ',' . $this->startDay . ')';
        // Les formats ci-dessous fonctionnetn mais ne permettent pas de gérer des dates négatives
        // 2014-01-01T06:00:00 
        // 01-01-2014 
    }

    public function setStartDate($year, $month = '0', $day = '0'): self {
        $this->startDate = $year . ',' . $month . ',' . $day;
        $this->startYear = $year;
        $this->startMonth = $month;
        $this->startDay = $day;
        return $this;
    }

    /**
     * @MongoDB\Field(type="string")
     * format y,m,d
     */
    private $endDate;
    private $endYear, $endMonth, $endDay;

    public function getEndDate() {//: ?string 
        return $this->endDate;
    }

    public function getVisFriendlyEndDate() {//: ?string 
        if (!isset($this->endYear)) {
            $array = explode(',', $this->endDate);
            $this->endYear = $array[0];
            $this->endMonth = $array[1];
            $this->endDay = $array[2];
        }
        return 'new Date(' . $this->endYear . ',' . $this->endMonth . ',' . $this->endDay . ')';
    }

    /*
     * Unable to set default values directly usable: 
     * https://stackoverflow.com/questions/9166914/using-default-arguments-in-a-function
     */
    public function setEndDate($year, $month = null, $day = null): self {
        if (null === $month) {
            $month = '00';
        }

        if (null === $day) {
            $day = '00';
        }
        $this->endDate = $year . ',' . $month . ',' . $day;
        $this->endYear = $year;
        $this->endMonth = $month;
        $this->endDay = $day;
        return $this;
    }

    /**
     * 
     * @return boolean
     */
    public function hasEnd() {
        if (isset($this->endDate) && $this->endDate !== '') {
            return true;
        } else {
            return false;
        }
    }

}
