<?php
namespace Lv\Shumkov\Baproman;

use ArrayObject;

class Watcher implements CommandInterface
{
    protected $phpExecutablePath;

    protected $command;

    protected $shellCommandStringBuilder;

    protected $secondsToSleepBeforeRestart;

    public function __construct(
        $phpExecutablePath,
        CommandInterface $command,
        ShellCommandStringBuilder $shellCommandStringBuilder,
        $secondsToSleepBeforeRestart
    ) {
        $this->phpExecutablePath = $phpExecutablePath;
        $this->command = $command;
        $this->shellCommandStringBuilder = $shellCommandStringBuilder;
        $this->secondsToSleepBeforeRestart = $secondsToSleepBeforeRestart;
    }

    public function getName()
    {
        return $this->phpExecutablePath;
    }

    public function getArguments()
    {
        return new ArrayObject();
    }

    public function getOptions()
    {
        return new ArrayObject(array(
            '-r' => sprintf(
                "while (1) { `%s`; sleep(%s); }",
                $this->shellCommandStringBuilder->buildCommandString($this->command),
                $this->secondsToSleepBeforeRestart
            )
        ));
    }

    public function getCommand()
    {
        return $this->command;
    }
}
