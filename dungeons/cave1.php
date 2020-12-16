<?
function cave1_monsters(&$db, $rid, $i, $spawnRate) {
	$ret = "";
	if ($rid == 108) { // 1A
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Golem");
	}
	if ($rid == 109) { // 1B
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Bat");
	}
	if ($rid == 110) { // 1C
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Tarantula");
	}
	if ($rid == 111) { // 1D
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Mole");
	}
	if ($rid == 112) { // 1E
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Troll");
	}
	if ($rid == 113) { // 1F
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Golem");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Bat");
	}
	if ($rid == 114) { // 1G
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Bat");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Tarantula");
	}
	if ($rid == 115) { // 1H
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Tarantula");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Mole");
	}
	if ($rid == 116) { // 1I
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Mole");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Troll");
	}
	if ($rid == 117) { // 1J
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troll", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troll", $i++));
	}
	if ($rid == 118) { // 1K
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Bat", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Bat", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Bat", $i++));
	}
	if ($rid == 119) { // 1L
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troll", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troll", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Tarantula");
	}
	if ($rid == 120) { // 1M
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Mole", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Mole", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Bat");
	}
	if ($rid == 121) { // 1N
		$ret = $ret . createMonster($db, $rid, "CaveBear_BOSS");
	}
	return $ret;
}

?>