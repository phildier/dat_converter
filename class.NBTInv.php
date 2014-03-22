<?php

class NBTInv extends nbt
{
	private $nbt = null;

	/**
	 * gets player inventory from nbt file
	 * optionally provide raw nbt data using format=false
	 */
	public function getInv($format=true)
	{
		foreach($this->root[0]["value"] as $node) {
			$node = (object)$node;
			if($node->name == "Inventory") {
				$inventory = (object)$node->value;
			}
		}
		if($format === true) {
			return $this->formatAll($inventory->value);
		} else {
			return $inventory;
		}
	}

	public function getEnderInv($format=true)
	{
		foreach($this->root[0]["value"] as $node) {
			$node = (object)$node;
			if($node->name == "EnderItems") {
				$inventory = (object)$node->value;
			}
		}
		if($format === true && !is_null($inventory)) {
			return $this->formatAll($inventory->value);
		} else {
			return $inventory;
		}
	}

	/**
	 * given an array of raw nbt invntory data, returns formatted array of items
	 */
	public function formatAll(Array $inventory)
	{
		$ret = array();
		foreach($inventory as $item) {
			$ret[] = $this->formatItem($item);
		}
		return $ret;
	}

	/**
	 * given an item as an array, formats a single item
	 */
	private function formatItem(Array $item)
	{
		$ret = new StdClass();
		foreach($item as $att) {
			$att = (object)$att;
			switch(strtolower($att->name))
			{
			case "id":
				$ret->id = $att->value;
				break;
			case "damage":
				$ret->damage = $att->value;
				break;
			case "count":
				$ret->count = $att->value;
				break;
			case "tag":
				$ret->tag = $this->formatTag($att->value);
				break;
			case "slot":
				$ret->slot = $att->value;
				break;
			default:
				throw new Exception("unrecognized node name `{$att->name}`. dump: ".json_encode($att));
			}
		}
		return $ret;
	}

	/**
	 * given an array of tags, formats them
	 */
	private function formatTag($tag_entries)
	{
		$ret = new StdClass();
		foreach($tag_entries as $att) {
			$att = (object)$att;
			switch(strtolower($att->name)) 
			{
			case "repaircost":
				$ret->repaircost = $att->value;
				break;
			case "ench":
				foreach($att->value['value'] as $enchantment) {
					$ret->enchantments[] = $this->formatEnchantment($enchantment);
				}
				break;
			case "display":
				$ret->display = $this->formatDisplay($att->value);
				break;
			case "fireworks":
				$ret->firework = $this->formatFirework($att->value);
				break;
			default:
				throw new Exception("unrecognized tag name `{$att->name}`. dump: ".json_encode($att));
			}
		}
		return $ret;
	}

	/**
	 * given enchantment data, formats it
	 */
	private function formatEnchantment($enchantment_entries)
	{
		$ret = new StdClass();
		foreach($enchantment_entries as $att)
		{
			$att = (object)$att;
			switch(strtolower($att->name))
			{
			case "id":
				$ret->id = $att->value;
				break;
			case "lvl":
				$ret->level = $att->value;
				break;
			default:
				throw new Exception("unrecognized enchantment attribute `{$att->name}`. dump: ".json_encode($enchantment));
			}
		}
		return $ret;
	}

	/**
	 * given display data, formats it
	 */
	private function formatDisplay($display_entries)
	{
		$ret = new StdClass();
		foreach($display_entries as $att) {
			$att = (object)$att;
			switch(strtolower($att->name)) 
			{
			case "name":
				$ret->name = $att->value;
				break;
			case "color":
				$ret->color = $att->value;
				break;
			case "lore":
				// nothing yet
				break;
			default:
				throw new Exception("unrecognized display attribute `{$att->name}`. dump: ".json_encode($display));
			}
		}
		return $ret;
	}


	/**
	 * given fireworks data, formats it
	 */
	private function formatFirework($firework_entries)
	{
		$ret = new StdClass();
		foreach($firework_entries as $att) {
			$att = (object)$att;
			switch(strtolower($att->name)) 
			{
			case "flight":
				$ret->flight = $att->value;
				break;
			case "explosions":
				foreach($att->value['value'] as $explosion) {
					$ret->explosions[] = $this->formatexplosion($explosion);
				}
				break;
			default:
				throw new Exception("unrecognized display attribute `{$att->name}`. dump: ".json_encode($display));
			}
		}
		return $ret;
	}

	/**
	 * given explosion data, formats it
	 */
	private function formatExplosion($explosion_entries)
	{
		$ret = new StdClass();
		foreach($explosion_entries as $att)
		{
			$att = (object)$att;
			switch(strtolower($att->name))
			{
			case "flicker":
				$ret->flicker = $att->value;
				break;
			case "type":
				$ret->type = $att->value;
				break;
			case "trails":
				$ret->trails = $att->value;
				break;
			case "colors":
				$ret->colors = $att->value;
				break;
			case "fadecolors":
				$ret->fade_colors = $att->value;
				break;
			default:
				throw new Exception("unrecognized enchantment attribute `{$att->name}`. dump: ".json_encode($enchantment));
			}
		}
		return $ret;
	}
}

