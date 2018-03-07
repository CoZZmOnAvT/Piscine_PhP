<?php

/**
* 
*/
class Player
{
	private		$_name;
	private		$_size;
	private		$_health;
	private		$_shield;
	public		$position;
	public		$id;

	function __construct($name, $info, int $id) {
		$this->_name	= $name;
		$this->id		= $id;

		$data	= json_decode($info, true);

		$this->_size	= $data['size'];
		$this->_health	= $data['health'];
		$this->_shield	= $data['shield'];
		

		if ($data == false) {
			$this->_size = array(15, 5);
			$this->_health = 5;
			$this->_shield = 10;
			DB::query('UPDATE `players` SET `info` = :info WHERE `id` = :id', 
					array(	'info' => json_encode(array('size' => $this->_size,
														'health' => $this->_health,
														'shield' => $this->_shield)),
							'id' => $id));
		}
	}

	public function	get_size() {
		return ($this->_size);
	}
}