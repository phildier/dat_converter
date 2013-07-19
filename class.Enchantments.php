<?php

class Enchantments
{
	private static $map = array(
			"0" => "PROTECTION_ENVIRONMENTAL",
			"1" => "PROTECTION_FIRE",
			"2" => "PROTECTION_FALL",
			"3" => "PROTECTION_EXPLOSIONS",
			"4" => "PROTECTION_PROJECTILE",
			"5" => "OXYGEN",
			"6" => "WATER_WORKER",
			"7" => "THORNS",
			"16" => "DAMAGE_ALL",
			"17" => "DAMAGE_UNDEAD",
			"18" => "DAMAGE_ARTHROPODS",
			"19" => "KNOCKBACK",
			"20" => "FIRE_ASPECT",
			"21" => "LOOT_BONUS_MOBS",
			"32" => "DIG_SPEED",
			"33" => "SILK_TOUCH",
			"34" => "DURABILITY",
			"35" => "LOOT_BONUS_BLOCKS",
			"48" => "ARROW_DAMAGE",
			"49" => "ARROW_KNOCKBACK",
			"50" => "ARROW_FIRE",
			"51" => "ARROW_INFINITE",
			);

	public static function getName($id)
	{
		return (self::$map[$id]?:null);
	}

	public static function getID($name)
	{
		$flip = array_flip(self::$map);
		return ($flip[$id]?:null);
	}
}
