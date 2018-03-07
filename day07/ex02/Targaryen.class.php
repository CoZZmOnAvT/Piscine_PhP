<?php


class Targaryen
{
	public function	getBurned() {
		if (method_exists($this, "resistsFire") === true
			&& $this->resistsFire() === true) {
			return "emerges naked but unharmed";
		} else {
			return "burns alive";
		}
	}
}