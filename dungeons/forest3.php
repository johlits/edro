<?
function forest3_monsters(&$db, $rid, $i, $spawnRate) {
	$ret = "";
	if ($rid == 36) { // 3A
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "SeaDragon");
	}
	if ($rid == 37) { // 3B
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "FireWorm");
	}
	if ($rid == 38) { // 3C
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "SeaDragon");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "FireWorm");
	}
	if ($rid == 39) { // 3D
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Dactyl");
	}
	if ($rid == 40) { // 3E
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "SandRaptor");
	}
	if ($rid == 41) { // 3F
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "SeaDragon");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Dactyl");
	}
	if ($rid == 42) { // 3G
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "FireWorm");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "SandRaptor");
	}
	if ($rid == 43) { // 3H
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Mammoth");
	}
	if ($rid == 44) { // 3I
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Dactyl");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "FireWorm");
	}
	if ($rid == 45) { // 3J
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "SeaDragon");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Mammoth");
	}
	if ($rid == 46) { // 3K
		if (rand(1, 100) < $spawnRate)  $ret = $ret . createMonster($db, $rid, "SandRaptor");
	}
	if ($rid == 47) { // 3L
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "FireWorm");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Mammoth");
	}
	if ($rid == 48) { // 3M
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Dactyl");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "SandRaptor");
	}
	if ($rid == 49) { // 3N
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "SandRaptor");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Mammoth");
	}
	if ($rid == 50) { // 3O
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "SeaDragon");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "SandRaptor");
	}
	if ($rid == 51) { // 3P
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "FireWorm");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Dactyl");
	}
	if ($rid == 52) { // 3Q
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Mammoth");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "SeaDragon");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "Dactyl");
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, "SandRaptor");
	}
	if ($rid == 53) { // 3R
		$ret = $ret . createMonster($db, $rid, "IceDragon_BOSS");
	}
	return $ret;
}

?>