<?php

if(!(PHP_VERSION_ID >= 50300)) {
	die("PHP 5.3 or greater required\n");
}

require_once("nbt.class.php");
require_once("class.NBTInv.php");
require_once("class.MVInv.php");
require_once("class.ItemStack.php");
require_once("class.Materials.php");
require_once("class.Enchantments.php");

$nbt_file = $argv[1];
$json_file = $argv[2];
if(empty($nbt_file)) {
	die("usage: {$argv[0]} player.dat output.json\n");
}

/* load and parse the nbt inventory data */
$nbtinv = new NBTInv();
$nbtinv->loadFile($nbt_file);
$inventory = $nbtinv->getInv();
$ender_inventory = $nbtinv->getEnderInv();

/* init Multiverse Inventory from the data above */
$mvinv = new MVInv();
$mvinv->loadInv($inventory);
$mvinv->loadEnderInv($ender_inventory);
$mvinv->writeJSON($json_file);
