<?php
/**
 * Created by PhpStorm.
 * User: chapin
 * Date: 1/22/17
 * Time: 4:19 PM
 */

namespace Awesome;

class Room {
	public $left;
	public $right;
	public $top;
	public $bottom;

	public function __construct(array $params)
	{
		foreach ($params as $key => $para) {
			$this->$key = $para;
		}
	}
}