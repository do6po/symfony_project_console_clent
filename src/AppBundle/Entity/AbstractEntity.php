<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.03.19
 * Time: 12:44
 */

namespace AppBundle\Entity;


abstract class AbstractEntity implements \JsonSerializable
{
    /**
     * @var int
     */
    public $id;

    abstract public function entityName(): string;

    abstract public function jsonSerialize(): array;
}