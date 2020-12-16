<?

function getStatQuery($id = false)
{
    $q = "SELECT id, name, lvl, exp, hp, maxhp, mp, maxmp, stamina, maxstamina, atk, def, spd, evd, target, weapon, body, legs, cape, current_room, gold, hp_v1, mp_v1, atp, int_stat, water_res, fire_res, ground_res, wind_res, light_res, dark_res, isplayer, cp, sp, auto_cp, ring FROM rpg_chars";
    if ($id) {
        return "{$q} WHERE id = ?";
    }
    return "{$q} WHERE name = ?";
}

function getItemStats(&$db, $charid, $cweapon, $cbody, $clegs, $ccape, $cring)
{
    $plus = array();
    $plus["atk"] = 0;
    $plus["def"] = 0;
    $plus["spd"] = 0;
    $plus["evd"] = 0;
    $plus["maxhp"] = 0;
    $plus["int"] = 0;
    $plus["fire_res"] = 0;
    $plus["water_res"] = 0;
    $plus["ground_res"] = 0;
    $plus["wind_res"] = 0;
    $plus["light_res"] = 0;
    $plus["dark_res"] = 0;

    $stmt2 = $db->prepare("SELECT id,name,atk,def,spd,evd,hp,mp,int_stat,fire_res,water_res,ground_res,wind_res,light_res,dark_res FROM rpg_items WHERE inroom = 0 AND ownerid = ?");
    $stmt2->bind_param("i", $charid);
    if ($stmt2->execute()) {
        $result2 = $stmt2->get_result();
        $row_count2 = mysqli_num_rows($result2);
        if ($row_count2 > 0) {
            $itemstr = ". Items: ";
            while ($row2 = mysqli_fetch_array($result2)) {
                $itemstr = $itemstr . "{$GLOBALS['z']}" . $row2["name"] . "#" . $row2["id"] . " ";
                if (intval($row2["id"]) == $cweapon || intval($row2["id"]) == $cbody || intval($row2["id"]) == $clegs || intval($row2["id"]) == $ccape || intval($row2["id"]) == $cring) {
                    $plus["atk"] += intval($row2["atk"]);
                    $plus["def"] += intval($row2["def"]);
                    $plus["spd"] += intval($row2["spd"]);
                    $plus["evd"] += intval($row2["evd"]);
                    $plus["maxhp"] += intval($row2["hp"]);
                    $plus["maxmp"] += intval($row2["mp"]);

                    $plus["int"] += intval($row2["int_stat"]);
                    $plus["fire_res"] += intval($row2["fire_res"]);
                    $plus["water_res"] += intval($row2["water_res"]);
                    $plus["ground_res"] += intval($row2["ground_res"]);
                    $plus["wind_res"] += intval($row2["wind_res"]);
                    $plus["light_res"] += intval($row2["light_res"]);
                    $plus["dark_res"] += intval($row2["dark_res"]);
                }
            }
        }
    }
    $stmt2->close();
    return $plus;
}

function create(&$db, $char, $owner)
{
    $ret = "";
    $chartolower = strtolower($char);
    $stmt = $db->prepare("SELECT * FROM rpg_chars WHERE isplayer = 1 AND LOWER(name) = ?");
    $stmt->bind_param("s", $chartolower);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            $ret = "already exists";
        } else {
            if (strpos($char, "_") !== false) {
                $ret = "name must not include _";
            } else if (strpos($char, " ") !== false) {
                $ret = "name must not include spaces";
            } else if (strpos($char, "{$GLOBALS['z']}") !== false) {
                $ret = "name must not include {$GLOBALS['z']}";
            } else {
                $hp = 100;
                $mp = 50;
                $atk = 20;
                $def = 20;
                $spd = 20;
                $evd = 20;
                $int = 20;
                $isplayer = 1;
                $stmt2 = $db->prepare("INSERT INTO rpg_chars( name, isplayer, maxhp, hp, maxmp, mp, atk, def, spd, evd, int_stat, owner ) VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
                $stmt2->bind_param("siiiiiiiiiis", $char, $isplayer, $hp, $hp, $mp, $mp, $atk, $def, $spd, $evd, $int, $owner);
                if ($stmt2->execute()) {
                    $ret = "has been created!";
                } else {
                    $ret = "Failed to create character";
                }
                $stmt2->close();
            }
        }
    }
    $stmt->close();
    return $ret;
}

function getStats(&$db, $char, $charId = -1)
{
    $stats = getStatsData($db, $char, $charId);

    $potstr = "";
    if (intval($stats["hp_v1"]) > 0 || intval($stats["mp_v1"]) > 0) {
        $potstr = "POTS: {$GLOBALS['z']}HP-pot " . $stats["hp_v1"] . " {$GLOBALS['z']}MP-pot " . $stats["mp_v1"] . " ";
    }

    $targetstr = "";
    if (intval($stats["target"]) > 0) {
        $targetName = getCharNameById($db, $stats["target"]);
        if (strlen($targetName) > 0) {
            $targetstr = "TARGET: {$GLOBALS['z']}" . $targetName . " ";
        }
    }

    $resstr = "";
    if (intval($stats["fire_res"]) > 0 || intval($stats["water_res"]) > 0 || intval($stats["ground_res"]) > 0 || intval($stats["wind_res"]) > 0 || intval($stats["light_res"]) > 0 || intval($stats["dark_res"]) > 0) {
        $resstr = "RESISTANCE: {$GLOBALS['z']}Fire " . $stats["fire_res"] . " {$GLOBALS['z']}Water " . $stats["water_res"] . " {$GLOBALS['z']}Ground " . $stats["ground_res"] . " {$GLOBALS['z']}Wind " . $stats["wind_res"] . " {$GLOBALS['z']}Light " . $stats["light_res"] . " {$GLOBALS['z']}Dark " . $stats["dark_res"];
    }

    $expstr = $stats["exp"] . " (" . (pow(intval($stats["lvl"] + 1), 4) - intval($stats["exp"])) . " to lvl up)";

    $cpstr = "";
    if ($stats["cp"] > 0) {
        $cpstr = " {$GLOBALS['z']}CP " . $stats["cp"];
    }
    $spstr = "";
    if ($stats["sp"] > 0) {
        $spstr = " {$GLOBALS['z']}SP " . $stats["sp"];
    }

    $ret = getClass($db, $char) . " STATS: {$GLOBALS['z']}LVL " . $stats["lvl"] . " {$GLOBALS['z']}EXP " . $expstr . " {$GLOBALS['z']}GOLD " . $stats["gold"] . " {$GLOBALS['z']}HP " . $stats["hp"] . " / " . $stats["maxhp"] . " {$GLOBALS['z']}MP " . $stats["mp"] . " / " . $stats["maxmp"] . " {$GLOBALS['z']}STA " . $stats["stamina"] . " / " . $stats["maxstamina"] . " {$GLOBALS['z']}ATK " . $stats["atk"] . " {$GLOBALS['z']}DEF " . $stats["def"] . " {$GLOBALS['z']}SPD " . $stats["spd"] . " {$GLOBALS['z']}EVD " . $stats["evd"] . " {$GLOBALS['z']}INT " . $stats["int"] . " {$GLOBALS['z']}ATP " . $stats["atp"] . $cpstr . " " . $spstr . " " . $targetstr . $potstr . $resstr;

    return $ret;
}

function getStatsData(&$db, $char, $charId = -1)
{

    $stats = array();
    $stats["id"] = 0;
    $stats["atk"] = 0;
    $stats["def"] = 0;
    $stats["spd"] = 0;
    $stats["evd"] = 0;
    $stats["maxhp"] = 0;
    $stats["maxmp"] = 0;
    $stats["hp"] = 0;
    $stats["mp"] = 0;
    $stats["hp_v1"] = 0;
    $stats["mp_v1"] = 0;

    $stats["lvl"] = 0;

    $stats["target"] = 0;
    $stats["exp"] = 0;
    $stats["gold"] = 0;
    $stats["stamina"] = 0;
    $stats["maxstamina"] = 0;
    $stats["name"] = "";
    $stats["current_room"] = 0;
    $stats["isplayer"] = 0;
    $stats["atp"] = 0;

    $stats["sp"] = 0;
    $stats["cp"] = 0;
    $stats["auto_cp"] = 0;

    $stats["int"] = 0;
    $stats["fire_res"] = 0;
    $stats["water_res"] = 0;
    $stats["ground_res"] = 0;
    $stats["wind_res"] = 0;
    $stats["light_res"] = 0;
    $stats["dark_res"] = 0;

    if (strpos($char, '#') !== false) {
        $charId = intval(explode("#", $char)[1]);
    }

    if ($charId > -1) {
        $stmt = $db->prepare(getStatQuery(true));
        $stmt->bind_param("i", $charId);
    }
    else {
        $stmt = $db->prepare(getStatQuery());
        $stmt->bind_param("s", $char);
    }

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {

                $itemStats = getItemStats($db,
                    intval($row["id"]),
                    intval($row["weapon"]),
                    intval($row["body"]),
                    intval($row["legs"]),
                    intval($row["cape"]),
                    intval($row["ring"]));

                $charId = intval($row["id"]);

                $petStats = array();
                $petStats["atk"] = 0;
                $petStats["def"] = 0;
                $petStats["spd"] = 0;
                $petStats["evd"] = 0;

                $stmt2 = $db->prepare("SELECT petid FROM rpg_pets WHERE ownerid = ?");
                $stmt2->bind_param("i", $charId);
                if ($stmt2->execute()) {
                    $result2 = $stmt2->get_result();
                    $row_count2 = mysqli_num_rows($result2);
                    if ($row_count2 > 0) {
                        while ($row2 = mysqli_fetch_array($result2)) {
                            $petStats = getPetStats($db, intval($row2["petid"]));
                        }
                    }
                }
                $stmt2->close();

                $stats["id"] = intval($row["id"]);
                $stats["atk"] = intval($row["atk"]) + $itemStats["atk"] + $petStats["atk"];
                $stats["def"] = intval($row["def"]) + $itemStats["def"] + $petStats["def"];
                $stats["spd"] = intval($row["spd"]) + $itemStats["spd"] + $petStats["spd"];
                $stats["evd"] = intval($row["evd"]) + $itemStats["evd"] + $petStats["evd"];
                $stats["maxhp"] = intval($row["maxhp"]) + $itemStats["maxhp"];
                $stats["maxmp"] = intval($row["maxmp"]) + $itemStats["maxmp"];
                $stats["hp"] = intval($row["hp"]);
                $stats["mp"] = intval($row["mp"]);
                $stats["hp_v1"] = intval($row["hp_v1"]);
                $stats["mp_v1"] = intval($row["mp_v1"]);

                $stats["target"] = intval($row["target"]);
                $stats["exp"] = intval($row["exp"]);
                $stats["gold"] = intval($row["gold"]);
                $stats["stamina"] = intval($row["stamina"]);
                $stats["maxstamina"] = intval($row["maxstamina"]);
                $stats["name"] = $row["name"];
                $stats["current_room"] = intval($row["current_room"]);
                $stats["isplayer"] = intval($row["isplayer"]);

                $stats["sp"] = intval($row["sp"]);
                $stats["cp"] = intval($row["cp"]);
                $stats["auto_cp"] = intval($row["auto_cp"]);

                $stats["atp"] = intval($row["atp"]);
                $stats["lvl"] = intval($row["lvl"]);

                $stats["int"] = intval($row["int_stat"]) + $itemStats["int"];
                $stats["fire_res"] = intval($row["fire_res"]) + $itemStats["fire_res"];
                $stats["water_res"] = intval($row["water_res"]) + $itemStats["water_res"];
                $stats["ground_res"] = intval($row["ground_res"]) + $itemStats["ground_res"];
                $stats["wind_res"] = intval($row["wind_res"]) + $itemStats["wind_res"];
                $stats["light_res"] = intval($row["light_res"]) + $itemStats["light_res"];
                $stats["dark_res"] = intval($row["dark_res"]) + $itemStats["dark_res"];

            }
        }
    }
    $stmt->close();

    return $stats;
}

function setAutoCp(&$db, $char, $p1, $p2)
{
    $stats = getStatsData($db, $char);
    $charid = $stats["id"];
    $ret = "";
    if (strtolower($p1) == "auto") {
        if (strtolower($p2) == "off") {
            $stmt = $db->prepare("UPDATE rpg_chars SET auto_cp = 0 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            return "Auto {$GLOBALS['z']}CP is OFF";
        }
        if (strtolower($p2) == "on") {
            $stmt = $db->prepare("UPDATE rpg_chars SET auto_cp = 1 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            return "Auto {$GLOBALS['z']}CP is ON " . autoPlaceCp($db, $char);
        }
    } else if (is_numeric($p2)) {
        $n = intval($p2);
        if ($n > 100) {
            $n = 100;
        }
        for ($x = 0; $x < $n; $x++) {
            $ret = $ret . placeCp($db, $char, $p1) . " ";
        }
    } else {
        $ret = "unknown command";
    }
    return $ret;
}

function getRandomRes()
{
    $r = rand(1, 6);
    $setstat = "";
    switch ($r) {
        case 1:
            $setstat = "fire";
            break;
        case 2:
            $setstat = "water";
            break;
        case 3:
            $setstat = "ground";
            break;
        case 4:
            $setstat = "wind";
            break;
        case 5:
            $setstat = "light";
            break;
        case 6:
            $setstat = "dark";
            break;
    }
    return $setstat;
}

function autoPlaceCp(&$db, $char)
{
    $ret = "";
    $stats = getStatsData($db, $char);
    $charid = $stats["id"];
    $cp = $stats["cp"];
    if ($stats["auto_cp"] == 1) {
        for ($x = 0; $x < $cp; $x++) {
            $r = rand(1, 8);
            $setstat = "";
            switch ($r) {
                case 1:
                    $setstat = "atk";
                    break;
                case 2:
                    $setstat = "def";
                    break;
                case 3:
                    $setstat = "spd";
                    break;
                case 4:
                    $setstat = "evd";
                    break;
                case 5:
                    $setstat = "int";
                    break;
                case 6:
                    $setstat = "hp";
                    break;
                case 7:
                    $setstat = "mp";
                    break;
                case 8:
                    $setstat = getRandomRes();
                    break;
            }
            $ret = $ret . placeCp($db, $char, $setstat) . " ";
        }
        return $ret;
    }
    return "";
}

function placeCp(&$db, $char, $p1)
{

    if ($p1 == "reset") {
        return resetStats($db, $char);
    }

    $stats = getStatsData($db, $char);
    $charid = $stats["id"];
    $ret = "";

    if ($stats["cp"] > 0) {

        $param = strtolower($p1);
        $setstat = "";
        $sethp = false;
        $setmp = false;

        if ($param == "atk") {
            $stmt = $db->prepare("UPDATE rpg_chars SET atk = atk + 6, cp = cp - 1 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            $ret = "increased {$GLOBALS['z']}ATK by 6";
        } else if ($param == "def") {
            $stmt = $db->prepare("UPDATE rpg_chars SET def = def + 6, cp = cp - 1 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            $ret = "increased {$GLOBALS['z']}DEF by 6";
        } else if ($param == "spd") {
            $stmt = $db->prepare("UPDATE rpg_chars SET spd = spd + 6, cp = cp - 1 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            $ret = "increased {$GLOBALS['z']}SPD by 6";
        } else if ($param == "evd") {
            $stmt = $db->prepare("UPDATE rpg_chars SET evd = evd + 6, cp = cp - 1 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            $ret = "increased {$GLOBALS['z']}EVD by 6";
        } else if ($param == "int") {
            $stmt = $db->prepare("UPDATE rpg_chars SET int_stat = int_stat + 6, cp = cp - 1 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            $ret = "increased {$GLOBALS['z']}INT by 6";
        } else if ($param == "hp") {
            $stmt = $db->prepare("UPDATE rpg_chars SET maxhp = maxhp + 20, cp = cp - 1 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            $ret = "increased MAX {$GLOBALS['z']}HP by 20";
        } else if ($param == "mp") {
            $stmt = $db->prepare("UPDATE rpg_chars SET maxmp = maxmp + 10, cp = cp - 1 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            $ret = "increased MAX {$GLOBALS['z']}MP by 10";
        } else if ($param == "fire") {
            $stmt = $db->prepare("UPDATE rpg_chars SET fire_res = fire_res + 1, cp = cp - 1 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            $ret = "increased {$GLOBALS['z']}FIRE RES by 1";
        } else if ($param == "water") {
            $stmt = $db->prepare("UPDATE rpg_chars SET water_res = water_res + 1, cp = cp - 1 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            $ret = "increased {$GLOBALS['z']}WATER RES by 1";
        } else if ($param == "ground") {
            $stmt = $db->prepare("UPDATE rpg_chars SET ground_res = ground_res + 1, cp = cp - 1 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            $ret = "increased {$GLOBALS['z']}GROUND RES by 1";
        } else if ($param == "wind") {
            $stmt = $db->prepare("UPDATE rpg_chars SET wind_res = wind_res + 1, cp = cp - 1 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            $ret = "increased {$GLOBALS['z']}WIND RES by 1";
        } else if ($param == "light") {
            $stmt = $db->prepare("UPDATE rpg_chars SET light_res = light_res + 1, cp = cp - 1 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            $ret = "increased {$GLOBALS['z']}LIGHT RES by 1";
        } else if ($param == "dark") {
            $stmt = $db->prepare("UPDATE rpg_chars SET dark_res = dark_res + 1, cp = cp - 1 WHERE id = ?");
            $stmt->bind_param("i", $charid);
            $stmt->execute();
            $stmt->close();
            $ret = "increased {$GLOBALS['z']}DARK RES by 1";
        } else {
            $ret = "unknown stat " . $p1;
        }
    } else {
        $ret = "no character points (CP)";
    }

    return $ret;
}

function unfollow(&$db, $char)
{
    $stats = getStatsData($db, $char);
    $charid = $stats["id"];
    $stmt2 = $db->prepare("UPDATE rpg_chars SET follow = 0 WHERE id = ?");
    $stmt2->bind_param("i", $charid);
    $stmt2->execute();
    $stmt2->close();
    return "is not following other characters";
}

function follow(&$db, $char, $p1)
{
    $ret = "could not find character";
    $stats = getStatsData($db, $char);
    $roomid = $stats["current_room"];
    $charid = $stats["id"];

    $stmt = $db->prepare("SELECT id, name, isplayer FROM rpg_chars WHERE current_room = ?");
    $stmt->bind_param("i", $roomid);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $isplayer = intval($row["isplayer"]);
                if ($isplayer == 1 && strtolower($row["name"]) == $p1) {

                    $fid = intval($row["id"]);

                    $stmt2 = $db->prepare("UPDATE rpg_chars SET follow = ? WHERE id = ?");
                    $stmt2->bind_param("ii", $fid, $charid);
                    $stmt2->execute();
                    $stmt2->close();

                    $ret = "is now following {$GLOBALS['z']}" . $row["name"];
                }
            }
        }
    }
    $stmt->close();
    return $ret;
}

function reduceStamina(&$db, $char)
{
    $stmt3 = $db->prepare("UPDATE rpg_chars SET stamina = stamina - 1 WHERE LOWER(name) = ?");
    $stmt3->bind_param("s", $char);
    $ok = $stmt3->execute();
    $stmt3->close();
    return $ok;
}

function reduceAtp(&$db, $char, $amount)
{
    $stmt3 = $db->prepare("UPDATE rpg_chars SET atp = atp - ? WHERE LOWER(name) = ?");
    $stmt3->bind_param("is", $amount, $char);
    $ok = $stmt3->execute();
    $stmt3->close();
    return $ok;
}

function lvlUp(&$db, $char)
{
    $charparts = explode("#", $char);
    if (count($charparts) > 1) {
        $char = $charparts[0];
        $charid = intval($charparts[1]);
        $stmt = $db->prepare("SELECT name, maxhp, maxmp, atk, def, spd, evd, lvl, exp, maxstamina, int_stat FROM rpg_chars WHERE LOWER(name) = ? AND id = ?");
        $stmt->bind_param("si", $char, $charid);
    }
    else {
        $stmt = $db->prepare("SELECT name, maxhp, maxmp, atk, def, spd, evd, lvl, exp, maxstamina, int_stat FROM rpg_chars WHERE LOWER(name) = ?");
        $stmt->bind_param("s", $char);
    }
    
    $ret = "";
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $charName = $row["name"];
                $lvl = intval($row["lvl"]);
                $exp = intval($row["exp"]);
                $maxhp = intval($row["maxhp"]);
                $maxmp = intval($row["maxmp"]);
                $atk = intval($row["atk"]);
                $def = intval($row["def"]);
                $spd = intval($row["spd"]);
                $evd = intval($row["evd"]);
                $int = intval($row["int_stat"]);
                $maxstamina = intval($row["maxstamina"]);
                $newlvl = $lvl;

                for ($x = 2; $x < 100; $x++) {
                    if ($exp > pow($x, 4)) {
                        $newlvl = $x;
                    }
                }

                if ($newlvl > $lvl) {

                    $stmt2 = $db->prepare("UPDATE rpg_chars SET lvl = ? WHERE LOWER(name) = ?");
                    $stmt2->bind_param("is", $newlvl, $char);
                    if ($stmt2->execute()) {
                        $ret = "{$GLOBALS['z']}" . $charName . " leveled up " . $lvl . " -> " . $newlvl . "! ";
                        $lvldiff = $newlvl - $lvl;
                        for ($x = 0; $x < $lvldiff; $x++) {

                            $stmt3 = $db->prepare("UPDATE rpg_chars SET sp = sp + 1, cp = cp + 10 WHERE name = ?");
                            $stmt3->bind_param("s", $char);
                            $stmt3->execute();
                            $stmt3->close();

                            $ret = $ret . autoPlaceCp($db, $char);
                        }

                        recover($db, $char, true);
                    }
                    $stmt2->close();

                }
            }
        }
    }
    $stmt->close();
    return $ret;
}

function getClass(&$db, $char)
{
    $stats = getStatsData($db, $char);
    $charId = $stats["id"];

    $stmt = $db->prepare("SELECT class FROM rpg_classes WHERE charid = ?");
    $stmt->bind_param("i", $charId);
    $ret = "";
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $ret = "CLASS: " . getClassById(intval($row["class"]));
            }
        } else {
            $ret = "";
        }
    }
    $stmt->close();
    return $ret;
}

function getClassById($classid)
{
    $ret = "";
    switch ($classid) {
        case 1:
            $ret = "Warrior";
            break;
        case 2:
            $ret = "Thief";
            break;
        case 3:
            $ret = "Mage";
            break;
        default:
            $ret = "None";
            break;
    }
    return $ret;
}

function listClass(&$db, $char)
{

    $stats = getStatsData($db, $char);
    $charId = $stats["id"];
    $charLvl = $stats["lvl"];

    $stmt = $db->prepare("SELECT class FROM rpg_classes WHERE charid = ?");
    $stmt->bind_param("i", $charId);
    $ret = "";
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $ret = "Current class: " . getClassById(intval($row["class"]));
            }
        } else {
            if ($charLvl < 10) {
                $ret = "Current class: None. Choose 1st job at {$GLOBALS['z']}LVL 10. ";
            } else {
                $ret = "Current class: None. Pick one (use command 'class x'): Warrior (ATK/DEF), Thief (SPD/EVD), Mage (INT/RES)";
            }

        }
    }
    $stmt->close();
    return $ret;
}

function pickClass(&$db, $char, $p1)
{

    $ret = "";

    $stats = getStatsData($db, $char);
    $charId = $stats["id"];

    $stmt = $db->prepare("SELECT class FROM rpg_classes WHERE charid = ?");
    $stmt->bind_param("i", $charId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count == 0) {

            if ($p1 == "warrior") {
                $stmt2 = $db->prepare("UPDATE rpg_chars SET atk = atk + 50, def = def + 50 WHERE id = ?");
                $stmt2->bind_param("i", $charId);
                $stmt2->execute();
                $stmt2->close();
                $stmt2 = $db->prepare("INSERT INTO rpg_classes (charid, class) VALUES (?, 1)");
                $stmt2->bind_param("i", $charId);
                $stmt2->execute();
                $stmt2->close();
                $ret = "picked warrior class";
            }
            if ($p1 == "thief") {
                $stmt2 = $db->prepare("UPDATE rpg_chars SET spd = spd + 50, evd = evd + 50 WHERE id = ?");
                $stmt2->bind_param("i", $charId);
                $stmt2->execute();
                $stmt2->close();
                $stmt2 = $db->prepare("INSERT INTO rpg_classes (charid, class) VALUES (?, 2)");
                $stmt2->bind_param("i", $charId);
                $stmt2->execute();
                $stmt2->close();
                $ret = "picked thief class";
            }
            if ($p1 == "mage") {
                $stmt2 = $db->prepare("UPDATE rpg_chars SET int_stat = int_stat + 50, fire_res = fire_res + 5, water_res = water_res + 5, ground_res = ground_res + 5, wind_res = wind_res + 5 WHERE id = ?");
                $stmt2->bind_param("i", $charId);
                $stmt2->execute();
                $stmt2->close();
                $stmt2 = $db->prepare("INSERT INTO rpg_classes (charid, class) VALUES (?, 3)");
                $stmt2->bind_param("i", $charId);
                $stmt2->execute();
                $stmt2->close();
                $ret = "picked mage class";
            }
        }
    }
    $stmt->close();
    return $ret;
}

?>
