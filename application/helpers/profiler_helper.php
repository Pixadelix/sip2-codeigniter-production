<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (! function_exists('e')) {
	/**
	 * A convenience function to ensure output is safe to display. Helps to
	 * defeat XSS attacks by running the text through htmlspecialchars().
	 *
	 * Should be used anywhere user-submitted text is displayed.
	 *
	 * @param String $str The text to process and output.
	 *
	 * @return void
	 */
	function e($str)
	{
		echo htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
	}
}