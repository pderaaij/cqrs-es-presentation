<?php
namespace CESPres\NLayer\Core\Entities;


/**
 * Class BaseEntity
 * @package CESPres\NLayer\Core\Entities
 */
class BaseEntity implements \JsonSerializable {

    public function populate($entityData) {
        foreach($entityData as $field => $value) {
            if(property_exists($this, $field)) {
                $this->{$field} = $value;
            }
        }
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    function jsonSerialize()
    {
        $result = array();
        foreach($this as $field => $value) {
            $result[$field] = $value;
        }

        return $result;
    }
}