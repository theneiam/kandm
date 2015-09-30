<?php
namespace KlausShow\Interfaces;


interface Observer
{
    public function update(Subject $subject);
}
