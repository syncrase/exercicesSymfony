<?php

// src/Entity/DefaultFormContent.php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/*
 * Protected and private properties can also be validated, as well as "getter" methods
 */

class DefaultFormContent {

    /**
     * @Assert\NotBlank()
     */
    public $task;
    public $blankTask;

    /**
     * @Assert\Type("\DateTime")
     */
    public $dueDate;

}
