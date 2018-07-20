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
use pocketmine\tile\Chest;
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
		$level->setBlock($position, Block::get(54, 0));
		/** @var Chest $chestu */
		$chestu = Tile::createTile(Tile::CHEST, $player->getLevel(), TileChest::createNBT($position));
		$chestuinv = $chestu->getInventory();
		for($i=9; $i<36; $i++){
			$chestuinv->setItem($i-9, $inv->getItem($i));
		}

		$position = $position->add(0, 1, 0);
		$level->setBlock($position, Block::get(54, 0));
		/** @var Chest $chesto */
		$chesto = Tile::createTile(Tile::CHEST, $player->getLevel(), TileChest::createNBT($position));
		$chestoinv = $chesto->getInventory();
		for($i=0; $i<9; $i++){
			$chestoinv->setItem($i+18, $inv->getItem($i));
		}
		foreach($ainv->getContents(true) as $slot => $item){
			$chestoinv->setItem($slot, $item);
		}

		$inv->clearAll();
		$ainv->clearAll();
		$event->setKeepInventory(true);
	}
}
