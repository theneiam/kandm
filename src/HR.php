<?php
namespace KlausShow;

use Psr\Log\LoggerInterface;
use KlausShow\Interfaces\Employee;
use KlausShow\Interfaces\Subject;
use KlausShow\Interfaces\Employer;
use KlausShow\Interfaces\Observer;

class HR implements Subject, Employer
{
    /**
     * @var Employee[]
     */
    protected $employees = [];

    /**
     * @var null|LoggerInterface
     */
    protected $logger = null;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->employees = [];
    }

    /**
     * @param Employee $employee
     */
    public function hire(Employee $employee)
    {
        $this->addEmployee($employee);
        $this->notify($employee);
    }

    /**
     * @param Employee $employee
     * @return bool
     */
    public function isEmployed(Employee $employee)
    {
        $hash = $this->createUniqueHash($employee);
        return isset($this->employees[$hash]);
    }

    /**
     * @param Employee $employee
     * @throws \Exception
     */
    public function updateEmployee(Employee $employee)
    {
        $hash = $this->createUniqueHash($employee);
        if (!isset($this->employees[$hash])) {
            throw new \Exception('Employee not found. Nothing to update');
        }
        $oldEmployeeData = $this->employees[$hash];
        $this->addEmployee($employee);
        $this->logEpnChangeMessage($employee, $oldEmployeeData['epn']);
    }

    /**
     * @param Employee $employee
     * @param $oldEpn
     */
    protected function logEpnChangeMessage(Employee $employee, $oldEpn)
    {
        $msgPattern = '%s %s emergency phone number is: %s';
        $name = $employee->getName();
        $newEpn = $employee->getEmergencyPhoneNumber();
        $this->logger->info(sprintf($msgPattern, $name, 'old', $oldEpn));
        $this->logger->info(sprintf($msgPattern, $name, 'new', $newEpn));
    }

    /**
     * @param Observer $observer
     */
    public function notify(Observer $observer)
    {
        $observer->update($this);
    }

    /**
     * @param Employee $employee
     * @return string
     */
    protected function createUniqueHash(Employee $employee)
    {
        $hashFields = [
            'name' => $employee->getName()
        ];

        return md5(implode('.', $hashFields));
    }

    /**
     * @param Employee $employee
     */
    protected function addEmployee(Employee $employee)
    {
        $hash = $this->createUniqueHash($employee);
        $this->employees[$hash] = [
            'name' => $employee->getName(),
            'epn' => $employee->getEmergencyPhoneNumber()
        ];
    }
}
