<?php

namespace Flowee\Core;

final class Timer {
  public static function exec() {
    $consoleTimer = date('H:i:s');
    return "[$consoleTimer]: ";
	}

	public static function fileTime(){
		$name = date('YmdHis') . md5(time());
		return $name;
	}
}
