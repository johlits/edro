<?
function pubcrawl_monsters(&$db, $rid, $i, $spawnRate) {
	$ret = "";
	if ($rid == 139) { // 1A
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Carglaerbs", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Carglaerbs", $i++));
	}
	if ($rid == 140) { // 1B
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Ekneineh", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Ekneineh", $i++));
	}
	if ($rid == 141) { // 1C
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Insgues", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Insgues", $i++));
	}
	if ($rid == 142) { // 1D
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Ranoco", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Ranoco", $i++));
	}
	if ($rid == 143) { // 1E
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Weltencasw", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Weltencasw", $i++));
	}
	if ($rid == 144) { // 1F
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Biswuered", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Biswuered", $i++));
	}
	if ($rid == 145) { // 1G
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Jaritmegrese", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Jaritmegrese", $i++));
	}
	if ($rid == 146) { // 1H
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Jealknaidsc", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Jealknaidsc", $i++));
	}
	if ($rid == 147) { // 1I
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Carglaerbs", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Carglaerbs", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Ekneineh", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Ekneineh", $i++));
	}
    if ($rid == 148) { // 1J
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Insgues", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Insgues", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Ranoco", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Ranoco", $i++));
    }
    if ($rid == 149) { // 1K
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Weltencasw", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Weltencasw", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Biswuered", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Biswuered", $i++));
    }
    if ($rid == 150) { // 1L
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Jaritmegrese", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Jaritmegrese", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Jealknaidsc", $i++));
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Jealknaidsc", $i++));
    }
	if ($rid == 151) { // 1M
		$ret = $ret . createMonster($db, $rid, "Spyritis_BOSS");
	}
	return $ret;
}

function pubcrawl_rooms(&$db) {
	$stmt = $db->prepare("INSERT INTO rpg_rooms (id, name, type, description) VALUES
	(139, 'Gotelands', 0, 'Sheepishly fun.'),
    (140, 'GH', 0, 'A nice garden with special brews.'),
    (141, 'Goteburg', 0, 'You start feeling the buzz.'),
    (142, 'Kalmari', 0, 'Pub crawls are among the best activities for pals.'),
    (143, 'Smalands', 0, 'Lost in the haze you start seeing stars everywhere.'),
    (144, 'Stocken', 0, 'Brats like to frat here. '),
    (145, 'Snerkan', 0, 'Some like to twerk at the snerk.'),
    (146, 'Uplands', 0, 'Seven beers in, most give up. But not you.'),
    (147, 'Varmland', 0, 'Always a good place for a super friday!'),
    (148, 'VG', 0, 'Cozy and small place.'),
    (149, 'VDala', 0, 'The sun sets as you arrive at the roof.'),
    (150, 'OEG', 0, 'Is there a better place to finish the pub crawl than OEG?'),
	(151, 'DomeChurch', 0, 'After 13 beers you arrive before the Dome Church. An immense power strikes you from above!'),
	(152, 'Switch_A1', 4, 'You are on switch A1, another player must stand on switch B1'),
	(153, 'Switch_B1', 4, 'You are on switch B1, another player must stand on switch A1'),
	(154, 'Switch_A2', 4, 'You are on switch A2, another player must stand on switch B2'),
	(155, 'Switch_B2', 4, 'You are on switch B2, another player must stand on switch A2'),
	(156, 'Switch_A', 4, 'You are on switch A, another player must stand on switch B'),
	(157, 'Switch_B', 4, 'You are on switch B, another player must stand on switch A')");
	$ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

function pubcrawl_switches(&$db) {
	$stmt = $db->prepare("INSERT INTO rpg_switches (goto_room, s1, s2, s3, s4) VALUES (140, 152, 153, -1, -1)");
	$ok1 = $stmt->execute();
    $stmt->close();
	$stmt = $db->prepare("INSERT INTO rpg_switches (goto_room, s1, s2, s3, s4) VALUES (150, 154, 155, -1, -1)");
	$ok2 = $stmt->execute();
    $stmt->close();
	$stmt = $db->prepare("INSERT INTO rpg_switches (goto_room, s1, s2, s3, s4) VALUES (55, 156, 157, -1, -1)");
	$ok3 = $stmt->execute();
    $stmt->close();
    return $ok1 && $ok2 && $ok3;
}

function pubcrawl_connections(&$db) {
	$stmt = $db->prepare("INSERT INTO rpg_connections (id, from_room, to_room, lvlcap) VALUES
	(271, 107, 139, 17),
    (272, 139, 107, 0),
    (273, 139, 152, 0),
	(274, 139, 153, 0),
    (275, 152, 139, 0),
	(276, 153, 139, 0),
    (277, 140, 139, 0),
    (278, 141, 140, 0),
    (279, 141, 142, 0),
    (280, 142, 141, 0),
    (281, 142, 143, 0),
    (282, 143, 142, 0),
    (283, 143, 144, 0),
    (284, 144, 143, 0),
    (285, 144, 145, 0),
    (286, 145, 144, 0),
    (287, 145, 146, 0),
    (288, 146, 145, 0),
    (289, 146, 147, 0),
    (290, 147, 146, 0),
    (291, 147, 148, 0),
    (292, 148, 147, 0),
    (293, 148, 149, 0),
    (294, 149, 148, 0),
    (295, 149, 154, 0),
	(296, 149, 155, 0),
    (297, 154, 149, 0),
	(298, 155, 149, 0),
    (299, 150, 149, 0),
    (300, 150, 151, 0),
	(301, 151, 107, 0),
	(302, 54, 157, 0),
	(303, 156, 54, 0),
	(304, 157, 54, 0)");
	$ok1 = $stmt->execute();
    $stmt->close();
	
	$stmt = $db->prepare("UPDATE rpg_connections SET to_room=156 WHERE id = 118");
	$ok2 = $stmt->execute();
    $stmt->close();
    
    return $ok1 && $ok2;
}

?>
