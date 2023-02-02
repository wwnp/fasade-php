<?php
class DaDataClient
{
    protected string $token;
    protected string $secret;
    public function __construct(string $token, string $secret)
    {
        $this->token = $token;
        $this->secret = $secret;
    }

    public static function clean($address)
    {
        var_dump($address);
    }
}
class Container
{
    public static $instance = null;
    public $resources = [];

    public static function getInstance(): static
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function add($classname, $obj)
    {
        $this->resources[$classname] = $obj;
    }
    public function has($classname)
    {
        return isset($this->resources[$classname]);
    }
    public function get($classname)
    {
        return $this->resources[$classname];
    }
}

class DaData
{
    public static function init()
    {
        if (!Container::getInstance()->has(DaDataClient::class)) {
            $token = "";
            $secret = "";
            $daData = new DaDataClient($token, $secret);
            Container::getInstance()->add(DaDataClient::class, $daData);
        }
        return Container::getInstance()->get(DaDataClient::class);
    }

    public static function __callStatic($name, $arguments)
    {
        $object = self::init();
        return $object->$name($arguments);
    }
}
DaData::clean("asdasd");
