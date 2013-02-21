<?php
namespace Lv\Shumkov\Baproman;

use Lv\Shumkov\Baproman\ProcessInterface;
use ArrayObject;
use Closure;

class ProcessCollection
{
    protected $processes;
    
    public function __construct()
    {
        $this->processes = new ArrayObject();
    }
    
    public function add(ProcessInterface $process)
    {
        $this->processes[$process->getName()] = $process;
    }
    
    public function filterStarted()
    {
        return $this->filterProcesses($this->processes, $this->getStartedProcessPredicate());
    }
    
    public function filterStopped()
    {
        return $this->filterProcesses($this->processes, $this->getStoppedProcessPredicate());
    }
    
    protected function getStartedProcessPredicate()
    {
        return function ($process) {
            return $process->isStarted();
        };
    }
    
    protected function getStoppedProcessPredicate()
    {
        return function ($process) {
            return !$process->isStarted();
        };
    }
    
    /**
     * @param ArrayObject $processes
     * @param Cosure $predicate
     * @return ArrayObject filtered processes
     */
    protected function filterProcesses(ArrayObject $processes, Closure $predicate)
    {
        $result = new ArrayObject();
        foreach ($processes as $process) {
            if ($predicate($process) == true) {
                $result[] = $process;
            }
        }
        
        return $result;
    }
}
