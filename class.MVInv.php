<?php

class MVInv
{
	public $SURVIVAL = null;

	public function __construct()
	{
		$this->SURVIVAL = new StdClass();
	}

	public function addItem(ItemStack $item,$slot=null)
	{
		if(is_null($slot)) {
			$this->SURVIVAL->inventoryContents[] = $item;
		} else {
			$this->SURVIVAL->inventoryContents->$slot = $item;
		}
	}

	public function addArmor(ItemStack $armor)
	{
		list($mat,$type) = explode("_",$armor->type);
		switch($type)
		{
		case "HELMET":
			$slot = 3;
			break;
		case "CHESTPLATE":
			$slot = 2;
			break;
		case "LEGGINGS":
			$slot = 1;
			break;
		case "BOOTS":
			$slot = 0;
			break;
		}
		$this->SURVIVAL->armorContents->$slot = $armor;

	}

	public function addEnderChest(ItemStack $item, $slot=null)
	{
		if(is_null($slot)) {
			$this->SURVIVAL->enderChestContents[] = $item;
		} else {
			$this->SURVIVAL->enderChestContents->$slot = $item;
		}
	}

	public function loadInv($inventory)
	{
		print "MVInv: loading ".count($inventory)." items...\n";
		foreach($inventory as $item) {
			$itemstack = new ItemStack($item->id,$item->count,$item->damage);
			if(!is_null($item->tag) && !is_null($item->tag->enchantments)) {
				foreach($item->tag->enchantments as $ench) {
					$itemstack->enchant($ench->id,$ench->level);
				}
			}
			if(!is_null($item->tag) && !is_null($item->tag->display)) {
				$itemstack->display($item->tag->display);
			}
			if($item->slot < 100) {
				$this->addItem($itemstack,$item->slot);
			} else {
				$this->addArmor($itemstack,($item->slot-100));
			}
		}
	}

	public function loadEnderInv($inventory)
	{
		print "MVInv: loading ".count($inventory)." items...\n";
		foreach($inventory as $item) {
			$itemstack = new ItemStack($item->id,$item->count,$item->damage);
			if(!is_null($item->tag) && !is_null($item->tag->enchantments)) {
				foreach($item->tag->enchantments as $ench) {
					$itemstack->enchant($ench->id,$ench->level);
				}
			}
			if(!is_null($item->tag) && !is_null($item->tag->display)) {
				$itemstack->display($item->tag->display);
			}
			if($item->slot < 100) {
				$this->addEnderChest($itemstack,$item->slot);
			} 
		}
	}

	public function writeJSON($json_file)
	{
		file_put_contents($json_file,json_encode($this));
	}
}
