<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.03.19
 * Time: 12:15
 */

namespace AppBundle\Entity;


class User extends AbstractEntity
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
     * @var string
     */
    public $email;

    public function entityName(): string
    {
        return 'User';
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $result = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if (!is_null($this->id)) {
            $result['id'] = $this->id;
        }

        return $result;
    }
}