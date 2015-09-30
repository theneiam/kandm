<?php
namespace KlausShow;

use KlausShow\Interfaces\Employer;
use KlausShow\Interfaces\Observer;
use KlausShow\Interfaces\Subject;
use KlausShow\Interfaces\Employee;

class Human implements Observer, Subject, Employee
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
     * @var null|Human
     */
    protected $spouse = null;

    /**
     * @var null|Employer
     */
    protected $employer = null;

    public function __construct($name, $phoneNumber)
    {
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
        $this->spouse = null;
    }

    public function merry(Human $human)
    {
        $this->setSpouse($human);
        $human->setSpouse($this);
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        if ($this->spouse instanceof Human) {
            $this->notify($this->spouse);
        }
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @return Human|null
     */
    public function getSpouse()
    {
        return $this->spouse;
    }

    /**
     * @param Human|null $spouse
     */
    public function setSpouse(Human $spouse)
    {
        $this->spouse = $spouse;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmergencyPhoneNumber()
    {
        if ($this->spouse === null) {
            return '';
        }
        return $this->spouse->getPhoneNumber();
    }

    /**
     * @param Subject $subject
     */
    public function update(Subject $subject)
    {
        if ($subject instanceof Employer) {
            $this->employer = $subject;
        } else {
            $this->setSpouse($subject);
            if ($this->employer instanceof Employer) {
                $this->employer->updateEmployee($this);
            }
        }
    }

    /**
     * @param Observer $observer
     */
    public function notify(Observer $observer)
    {
        $observer->update($this);
    }
}
