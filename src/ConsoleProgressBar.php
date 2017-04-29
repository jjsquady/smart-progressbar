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

    /**
     * @return string
     */
    private function displayBar()
    {
        $this->bars = floor(($this->percent / 100) * $this->barSize);

        $output = "\r[";

        $output .= str_repeat("=", $this->bars);

        $output .= ($this->bars < $this->barSize) ? ">" : "=";

        $output .= str_repeat(" ", $this->barSize - $this->bars);

        $output .= "]";

        return $output;
    }

    /**
     * @return string
     */
    private function displayProgress()
    {
        return " ({$this->percent}%) {$this->curValue}/{$this->maxValue} {$this->description}";
    }

    /**
     * @return string
     */
    private function displayEta()
    {
        $output = " {$this->localization['remaining']}: ";

        $eta = number_format($this->timer->remaining($this->curValue));

        $output .= "{$eta} {$this->localization['sec']} ";

        $output .= "{$this->localization['elapsed']}: " . number_format($this->timer->elapsed());

        $output .= " {$this->localization['sec']}";

        return $output;
    }
}