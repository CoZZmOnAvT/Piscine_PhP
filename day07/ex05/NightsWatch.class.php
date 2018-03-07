<?php

class NightsWatch
{
	private	$fighters;

	public function	__construct(){
		$this->fighters = array();
	}

	public function	fight() {
		foreach ($this->fighters as $fighter) {
			$fighter->fight();
		}
	}

	public function recruit($fighter) {
		if (isset(class_implements($fighter)['IFighter'])) {
			$this->fighters[] = $fighter;
		}
	}
}