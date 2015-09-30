<?php

namespace KlausShow\Interfaces;


interface Employer
{
    public function hire(Employee $employee);
    public function updateEmployee(Employee $employee);
    public function isEmployed(Employee $employee);
}
