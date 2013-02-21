<?php
namespace Lv\Shumkov\Baproman;

use ArrayObject;

class Watcher implements CommandInterface
{
    protected $phpExecutablePath;

    protected $command;

    protected $shellCommandStringBuilder;

    public function __construct(
        $phpExecutablePath,
        CommandInterface $command,
        ShellCommandStringBuilder $shellCommandStringBuilder
    ) {
        $this->phpExecutablePath = $phpExecutablePath;
        $this->command = $command;
        $this->shellCommandStringBuilder = $shellCommandStringBuilder;
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
                "while (1) `%s`;",
                $this->shellCommandStringBuilder->buildCommandString($this->command)
            )
        ));
    }

    public function getCommand()
    {
        return $this->command;
    }
}
