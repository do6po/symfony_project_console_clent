<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.03.19
 * Time: 12:15
 */

namespace AppBundle\Entity;


class User implements \JsonSerializable
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

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
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