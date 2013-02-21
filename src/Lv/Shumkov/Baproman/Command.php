<?php
namespace Lv\Shumkov\Baproman;

use ArrayObject;

/**
 * @author Roman Shumkov <roman@shumkov.lv>
 */
class Command implements CommandInterface
{
    protected $name;

    protected $arguments;

    protected $options;

    public function __construct(
        $name,
        ArrayObject $arguments = null,
        ArrayObject $options = null
    ) {
        $this->name = $name;
        $this->arguments = is_null($arguments) ? new ArrayObject() : clone $arguments;
        $this->options = is_null($options) ? new ArrayObject() : clone $options;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getArguments()
    {
        return clone $this->arguments;
    }

    public function getOptions()
    {
        return clone $this->options;
    }
}
