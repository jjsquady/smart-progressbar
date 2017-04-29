<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 29/04/2017
 * Time: 10:40
 */

namespace Utils;


use Utils\Support\ProgressTimer;

interface ProgressBarInterface
{
    public static function init($maxValue, $description = '', $barSize = 30, ProgressTimer $timer = null);

    public function localization(array $localization);

    public function update($curValue);

    public function increments($incrementsIn = 1);

    public function render();

    public function getMaxValue();

    public function getCurrentValue();

    public function getProgressPercentage();
}