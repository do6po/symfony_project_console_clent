<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 28.03.19
 * Time: 12:20
 */

namespace AppBundle\Entity;


class Group implements \JsonSerializable
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