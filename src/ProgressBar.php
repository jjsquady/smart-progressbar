<?php
/**
 * Created by PhpStorm.
 * User: rodri
 * Date: 28/04/2017
 * Time: 12:44
 */

namespace Utils;


/**
 * Class ProgressBar
 * @package Utils
 */
Class ProgressBar {


    /**
     * @var
     */
    protected $progress; // 0 - 100

    /**
     * @var int
     */
    protected $maxValue;

    /**
     * @var
     */
    protected $curValue;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    protected $localization = [
        'remaining' => 'remaining',
        'elapsed' => 'elapsed',
        'sec' => 'sec.'
    ];

    /**
     * @var
     */
    private $_bars;

    /**
     * @var
     */
    private $_startTime;

    /**
     * @var
     */
    private $_now;

    /**
     * @var int
     */
    private $_barSize;

    private $_percent;

    /**
     * ProgressBar constructor.
     * @param $maxValue
     * @param string $description
     * @param int $barSize
     * @throws \Exception
     */
    private function __construct($maxValue, $description = '', $barSize = 30)
    {
        if (! is_integer($maxValue)) {
            throw new \Exception("maxValue needs to be an integer.");
        }

        $this->maxValue = $maxValue;

        $this->description = $description;

        $this->_barSize = $barSize;
    }

    /**
     * @param $maxValue
     * @param string $description
     * @param int $barSize
     * @return static
     */
    public static function init($maxValue, $description = '', $barSize = 30)
    {
        $instance = new static($maxValue, $description, $barSize);

        return $instance;
    }

    /**
     * @param array $localization
     * @return $this
     */
    public function localization(array $localization)
    {
        foreach ($localization as $key => $localstring) {
            if (array_key_exists($key, $this->localization)) {
                $this->localization[$key] = $localstring;
            }
        }

        return $this;
    }

    /**
     * @param $curValue
     * @return $this
     */
    public function update($curValue)
    {

        $this->curValue = $this->validateCurrentValue($curValue);

        $this->updateTime();

        return $this;
    }


    /**
     * @param $incrementsIn
     * @return ProgressBar
     */
    public function increments($incrementsIn = 1)
    {
        $this->curValue += $incrementsIn;

        $this->curValue = $this->validateCurrentValue($this->curValue);

        $this->updateTime();

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->_bars = floor(($this->_percent/100) * $this->_barSize);

        return $this->updateBar() . $this->updateValue() . $this->updateEta($this->_now, $this->_startTime);
    }

    /**
     * @return int
     */
    public function getMaxValue()
    {
        return $this->maxValue;
    }

    /**
     * @return mixed
     */
    public function getCurrentValue()
    {
        return $this->curValue;
    }

    public function getProgressPercentage()
    {
        return $this->_percent;
    }

    private function validateCurrentValue($curValue)
    {
        if ($curValue >= $this->maxValue) {
            $curValue = $this->maxValue;
        }

        if ($curValue <= 0) {
            $curValue = 1;
        }

        $this->curValue = $curValue;

        $this->updatePercentage();

        return $this->curValue;
    }

    private function updateTime()
    {
        static $start_time;

        if(empty($start_time)) {
            $start_time = time();
        }

        $this->_startTime = $start_time;

        $this->_now = time();
    }

    private function updatePercentage()
    {
        $this->_percent = intval(($this->curValue / $this->maxValue) * 100);
    }

    /**
     * @return string
     */
    private function updateBar()
    {
        $output = "\r[";

        $output .= str_repeat("=", $this->_bars);

        $output .= ($this->_bars < $this->_barSize) ? ">" : "=";

        $output .= str_repeat(" ", $this->_barSize - $this->_bars);

        $output .= "]";

        return $output;
    }

    /**
     * @return string
     */
    private function updateValue()
    {
        return " ({$this->_percent}%) {$this->curValue}/{$this->maxValue} {$this->description}";
    }

    /**
     * @param $now
     * @param $start_time
     * @return string
     */
    private function updateEta($now, $start_time)
    {
        $elapsed = $now - $start_time;

        $eta = number_format($this->calculateEta($elapsed));

        return " {$this->localization['remaining']}: {$eta} {$this->localization['sec']} {$this->localization['elapsed']}: ". number_format($elapsed) . " {$this->localization['sec']}";
    }

    /**
     * @param $elapsed
     * @return float
     */
    private function calculateEta($elapsed)
    {
        $rate = $elapsed / $this->curValue;

        $left = $this->maxValue - $this->curValue;

        return round($rate * $left, 2);

    }


}