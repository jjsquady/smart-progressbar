<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 29/04/2017
 * Time: 08:50
 */

namespace Utils;

class ConsoleProgressBar extends ProgressBar
{
    public function render()
    {
        return $this->displayBar() . $this->displayProgress() . $this->displayEta();
    }
}