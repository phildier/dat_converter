<?php

class NBTInv extends nbt
{
	private $nbt = null;

	/**
	 * gets player inventory from nbt file
	 * optionally provide raw nbt data using format=false
	 */
	public function get($format=true)
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
				$ret->tag = $this->formatTags($att->value);
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
	private function formatTags($tags)
	{
		$ret = new StdClass();
		foreach($tags as $att) {
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
			default:
				throw new Exception("unrecognized tag name `{$att->name}`. dump: ".json_encode($att));
			}
		}
		return $ret;
	}

	/**
	 * given enchantment data, formats it
	 */
	private function formatEnchantment($enchantment)
	{
		$ret = new StdClass();
		foreach($enchantment as $att)
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
}

