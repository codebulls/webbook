<?php

class Land extends BaseModel
{
	public static function getLand($lid)
	{
		$land = Land::findFirstById($lid);
		return $land;
	}

	public static function getAll()
	{
		$lands = Land::find();
		return $lands;
	}
	
}
