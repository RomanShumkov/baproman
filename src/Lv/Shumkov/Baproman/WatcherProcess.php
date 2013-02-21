<?php
namespace Lv\Shumkov\Baproman;

use Lv\Shumkov\Baproman\ProcessInterface;

class WatcherProcess implements ProcessInterface
{
    protected $process;
    
    protected $shell;
    
    protected $command;
    
    public function __construct(
        ProcessInterface $process,
        Shell $shell,
        ShellCommandStringBuilder $commandStringBuilder,
        $phpExecutablePath
    ) {
        $this->process = $process;
        $this->shell = $shell;
        $this->command = new Watcher(
            $phpExecutablePath,
            $process->getCommand(),
            $commandStringBuilder
        );
    }
    
    public function getName()
    {
        return $this->process->getName();
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
        $this->shell->killProcessesByCommand($this->command);
        
        // waiting for watched command to exit
        // TODO: timeout
        while ($this->shell->isCommandRunning($this->process->getCommand())) {
            sleep(1);
        }
    }
    
    public function isStarted() {
        return $this->shell->isCommandRunning($this->command)
            || $this->shell->isCommandRunning($this->process->getCommand())
        ;
    }
}
