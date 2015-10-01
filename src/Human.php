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

    /**
     * @param Human $human
     */
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
        $this->notify($this->spouse);
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
     * @param Human|HR $subject
     * @throws \Exception
     */
    public function update($subject)
    {
        if ($subject instanceof Human) {
            $this->setSpouse($subject);
            if ($this->employer instanceof HR) {
                $this->employer->updateEmployee($this);
            }
        } elseif ($subject instanceof HR) {
            $this->employer = $subject;
        } else {
            throw new \Exception('Unknown subject instance.');
        }
    }

    /**
     * @param Human $observer
     */
    public function notify(Human $observer)
    {
        $observer->update($this);
    }
}
