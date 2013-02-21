<?php
namespace Lv\Shumkov\Baproman;

use Lv\Shumkov\Baproman\CommandInterface;
use Lv\Shumkov\Baproman\ProcessInterface;
use Lv\Shumkov\Baproman\Shell;

class Process implements ProcessInterface
{
    protected $name;

    protected $command;

    protected $shell;

    public function __construct($name, CommandInterface $command, Shell $shell)
    {
        $this->name = $name;
        $this->command = $command;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getCommand()
    {
        return $this->command;
    }
    
    public function start()
    {
        $this->shell->runCommand($this->command);
    }
    
    public function stop()
    {
        $this->shell->killProcessByCommand($this->command);
    }
    
    public function isStarted() {
        return $this->shell->isCommandRunning($this->command);
    }
}
