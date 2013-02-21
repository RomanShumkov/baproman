<?php
namespace Lv\Shumkov\Baproman;

use ArrayObject;

class ShellCommandStringBuilder
{
    public function buildCommandString(CommandInterface $command, $escape = true)
    {
        $name = $command->getName();
        $arguments = $command->getArguments();
        $options = $command->getOptions();
        if ($escape) {
            $name = escapeshellcmd($name);
            $arguments = $this->escapeArguments($arguments);
            $options = $this->escapeArguments($options);
        }

        $commandStringParts = array(
            $name,
            $this->buildOptionsString($options),
            $this->buildArgumentsString($arguments),
        );

        $commandString  = join(' ', array_filter($commandStringParts));

        return $commandString;
    }

    protected function buildArgumentsString(ArrayObject $arguments)
    {
        return join(' ', $arguments->getArrayCopy());
    }

    protected function buildOptionsString(ArrayObject $options)
    {
        $result = '';
        foreach ($options as $name => $value) {
            $result .= $name . ' ';
            if ($value !== null && $value !== "''") {
                $result .= $value . ' ';
            }
        }
        $result = substr($result, 0, -1);

        return $result;
    }

    protected function escapeArguments(ArrayObject $arguments)
    {
        return new ArrayObject(array_map('escapeshellarg', $arguments->getArrayCopy()));
    }
}
