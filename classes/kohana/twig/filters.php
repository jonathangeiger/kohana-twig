<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Twig_Filters
{
	/**
	 * Returns a default value if the actual value is empty
	 *
	 * @param string $val 
	 * @param string $default 
	 * @return string
	 * @author Jonathan Geiger
	 */
	public static function default($val, $default = NULL)
	{
		return (empty($val)) ? $default : $val;
	}
	
	/**
	 * Returns num::ordinal with the number prepended
	 *
	 * @param string $number 
	 * @return string
	 * @author Jonathan Geiger
	 */
	public static function ordinal($number)
	{
		return $number.num::ordinal($number);
	}
	
	/**
	 * Returns the time since a particular time
	 *
	 * @param string $older_date 
	 * @param string $newer_date 
	 * @return string
	 * @author Jonathan Geiger
	 */
	public static function timesince($older_date, $newer_date = NULL)
	{
		// array of time period chunks
		$chunks = array(
			array(60 * 60 * 24 * 365 , 'year'),
			array(60 * 60 * 24 * 30 , 'month'),
			array(60 * 60 * 24 * 7, 'week'),
			array(60 * 60 * 24 , 'day'),
			array(60 * 60 , 'hour'),
			array(60 , 'minute'),
		);
		
		// Convert to a unix timestamp
		$older_date = strtotime($older_date);

		// $newer_date will equal false if we want to know the time elapsed between a date and the current time
		// $newer_date will have a value if we want to work out time elapsed between two known dates
		$newer_date = ($newer_date == false) ? time() : strtotime($newer_date);

		// difference in seconds
		$since = $newer_date - $older_date;

		// we only want to output two chunks of time here, eg:
		// x years, xx months
		// x days, xx hours
		// so there's only two bits of calculation below:

		// step one: the first chunk
		for ($i = 0, $j = count($chunks); $i < $j; $i++)
			{
			$seconds = $chunks[$i][0];
			$name = $chunks[$i][1];

			// finding the biggest chunk (if the chunk fits, break)
			if (($count = floor($since / $seconds)) != 0)
			{
				break;
			}
		}

		// set output var
		$output = ($count == 1) ? '1 '.$name : "$count {$name}s";

		// step two: the second chunk
		if ($i + 1 < $j)
			{
			$seconds2 = $chunks[$i + 1][0];
			$name2 = $chunks[$i + 1][1];

			if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0)
			{
				// add to output var
				$output .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
			}
		}

		return $output;
	}
}