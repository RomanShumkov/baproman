<?php
namespace Lv\Shumkov\Baproman;

interface ProcessInterface
{
    public function getName();
    
    public function getCommand();
    
    public function start();
    
    public function stop();
    
    public function isStarted();
}
