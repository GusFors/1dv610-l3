<?php

class Date
{   
    private static $standardTimeZone = 'Europe/Stockholm';

    public function __construct()
    {
        $this->setTimeZone(self::$standardTimeZone);
    }

    public function getWeekDay(): string
    {
        return date('l');
    }

    public function getDateDay(): string
    {
        return date('d');
    }

    public function getMonth(): string
    {
        return date('F');
    }

    public function getYear(): string
    {
        return date('Y');
    }

    public function getHour(): string
    {
        return date('G');
    }

    public function getMinute(): string
    {
        return date('i');
    }

    public function getSecond(): string
    {
        return date('s');
    }

    public function setTimeZone(string $timezone)
    {
        date_default_timezone_set($timezone);
    }
}
