<?php

namespace InventoryBeChest;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\level\Level;

use pocketmine\event\player\PlayerDeathEvent;

use pocketmine\math\Vector3;

use pocketmine\item\Item;
use pocketmine\block\Block;

use pocketmine\tile\Chest as TileChest;
use pocketmine\tile\Tile;

use pocketmine\inventory\BaseInventory;
use pocketmine\inventory\ChestInventory;
use pocketmine\inventory\DoubleChestInventory;

class Main extends PluginBase implements Listener{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		}
		
	public function ChangeItem(PlayerDeathEvent $event){
		$player = $event->getPlayer();
		$inv = $player->getInventory();
		$ainv = $player->getArmorInventory();
		$level = $player->getLevel();
		$position = $player->floor();
		$event->setKeepInventory(true);
		$level->setBlock($position, Block::get(54, 0));
		$chestu = Tile::createTile(Tile::CHEST, $player->getLevel(), TileChest::createNBT($position));
		$chestuinv = $chestu->getInventory();
		for($i=9; $i<36; $i++){
			$id = $inv->getItem($i)->getId();
			$damage = $inv->getItem($i)->getDamage();
			$amount = $inv->getItem($i)->getCount();
			$chestuinv->setItem($i-9, Item::get($id, $damage, $amount));
			}
		$position = $position->add(0, 1, 0);
		$level->setBlock($position, Block::get(54, 0));
		$chesto = Tile::createTile(Tile::CHEST, $player->getLevel(), TileChest::createNBT($position));
		$chestoinv = $chesto->getInventory();
		for($i=0; $i<9; $i++){
			$id = $inv->getItem($i)->getId();
			$damage = $inv->getItem($i)->getDamage();
			$amount = $inv->getItem($i)->getCount();
			$chestoinv->setItem($i+18, Item::get($id, $damage, $amount));
			}
		$chestoinv->setItem(0, $ainv->getHelmet());
		$chestoinv->setItem(1, $ainv->getChestplate());
		$chestoinv->setItem(2, $ainv->getLeggings());
		$chestoinv->setItem(3, $ainv->getBoots());
		$inv->clearAll();
		$ainv->clearAll();
		}
	}
