<?php
namespace Lv\Shumkov\Baproman;

class Shell
{
    protected $shellCommandStringBuilder;
    
    public function __construct(ShellCommandStringBuilder $shellCommandStringBuilder)
    {
        $this->shellCommandStringBuilder = $shellCommandStringBuilder;
    }

    public function runCommand(CommandInterface $command)
    {
        $commandString = sprintf(
            'nohup %s >/dev/null 2>&1 &',
            $this->buildShellCommandString($command)
        );
        return shell_exec($commandString);
    }

    public function isCommandRunning(CommandInterface $command)
    {
        $fullCommandName = $this->buildFullCommandName($command);
        $this->assertNoGrepString($fullCommandName);

        $escapedSearchString = escapeshellarg(preg_quote($fullCommandName));
        return `pgrep -fx $escapedSearchString` !== null;
    }

    public function killProcessesByCommand(CommandInterface $command)
    {
        $fullCommandName = $this->buildFullCommandName($command);
        $this->assertNoGrepString($fullCommandName);

        $escapedSearchString = escapeshellarg(preg_quote($fullCommandName));
        return `pkill -fx $escapedSearchString`;
    }

    protected function buildShellCommandString(CommandInterface $command)
    {
        return $this->shellCommandStringBuilder->buildCommandString($command);
    }

    protected function buildFullCommandName(CommandInterface $command)
    {
        return $this->shellCommandStringBuilder->buildCommandString($command, false);
    }
    
    protected function assertNoGrepString($fullCommandName)
    {
        if (strpos($fullCommandName, 'grep') !== false) {
            throw new Exception(
                'Commands containing "grep" string are not supported yet',
                1361452361
            );
        }
    }
}
