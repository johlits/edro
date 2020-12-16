<?

function appMonName($name, $i) {
    if ($i == 0) {
        return $name;
    }
    return $name . "_" . chr(64 + $i);
}

function createMonsters(&$db, $m_room)
{
    $ret = "";
    $stmt4 = $db->prepare("SELECT id FROM rpg_chars WHERE current_room = ? AND isplayer = 0");
    $stmt4->bind_param("i", $m_room);
    $ok = false;
    $spawnRate = 75;

    $rid = intval($m_room);
    $iBegin = 0;
    $i = $iBegin;

    if ($stmt4->execute()) {
        $result4 = $stmt4->get_result();
        $row_count4 = mysqli_num_rows($result4);
        if ($row_count4 == 0) {

            $ret = $ret . forest1_monsters($db, $rid, $i, $spawnRate);
			$ret = $ret . forest2_monsters($db, $rid, $i, $spawnRate);
			$ret = $ret . mushtrail_monsters($db, $rid, $i, $spawnRate);
            $ret = $ret . forest3_monsters($db, $rid, $i, $spawnRate);
			$ret = $ret . cave1_monsters($db, $rid, $i, $spawnRate);
			$ret = $ret . cave2_monsters($db, $rid, $i, $spawnRate);
			$ret = $ret . pubcrawl_monsters($db, $rid, $i, $spawnRate);
			$ret = $ret . cave3_monsters($db, $rid, $i, $spawnRate);

            if ($rid >= 77 && $rid <= 101) { // Field

                $randmon = rand(0, 1000);
                $fieldNo = $rid - 76;

                if ($randmon <= 50) {
                    $ret = $ret . createMonster($db, $rid, "Critter");
                } else if ($randmon <= 100) {
                    $ret = $ret . createMonster($db, $rid, "Spider");
                } else if ($randmon <= 150) {
                    $ret = $ret . createMonster($db, $rid, "Bird");
                } else if ($randmon <= 200) {
                    $ret = $ret . createMonster($db, $rid, "Frog");
                } else if ($randmon <= 2500 && $fieldNo > 4) {
                    $ret = $ret . createMonster($db, $rid, "Dino");
                } else if ($randmon <= 300 && $fieldNo > 4) {
                    $ret = $ret . createMonster($db, $rid, "Turtle");
                } else if ($randmon <= 350 && $fieldNo > 4) {
                    $ret = $ret . createMonster($db, $rid, "Rex");
                } else if ($randmon <= 400 && $fieldNo > 4) {
                    $ret = $ret . createMonster($db, $rid, "Piraya");
                } else if ($randmon <= 450 && $fieldNo > 8) {
                    $ret = $ret . createMonster($db, $rid, "FireShroom");
                } else if ($randmon <= 500 && $fieldNo > 8) {
                    $ret = $ret . createMonster($db, $rid, "WaterShroom");
                } else if ($randmon <= 550 && $fieldNo > 8) {
                    $ret = $ret . createMonster($db, $rid, "GroundShroom");
                } else if ($randmon <= 600 && $fieldNo > 8) {
                    $ret = $ret . createMonster($db, $rid, "WindShroom");
                }
            }
        }
    }
    $stmt4->close();
    return $ok;
}

function createMonster(&$db, $room, $name)
{
    $mon = $name;
    if (strpos($name, '_') !== false) {
        $mon = explode("_", $name)[0];
    }

    $monid = monsterStats($db, $mon, $name, $room);
    monsterSkills($db, $mon, $monid);
    $ret = monsterDrops($db, $mon, $monid);

    return $ret;
}

?>
