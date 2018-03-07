<?php

class Lannister
{
	public function	sleepWith($person) {
		$person = get_class($person);

		if (!isset($this->sympathy[$person])) {
			echo "Not even if I'm drunk !" . PHP_EOL;
		} else {
			if ($this->sympathy[$person] == "OhYeah") {
				echo "Let's do this." . PHP_EOL;
			} else if ($this->sympathy[$person] == "MyLovelySister") {
				echo "With pleasure, but only in a tower in Winterfell, then." . PHP_EOL;
			}
		}
	}
}