<?php

namespace BankReader\Core;

class Container
{
    protected $services;

    public function __construct()
    {
        $this->services = array();
    }

    public function addService($name, $value)
    {
        $this->services[$name] = $value;
    }

    public function getService($name)
    {
        if (isset($this->services[$name])) {
            return $this->services[$name];
        } else {
            throw new \Exception("Service doesn't exist: " . $name);
        }
    }

    public function __call($name, $arguments)
    {
        $prefix = substr($name, 0, 3);

        if ($prefix == 'get') {
            $serviceName = substr($name, 3, strlen($name));

            try {
                $service = $this->getService(strtolower($serviceName));

                return $service;

            } catch (\Exception $exception) {
                throw new \Exception($exception->getMessage());
            }
        }
    }
}
