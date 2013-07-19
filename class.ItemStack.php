<?php

class ItemStack
{
	public $type = null;
	public $amount = null;
	public $damage = null;
	public $meta = null;

	public function __construct($type,$amount=1,$damage=null)
	{
		if(is_int($type)) {
			$type = Materials::getName($type);
		}
		$this->type = $type;
		$this->amount = $amount;
		$this->damage = $damage;

		$java = "==";
		$this->$java = "org.bukkit.inventory.ItemStack";
	}

	public function enchant($type,$level)
	{
		$this->meta["=="] = "ItemMeta";
		$this->meta["meta-type"] = "UNSPECIFIC";
		if(is_int($type)) {
			$type = Enchantments::getName($type);
		}
		$this->meta["enchants"][$type] = $level;
	}
}
