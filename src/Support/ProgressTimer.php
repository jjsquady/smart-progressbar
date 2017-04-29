<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 29/04/2017
 * Time: 09:41
 */

namespace Utils\Support;


/**
 * Interface ProgressTimer
 * @package Utils\Support
 */
interface ProgressTimer
{

    /**
     * ProgressTimer constructor.
     * @param $to
     */
    function __construct($to);

    /**
     * @return void
     */
    public function update();

    /**
     * @param $from int|float|double
     * @return double
     */
    public function remaining($from);

    /**
     * @return double
     */
    public function elapsed();
}