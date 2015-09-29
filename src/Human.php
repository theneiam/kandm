<?php

namespace KlausShow;

class Human
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $phoneNumber = '';

    /**
     * @var Human
     */
    protected $spouse = null;

    /**
     * @var HR
     */
    protected $employer = null;

    public function __construct($name, $phoneNumber)
    {
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
        $this->spouse = null;
        $this->employer = null;
    }

    /**
     * @param Human $spouse
     */
    public function setSpouse(Human $spouse)
    {
        $this->spouse = clone $spouse;
    }

    /**
     * @return null|Human
     */
    public function getSpouse()
    {
        return $this->spouse;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        $this->spouse->notify($this);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * @param Human $human
     */
    public function merry(Human $human)
    {
        $this->setSpouse($human);
        $human->setSpouse($this);
    }

    public function notify($observable)
    {
        if ($observable instanceof Human) {
            if ($this->employer === null) {
                throw new \Exception('Go find a job!');
            }
            $this->setSpouse($observable);
            $this->employer->employeeUpdate($this);
        }

        if ($observable instanceof HR) {
            $this->employer = $observable;
        }
    }
}
