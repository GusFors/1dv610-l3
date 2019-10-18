<?php

class DateTimeView
{
	private $dateObj;

	public function __construct(Date $dateObj)
	{
		$this->dateObj = $dateObj;
	}

	public function show(): string
	{
		$timeString = '';
		return '<p>' . $timeString . $this->dateObj->getWeekDay() . ', the ' . $this->dateObj->getDateDay() . 'th of ' . $this->dateObj->getMonth() . ' ' . $this->dateObj->getYear() . ', The time is ' . $this->dateObj->getHour() . ':' . $this->dateObj->getMinute() . ':' . $this->dateObj->getSecond() . '</p>';
	}
}
