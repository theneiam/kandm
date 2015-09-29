<?php
namespace KlausShow\Tests;

use KlausShow\Human;
use KlausShow\HR;
use Monolog\Logger;

class AdventureTest extends \PHPUnit_Framework_TestCase
{
    protected function createKlaus()
    {
        $name = 'Klaus';
        $phoneNumber = '555-777-333';
        return new Human($name, $phoneNumber);
    }

    public function testHumanNameAndPhoneNumberSet()
    {
        $human = $this->createKlaus();
        $this->assertEquals('Klaus', $human->getName());
        $this->assertEquals('555-777-333', $human->getPhoneNumber());
    }

    public function testHumanCanBeHiredByHr()
    {
        $human = $this->createKlaus();
        $employer = new HR(new Logger('HR'));
        $employer->hire($human);

        $this->assertInstanceOf('KlausShow\HR', $human->getEmployer());
    }

    public function testHumansCanMerry()
    {
        $klaus = $this->createKlaus();
        $maria = new Human('Maria', '7777-54321');

        $klaus->merry($maria);

        $this->assertInstanceOf('KlausShow\Human', $klaus->getSpouse());
        $this->assertInstanceOf('KlausShow\Human', $maria->getSpouse());
    }
}
