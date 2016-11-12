<?php

namespace BankReader\Model;

class Transaction
{
    /** @var  \DateTime */
    protected $date;

    /** @var  float */
    protected $amount;

    /** @var  string */
    protected $description;

    /** @var  array */
    protected $keywords;

    /** @var  int */
    protected $category;

    public function __construct()
    {
        $this->date = null;
        $this->amount = null;
        $this->description = null;
        $this->keywords = array();
        $this->category = null;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Transaction
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Transaction
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    public function addKeyword($keyword)
    {
        $this->keywords[] = $keyword;
    }

    /**
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param int $category
     * @return Transaction
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }


}