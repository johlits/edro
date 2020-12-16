<?
function cave2_monsters(&$db, $rid, $i, $spawnRate) {
	$ret = "";
	if ($rid == 122) { // 2A
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("SilverRaptor", $i++));
	}
	if ($rid == 123) { // 2B
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("RubiFlower", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("RubiFlower", $i++));
	}
	if ($rid == 124) { // 2C
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("SilverRaptor", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("SilverRaptor", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("SilverRaptor", $i++));
	}
	if ($rid == 125) { // 2D
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("QuarzDroplet", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("QuarzDroplet", $i++));
	}
	if ($rid == 126) { // 2E
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("DiamondDrake", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("DiamondDrake", $i++));
	}
	if ($rid == 127) { // 2F
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("MagneMon", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("MagneMon", $i++));
	}
	if ($rid == 128) { // 2G
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("RubiFlower", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("RubiFlower", $i++));
		$i = $iBegin;
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("DiamondDrake", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("DiamondDrake", $i++));
	}
	if ($rid == 129) { // 2H
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("GoldRaptor", $i++));
	}
	if ($rid == 130) { // 2I
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("QuarzDroplet", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("QuarzDroplet", $i++));
		$i = $iBegin;
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("MagneMon", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("MagneMon", $i++));
	}
	if ($rid == 131) { // 2J
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("RubiFlower", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("RubiFlower", $i++));
		$i = $iBegin;
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("DiamondDrake", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("DiamondDrake", $i++));
	}
	if ($rid == 132) { // 2K
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("SilverRaptor", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("GoldRaptor", $i++));
	}
	if ($rid == 133) { // 2L
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("QuarzDroplet", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("QuarzDroplet", $i++));
		$i = $iBegin;
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("MagneMon", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("MagneMon", $i++));
	}
	if ($rid == 134) { // 2M
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("GoldRaptor", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("GoldRaptor", $i++));
	}
	if ($rid == 135) { // 2N
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("MagneMon", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("DiamondDrake", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("QuarzDroplet", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("RubiFlower", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("GoldRaptor", $i++));
	}
	if ($rid == 136) { // 2O
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("MagneMon", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("DiamondDrake", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("QuarzDroplet", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("RubiFlower", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("GoldRaptor", $i++));
	}
	if ($rid == 137) { // 2P
		$ret = $ret . createMonster($db, $rid, "TitanWiz_BOSS");
	}
	return $ret;
}

?>