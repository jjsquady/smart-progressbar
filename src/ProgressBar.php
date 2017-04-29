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
use Utils\Support\ProgressBarTimer;
use Utils\Support\ProgressTimer;

/**
 * Class ProgressBar
 * @package Utils
 */
abstract class ProgressBar
{

    /**
     * @var
     */
    protected $progress;

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
        'elapsed'   => 'elapsed',
        'sec'       => 'sec.'
    ];

    /**
     * @var
     */
    protected $bars;

    /**
     * @var
     */
    protected $startTime;

    /**
     * @var
     */
    protected $now;

    /**
     * @var int
     */
    protected $barSize;


    /**
     * @var
     */
    private $percent;
    /**
     * @var ProgressBarTimer
     */
    private $timer;

    /**
     * ProgressBar constructor.
     * @param $maxValue
     * @param string $description
     * @param int $barSize
     * @param ProgressTimer|null $timer
     * @throws \Exception
     */
    private function __construct($maxValue, $description = '', $barSize = 30, ProgressTimer $timer = null)
    {
        if (!is_integer($maxValue)) {
            throw new \Exception("maxValue needs to be an integer.");
        }

        $this->maxValue = $maxValue;

        $this->description = $description;

        $this->barSize = $barSize;

        $this->timer = $this->makeTimer($timer);
    }

    /**
     * @param $maxValue
     * @param string $description
     * @param int $barSize
     * @param ProgressTimer $timer
     * @return static
     */
    public static function init($maxValue, $description = '', $barSize = 30, ProgressTimer $timer = null)
    {
        $instance = new static($maxValue, $description, $barSize, $timer);

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

        $this->timer->update();

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

        $this->timer->update();

        return $this;
    }

    /**
     * @return string
     */
    abstract public function render();

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

    /**
     * @return mixed
     */
    public function getProgressPercentage()
    {
        return $this->percent;
    }

    /**
     *
     */
    protected function updatePercentage()
    {
        $this->percent = intval(($this->curValue / $this->maxValue) * 100);
    }

    /**
     * @return string
     */
    protected function displayBar()
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
    protected function displayProgress()
    {
        return " ({$this->percent}%) {$this->curValue}/{$this->maxValue} {$this->description}";
    }


    /**
     * @return string
     */
    protected function displayEta()
    {
        $output = " {$this->localization['remaining']}: ";

        $eta = number_format($this->timer->remaining($this->curValue));

        $output .= "{$eta} {$this->localization['sec']} ";

        $output .= "{$this->localization['elapsed']}: " . number_format($this->timer->elapsed());

        $output .= " {$this->localization['sec']}";

        return $output;
    }

    protected function makeTimer(ProgressTimer $timer = null)
    {
        if (isset($timer)) {
            return $timer;
        }

        return new ProgressBarTimer($this->maxValue);
    }

    /**
     * @param $curValue
     * @return int
     */
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

}