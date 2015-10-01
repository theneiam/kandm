<?php
namespace KlausShow\Tests;

use KlausShow\Human;
use KlausShow\HR;
use Monolog\Logger;

class AdventureTest extends \PHPUnit_Framework_TestCase
{
    public function testWholeStory()
    {
        $klaus = new Human('Klaus', '555-5555');
        $maria = new Human('Maria', '777-7777');
        $hr = new HR(new Logger('HR'));

        $hr->hire($klaus);
        $klaus->merry($maria);

        $maria->setPhoneNumber('888-8888');
        $this->assertEquals('888-8888', $klaus->getEmergencyPhoneNumber());

        $maria->setPhoneNumber('999-9999');
        $this->assertEquals('999-9999', $klaus->getEmergencyPhoneNumber());
    }
}
