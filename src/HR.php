<?php
namespace KlausShow;

use Psr\Log\LoggerInterface;

class HR
{
    /**
     * @var Human[]
     */
    protected $employees = [];

    /**
     * @var null|LoggerInterface
     */
    protected $logger = null;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Human $employee
     */
    public function hire(Human $employee)
    {
        $uniqueHash = $this->getEmployeeUniqueHash($employee);
        $this->setEmployee($employee, $uniqueHash);
        $employee->notify($this);
    }

    /**
     * @param Human $employee
     * @return string
     */
    protected function getEmployeeUniqueHash(Human $employee)
    {
        $hashFields = [
            $employee->getName(),
            $employee->getPhoneNumber()
        ];
        return md5(implode('.', $hashFields));
    }

    /**
     * @param Human $employee
     * @param $uniqueHash
     */
    protected function setEmployee(Human $employee, $uniqueHash)
    {
        $this->employees[$uniqueHash] = clone $employee;
    }

    /**
     * @param Human $employee
     */
    public function employeeUpdate(Human $employee)
    {
        $uniqueHash = $this->getEmployeeUniqueHash($employee);
        $currentEmployee = $this->employees[$uniqueHash];
        $this->setEmployee($employee, $uniqueHash);

        if ($currentEmployee->getSpouse() === null) {
            $this->logger->info($currentEmployee->getName() . ' had no emergency phone number before');
        } else {
            $this->logger->info(
                'Old ' . $currentEmployee->getName() . ' emergency phone number was ' .
                $currentEmployee->getSpouse()->getPhoneNumber()
            );
        }
        $this->logger->info(
            'New ' . $currentEmployee->getName() . ' emergency phone number is ' .
            $employee->getSpouse()->getPhoneNumber()
        );
    }
}
