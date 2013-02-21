<?php
namespace Lv\Shumkov\Baproman;

use Lv\Shumkov\Baproman\Command;
use Lv\Shumkov\Baproman\Process;
use Lv\Shumkov\Baproman\WatcherProcess;
use Lv\Shumkov\Baproman\ShellCommandStringBuilder;
use ArrayObject;

class ProcessManager
{
    protected $commandStringBuilder;
    
    protected $shell;
    
    protected $phpExecutablePath;
    
    protected $processes;
    
    public function __construct($phpExecutablePath)
    {
        $this->commandStringBuilder = new ShellCommandStringBuilder();
        $this->shell = new Shell($this->commandStringBuilder);
        $this->phpExecutablePath = $phpExecutablePath;
        $this->processes = new ProcessCollection();
    }
    
    public function addProcess(
        $processName,
        $commandName,
        $commandArguments = array(),
        $commandOptions = array()
    ) {
        $command = new Command(
            $commandName,
            new ArrayObject($commandArguments),
            new ArrayObject($commandOptions)
        );
        
        $process = new Process($processName, $command, $this->shell);
        
        $watcherProcess = new WatcherProcess(
            $process,
            $this->shell,
            $this->commandStringBuilder,
            $this->phpExecutablePath
        );
        
        $this->processes->add($watcherProcess);
    }
    
    public function stopAllProcesses()
    {
        foreach ($this->processes->filterStarted() as $process) {
            $process->stop();
        }
    }
    
    public function startAllProcesses()
    {
        foreach ($this->processes->filterStopped() as $process) {
            $process->start();
        }
    }
    
    public function getStartedProcesses()
    {
        return $this->processes->filterStarted();
    }
}
