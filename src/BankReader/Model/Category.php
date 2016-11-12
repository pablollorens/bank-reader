<?php

namespace BankReader\Model;

class Category
{
    /** @var string  */
    protected $name;

    /** @var int */
    protected $id;

    /** @var array */
    protected $keywords;

    public function __construct()
    {
        $this->name = null;
        $this->id = null;
        $this->keywords = array();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Category
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param array $keywords
     * @return Category
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
        return $this;
    }


}