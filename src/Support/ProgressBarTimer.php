<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 29/04/2017
 * Time: 09:47
 */

namespace Utils\Support;


/**
 * Class ProgressBarTimer
 * @package Utils\Support
 */
class ProgressBarTimer implements ProgressTimer
{
    private $startTime;
    private $now;
    /**
     * @var
     */
    private $from;
    /**
     * @var
     */
    private $to;

    /**
     * ProgressBarTimer constructor.
     * @param $to
     */
    public function __construct($to)
    {
        $this->to = $to;
    }

    /**
     *
     */
    public function update()
    {
        static $_startTime;

        if (empty($_startTime)) {
            $_startTime = time();
        }

        $this->startTime = $_startTime;

        $this->now = time();
    }

    /**
     * @param float|int $from
     * @return double
     */
    public function remaining($from)
    {
        $this->from = $from;

        $rate = $this->elapsed() / $this->from;

        $left = $this->to - $this->from;

        return (double) $rate * $left;
    }


    /**
     * @return double
     */
    public function elapsed()
    {
        return (double) $this->now - $this->startTime;
    }

}