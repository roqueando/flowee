<?php

namespace Flowee\Core;

/**
 * Timer for print correct and formatted time
 * @author Vítor Roque
 */
final class Timer {

  /**
   * Print the correct and formatted time on flowee log
   * @return string
   */
  public static function exec(): string {
    $consoleTimer = date('H:i:s');
    return "[$consoleTimer]: ";
	}

  /**
   * Print a timer for the saved log file
   * @return string
   */
	public static function fileTime(): string {
		$name = date('YmdHis');
		return $name;
	}
}
