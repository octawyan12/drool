<?php

namespace Drool\CurrencyBundle\Document;

/**
 * Drool\CurrencyBundle\Document\Currency
 */
class Currency
{
    /**
     * @var MongoId $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var float $value
     */
    protected $value;

    /**
     * @var string $short_name
     */
    protected $short_name;

    /**
     * @var boolean $is_virtual
     */
    protected $is_virtual = false;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param float $value
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get value
     *
     * @return float $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set short_name
     *
     * @param string $shortName
     * @return self
     */
    public function setShortName($shortName)
    {
        $this->short_name = $shortName;
        return $this;
    }

    /**
     * Get short_name
     *
     * @return string $shortName
     */
    public function getShortName()
    {
        return $this->short_name;
    }

    /**
     * Set is_virtual
     *
     * @param boolean $isVirtual
     * @return self
     */
    public function setIsVirtual($isVirtual)
    {
        $this->is_virtual = $isVirtual;
        return $this;
    }

    /**
     * Get is_virtual
     *
     * @return boolean $isVirtual
     */
    public function getIsVirtual()
    {
        return $this->is_virtual;
    }
    
    public function __toString() {
        return $this->name . ' (' . $this->short_name . ')';
    }
}
