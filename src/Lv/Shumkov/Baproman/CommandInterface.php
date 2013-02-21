<?php
namespace Lv\Shumkov\Baproman;

/**
 * @author Roman Shumkov <roman@shumkov.lv>
 */
interface CommandInterface
{
    public function getName();

    public function getArguments();

    public function getOptions();
}
