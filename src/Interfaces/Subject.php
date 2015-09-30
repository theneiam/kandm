<?php
namespace KlausShow\Interfaces;


interface Subject
{
    public function notify(Observer $observer);
}
