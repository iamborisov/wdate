<?php


namespace App;

/**
 * Class WDate
 * @package App
 */
class WDate
{
    /** @var int|null */
    private $hour = null;

    /** @var int|null */
    private $minute = null;

    /** @var int|null */
    private $second = null;

    /** @var int|null */
    private $day = null;

    /** @var int|null */
    private $month = null;

    /** @var int|null */
    private $year = null;

    /**
     * WDate constructor.
     *
     * @param string|null $date
     */
    public function __construct($date = null)
    {
        if ($date) {
            $this->parse($date);
        }
    }

    /**
     * @param $date
     */
    public function parse($date)
    {
        $h = '[0-2]\d';
        $i = '[0-5]\d';
        $s = '[0-5]\d';
        $d = '[0-3]\d';
        $m = '[01]\d';
        $y = '\d{4}';

        $t = "($h)\:(?:($i)(?:\:($s))?)?";
        $d = "(?:(?:($d)\.)?($m)\.)?($y)";

        $regex = "/(?:$t)?\\s?(?:$d)?/i";

        preg_match_all($regex, $date, $matches);

        $this->setHour($matches[1][0]);
        $this->setMinute($matches[2][0]);
        $this->setSecond($matches[3][0]);
        $this->setDay($matches[4][0]);
        $this->setMonth($matches[5][0]);
        $this->setYear($matches[6][0]);
    }

    /**
     * @param WDate $date
     * @return bool
     */
    public function equals(WDate $date)
    {
        return $this->compare($date) === 0;
    }

    /**
     * Compares two dates.
     * Return values:
     *     -1   $this < $date
     *      0   $this == $date
     *      1   $this > $date
     *  false   comparison is not possible
     *
     * @param WDate $date
     * @return int|false
     */
    public function compare(WDate $date)
    {
        $d1 = $this->toArray();
        $d2 = $date->toArray();

        $comparable = false;

        for ($i = 0; $i < count($d1); $i++) {
            if (!is_null($d1[$i]) && !is_null($d2[$i])) {
                $comparable = true;

                if ($d1[$i] != $d2[$i]) {
                    return $d1[$i] < $d2[$i] ? -1 : 1;
                }
            }
        }

        return $comparable ? 0 : false;
    }

    /**
     * @return int|null
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @param int|null $hour
     */
    public function setHour($hour)
    {
        $this->hour = $this->intval($hour, 0, 23);
    }

    /**
     * @return int|null
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @param int|null $minute
     */
    public function setMinute($minute)
    {
        $this->minute = $this->intval($minute, 0, 59);
    }

    /**
     * @return int|null
     */
    public function getSecond()
    {
        return $this->second;
    }

    /**
     * @param int|null $second
     */
    public function setSecond($second)
    {
        $this->second = $this->intval($second, 0, 59);
    }

    /**
     * @return int|null
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param int|null $day
     */
    public function setDay($day)
    {
        $this->day = $this->intval($day, 1, 31);
    }

    /**
     * @return int|null
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param int|null $month
     */
    public function setMonth($month)
    {
        $this->month = $this->intval($month, 1, 12);
    }

    /**
     * @return int|null
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int|null $year
     */
    public function setYear($year)
    {
        $this->year = is_numeric($year) ? intval($year) : null;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            $this->getYear(),
            $this->getMonth(),
            $this->getDay(),
            $this->getHour(),
            $this->getMinute(),
            $this->getSecond(),
        ];
    }

    /**
     * @param $val
     * @param $min
     * @param $max
     * @return int|null
     */
    private function intval($val, $min, $max) {
        if (is_numeric($val)) {
            $val = intval($val);
            if ($val >= $min && $val <= $max) {
                return $val;
            }
        }

        return null;
    }
}