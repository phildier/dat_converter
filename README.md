Dat Converter
=============

This is a basic converter to turn vanilla minecraft player.dat files into 
Multiverse-Inventories .json files.  

Usage:
------
php convert.php player.dat player.json

Requirements:
-------------
PHP 5.3+ with the gmp extension.

Supports:
---------
Inventory, Armor

Currently missing:
------------------
Everything else (XP, Health, Hunger, Bed spawn, etc)

License: 
--------
Public domain.  Attribution would be nice.

Notes:
------
Utilizes the PHP NBT Decoder / Encoder library 
by Justin Martin <frozenfire@thefrozenfire.com>
<https://github.com/TheFrozenFire/PHP-NBT-Decoder-Encoder>
