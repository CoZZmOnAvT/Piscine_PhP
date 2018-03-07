<?php

class UnholyFactory
{

	private		$fighters = array();

	public function	absorb($fighter) {
		if (!isset($fighter->type) || $fighter->type === NULL) {
			echo "(Factory can't absorb this, it's not a fighter)" . PHP_EOL;
		} else if (isset($this->fighters[$fighter->type])) {
			echo "(Factory already absorbed a fighter of type " . $fighter->type . ")" . PHP_EOL;
		} else {
			$this->fighters[$fighter->type] = $fighter;
			echo "(Factory absorbed a fighter of type " . $fighter->type . ")" . PHP_EOL;
		}
	}

	public function	fabricate(string $type) {
		if (!isset($this->fighters[$type])) {
			echo "(Factory hasn't absorbed any fighter of type " . $type . ")" . PHP_EOL;
			return (NULL);
		} else {
			echo "(Factory fabricates a fighter of type " . $type . ")" . PHP_EOL;
			return (new $this->fighters[$type]);
		}
	}
}