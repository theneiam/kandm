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

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->employees = [];
    }

    /**
     * @param Human $employee
     */
    public function hire(Human $employee)
    {
        $this->addEmployee($employee);
        $this->notify($employee);
    }

    /**
     * @param Human $employee
     */
    protected function addEmployee(Human $employee)
    {
        $hash = $this->createEmployeeHash($employee);
        $this->employees[$hash] = [
            'name' => $employee->getName(),
            'epn' => $employee->getEmergencyPhoneNumber()
        ];
    }

    /**
     * @param Human $employee
     * @throws \Exception
     */
    public function updateEmployee(Human $employee)
    {
        $hash = $this->createEmployeeHash($employee);

        if (!isset($this->employees[$hash])) {
            throw new \Exception('Employee not found. Nothing to update');
        }

        $oldEmployeeData = $this->employees[$hash];
        $this->addEmployee($employee);
        $this->logEpnChangeMessage($employee, $oldEmployeeData['epn']);
    }

    /**
     * @param Human $employee
     * @param $oldEpn
     */
    protected function logEpnChangeMessage(Human $employee, $oldEpn)
    {
        $msgPattern = '%s %s emergency phone number is: %s';
        $name = $employee->getName();
        $newEpn = $employee->getEmergencyPhoneNumber();
        $this->logger->info(sprintf($msgPattern, $name, 'old', $oldEpn));
        $this->logger->info(sprintf($msgPattern, $name, 'new', $newEpn));
    }

    /**
     * @param Human $employee
     * @return string
     */
    protected function createEmployeeHash(Human $employee)
    {
        return spl_object_hash($employee);
    }

    /**
     * @param Human $employee
     * @throws \Exception
     */
    public function notify(Human $employee)
    {
        $employee->update($this);
    }
}
