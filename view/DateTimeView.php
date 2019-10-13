<?php

class DateTimeView
{


	public function getWeekDay()
	{
		return date('l');
	}

	public function getDateDay()
	{
		return date('d');
	}

	public function getMonth()
	{
		return date('F');
	}

	public function getYear()
	{
		return date('Y');
	}

	public function getHour()
	{
		return date('G');
	}

	public function getMinute()
	{
		return date('i');
	}

	public function getSecond()
	{
		return date('s');
	}

	public function show()
	{
		date_default_timezone_set('Europe/Stockholm');
		$timeString = '';
		return '<p>' . $timeString . $this->getWeekDay() . ', the ' . $this->getDateDay() . 'th of ' . $this->getMonth() . ' ' . $this->getYear() . ', The time is ' . $this->getHour() . ':' . $this->getMinute() . ':' . $this->getSecond() . '</p>';
	}
}
