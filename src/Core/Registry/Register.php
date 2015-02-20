<?php
namespace CESPres\Core\Registry;


class Register {
    static private $register = array();

    public static function register($key, $value) {
        self::$register[$key] = $value;
    }

    public static function get($key) {
        if(array_key_exists($key, self::$register)) {
            return self::$register[$key];
        }

        throw new \InvalidArgumentException("Tried to fetch unknown item from registry");
    }

}