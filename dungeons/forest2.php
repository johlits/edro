<?
function forest2_monsters(&$db, $rid, $i, $spawnRate) {
	$ret = "";
	if ($rid == 14) { // 2A
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Dino");
	}
	if ($rid == 16) { // 2B
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Dino", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Dino", $i++));
	}
	if ($rid == 17) { // 2C
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Rex");
	}
	if ($rid == 18) { // 2D
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Turtle");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Dino");
	}
	if ($rid == 19) { // 2E
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Rex");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Dino");
	}
	if ($rid == 20) { // 2F
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Piraya");
	}
	if ($rid == 21) { // 2G
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Rex");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Turtle");
	}
	if ($rid == 22) { // 2H
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Dino", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Dino", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Rex");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Turtle");
	}
	if ($rid == 23) { // 2I
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Rex", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Rex", $i++));
	}
	if ($rid == 24) { // 2J
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Piraya", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Piraya", $i++));
	}
	if ($rid == 25) { // 2K
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Rex", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Rex", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Turtle");
	}
	if ($rid == 26) { // 2L
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Rex");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Turtle");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Piraya");
	}
	if ($rid == 27) { // 2M
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Turtle");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Dino", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Dino", $i++));
	}
	if ($rid == 28) { // 2N
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Piraya");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Rex");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Turtle");
	}
	if ($rid == 29) { // 2O
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Piraya", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Piraya", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Piraya", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Piraya", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Piraya", $i++));
	}
	if ($rid == 30) { // 2P
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Rex");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Piraya");
	}
	if ($rid == 31) { // 2Q
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Rex");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Turtle");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Piraya");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Dino");
	}
	if ($rid == 32) { // 2R
		$ret = $ret . createMonster($db, $rid, "Snake_A");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Frog", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Frog", $i++));
	}
	if ($rid == 33) { // 2S
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Rex", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Rex", $i++));
		$i = $iBegin;
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Turtle", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Turtle", $i++));
	}
	if ($rid == 34) { // 2T
		$ret = $ret . createMonster($db, $rid, "Hippogriff_BOSS");
	}
	return $ret;
}

?>