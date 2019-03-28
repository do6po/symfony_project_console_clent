<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.03.19
 * Time: 12:20
 */

namespace AppBundle\Entity;


class Group extends AbstractEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var User[]
     */
    public $user = [];

    public function entityName(): string
    {
        return 'Group';
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}