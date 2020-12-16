<?

function forge(&$db, $char, $p1)
{
    $ret = "";
    $stmt = $db->prepare("SELECT id, gold FROM rpg_chars WHERE LOWER(name) = ?");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {

                $charid = intval($row["id"]);
                $chargold = intval($row["gold"]);

                $stmt2 = $db->prepare("SELECT id, name, lvl, atk, def, spd, evd, hp, mp FROM rpg_items WHERE inroom = 0 AND ownerid = ?");
                $stmt2->bind_param("i", $charid);
                if ($stmt2->execute()) {
                    $result2 = $stmt2->get_result();
                    $row_count2 = mysqli_num_rows($result2);
                    if ($row_count2 > 0) {
                        $founditem = false;
                        while ($row2 = mysqli_fetch_array($result2)) {


                            $itemid = intval($row2["id"]);
                            $itemname = $row2["name"] . "#" . $row2["id"];
                            $itemlvl = intval($row2["lvl"]);
                            $itematk = intval($row2["atk"]);
                            $itemdef = intval($row2["def"]);
                            $itemspd = intval($row2["spd"]);
                            $itemevd = intval($row2["evd"]);
                            $itemhp = intval($row2["hp"]);
                            $itemmp = intval($row2["mp"]);

                            if (strtolower($itemname) == $p1) {

                                $founditem = true;

                                if ($chargold >= $itemlvl * 200) {

                                    $chargold -= $itemlvl * 200;

                                    $stmt3 = $db->prepare("UPDATE rpg_chars SET gold = ? WHERE LOWER(name) = ?");
                                    $stmt3->bind_param("is", $chargold, $char);
                                    if ($stmt3->execute()) {


                                        $nitematk = $itematk + rand(0, intval($itematk / $itemlvl));
                                        $nitemdef = $itemdef + rand(0, intval($itemdef / $itemlvl));
                                        $nitemspd = $itemspd + rand(0, intval($itemspd / $itemlvl));
                                        $nitemevd = $itemevd + rand(0, intval($itemevd / $itemlvl));
                                        $nitemhp = $itemhp + rand(0, intval($itemhp / $itemlvl));
                                        $nitemmp = $itemmp + rand(0, intval($itemmp / $itemlvl));

                                        $itemlvl += 1;

                                        $stmt4 = $db->prepare("UPDATE rpg_items SET atk = ?, def = ?, spd = ?, evd = ?, hp = ?, mp = ?, lvl = ? WHERE id = ?");
                                        $stmt4->bind_param("iiiiiiii", $nitematk, $nitemdef, $nitemspd, $nitemevd, $nitemhp, $nitemmp, $itemlvl, $itemid);
                                        if ($stmt4->execute()) {

                                            $ret = "forged {$GLOBALS['z']}" . $itemname . " to lvl " . $itemlvl . " for " . (($itemlvl - 1) * 200) . "g (" . $itematk . "/" . $itemdef . "/" . $itemspd . "/" . $itemevd . " " . $itemhp . "/" . $itemmp . ") -> (" . $nitematk . "/" . $nitemdef . "/" . $nitemspd . "/" . $nitemevd . " " . $nitemhp . "/" . $nitemmp . ")";

                                        }
                                        $stmt4->close();


                                    }
                                    $stmt3->close();

                                } else {
                                    $ret = "not enough gold to forge {$GLOBALS['z']}" . $itemname . " (req " . ($itemlvl * 200) . " g)";
                                }
                            }
                        }

                        if (!$founditem) {
                            $ret = "unknown item";
                        }

                    }
                }
                $stmt2->close();
            }
        }
    }
    $stmt->close();

    return $ret;
}

function useItem(&$db, $char, $p1, $p2)
{
    $ret = "";

    $cnt = intval($p2);

    $stats = getStatsData($db, $char);

    $hp = intval($stats["hp"]);
    $mp = intval($stats["mp"]);
    $maxhp = intval($stats["maxhp"]);
    $maxmp = intval($stats["maxmp"]);
    $hpv1 = intval($stats["hp_v1"]);
    $mpv1 = intval($stats["mp_v1"]);

    if ($p1 == "hp-pot") {
        if ($hpv1 >= $cnt) {
            $newhp = $hp + $cnt * 10;
            $newhpv1 = $hpv1 - $cnt;
            $stmt2 = $db->prepare("UPDATE rpg_chars SET hp_v1 = ?, hp = LEAST(?, ?) WHERE LOWER(name) = ?");
            $stmt2->bind_param("iiis", $newhpv1, $newhp, $maxhp, $char);
            if ($stmt2->execute()) {
                $ret = "used " . $cnt . " {$GLOBALS['z']}HP pot(s)";
            }
            $stmt2->close();
        } else {
            $ret = "not enough {$GLOBALS['z']}HP pots";
        }
    } else if ($p1 == "mp-pot") {
        if ($mpv1 >= $cnt) {
            $newmp = $mp + $cnt * 10;
            $newmpv1 = $mpv1 - $cnt;
            $stmt2 = $db->prepare("UPDATE rpg_chars SET mp_v1 = ?, mp = LEAST(?, ?) WHERE LOWER(name) = ?");
            $stmt2->bind_param("iiis", $newmpv1, $newmp, $maxmp, $char);
            if ($stmt2->execute()) {
                $ret = "used " . $cnt . " {$GLOBALS['z']}MP pot(s)";
            }
            $stmt2->close();
        } else {
            $ret = "not enough {$GLOBALS['z']}MP pots";
        }
    } else {
        $ret = "unknown item {$GLOBALS['z']}" . $p1;
    }


    return $ret;
}

function equip(&$db, $char, $p1)
{
    $stmt = $db->prepare("SELECT id FROM rpg_chars WHERE LOWER(name) = ?");
    $stmt->bind_param("s", $char);
    $ret = "";
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $charid = intval($row["id"]);

                $clid = 0;
                $stmt2 = $db->prepare("SELECT class FROM rpg_classes WHERE charid = ?");
                $stmt2->bind_param("i", $charid);
                if ($stmt2->execute()) {
                    $result2 = $stmt2->get_result();
                    $row_count2 = mysqli_num_rows($result2);
                    if ($row_count2 > 0) {
                        while ($row2 = mysqli_fetch_array($result2)) {
                            $clid = intval($row2["class"]);
                        }
                    }
                }
                $stmt2->close();

                $stmt2 = $db->prepare("SELECT id, name, type, classreq FROM rpg_items WHERE inroom = 0 AND ownerid = ?");
                $stmt2->bind_param("i", $charid);
                if ($stmt2->execute()) {
                    $result2 = $stmt2->get_result();
                    $row_count2 = mysqli_num_rows($result2);
                    if ($row_count2 > 0) {
                        while ($row2 = mysqli_fetch_array($result2)) {
                            $itemtype = intval($row2["type"]);
                            $itemid = intval($row2["id"]);
                            $itemclass = intval($row2["classreq"]);

                            if ($p1 == strtolower($row2["name"] . "#" . $row2["id"])) {

                                if ($itemclass != 0 && $itemclass != $clid) {
                                    $ret = "class requirement not met (req " . getClassById($itemclass) . ")";
                                } else {
                                    if ($itemtype == 1) {
                                        $stmt3 = $db->prepare("UPDATE rpg_chars SET weapon = ? WHERE id = ?");
                                        $stmt3->bind_param("ii", $itemid, $charid);
                                        if ($stmt3->execute()) {
                                            $ret = "equipped {$GLOBALS['z']}" . $row2["name"] . "#" . $itemid . " as weapon";
                                        }
                                        $stmt3->close();
                                    } else if ($itemtype == 2) {
                                        $stmt3 = $db->prepare("UPDATE rpg_chars SET body = ? WHERE id = ?");
                                        $stmt3->bind_param("ii", $itemid, $charid);
                                        if ($stmt3->execute()) {
                                            $ret = "equipped {$GLOBALS['z']}" . $row2["name"] . "#" . $itemid . " as armor";
                                        }
                                        $stmt3->close();
                                    } else if ($itemtype == 3) {
                                        $stmt3 = $db->prepare("UPDATE rpg_chars SET legs = ? WHERE id = ?");
                                        $stmt3->bind_param("ii", $itemid, $charid);
                                        if ($stmt3->execute()) {
                                            $ret = "equipped {$GLOBALS['z']}" . $row2["name"] . "#" . $itemid . " as legs";
                                        }
                                        $stmt3->close();
                                    } else if ($itemtype == 4) {
                                        $stmt3 = $db->prepare("UPDATE rpg_chars SET cape = ? WHERE id = ?");
                                        $stmt3->bind_param("ii", $itemid, $charid);
                                        if ($stmt3->execute()) {
                                            $ret = "equipped {$GLOBALS['z']}" . $row2["name"] . "#" . $itemid . " as cape";
                                        }
                                        $stmt3->close();
                                    } else if ($itemtype == 5) {
                                       $stmt3 = $db->prepare("UPDATE rpg_chars SET ring = ? WHERE id = ?");
                                       $stmt3->bind_param("ii", $itemid, $charid);
                                       if ($stmt3->execute()) {
                                           $ret = "equipped {$GLOBALS['z']}" . $row2["name"] . "#" . $itemid . " as ring";
                                       }
                                       $stmt3->close();
                                   }

                                    $stmt3 = $db->prepare("UPDATE rpg_items SET price = -1 WHERE id = ?");
                                    $stmt3->bind_param("i", $itemid);
                                    $stmt3->execute();
                                    $stmt3->close();
                                    
                                    $stats = getStatsData($db, $char);
                                    $charMaxHp = intval($stats["maxhp"]);
                                    $charMaxMp = intval($stats["maxmp"]);
                                    
                                    $stmt3 = $db->prepare("UPDATE rpg_chars SET hp = LEAST(hp, ?), mp = LEAST(mp, ?) WHERE id = ?");
                                    $stmt3->bind_param("iii", $charMaxHp, $charMaxMp, $charid);
                                    $stmt3->execute();
                                    $stmt3->close();
                                }
                            }
                        }
                    }
                }
                $stmt2->close();
            }
        }
    }
    $stmt->close();
    return $ret;
}

function unequip(&$db, $char, $p1)
{
    $ret = "can only unequip weapon, armor, legs, cape or ring";

    if ($p1 == "weapon") {
        $stmt = $db->prepare("UPDATE rpg_chars SET weapon = 0 WHERE LOWER(name) = ?");
        $stmt->bind_param("s", $char);
        if ($stmt->execute()) {
            $ret = "unequipped weapon";
        }
        $stmt->close();
    } else if ($p1 == "armor") {
        $stmt = $db->prepare("UPDATE rpg_chars SET body = 0 WHERE LOWER(name) = ?");
        $stmt->bind_param("s", $char);
        if ($stmt->execute()) {
            $ret = "unequipped armor";
        }
        $stmt->close();
    } else if ($p1 == "legs") {
        $stmt = $db->prepare("UPDATE rpg_chars SET legs = 0 WHERE LOWER(name) = ?");
        $stmt->bind_param("s", $char);
        if ($stmt->execute()) {
            $ret = "unequipped legs";
        }
        $stmt->close();
    } else if ($p1 == "cape") {
        $stmt = $db->prepare("UPDATE rpg_chars SET cape = 0 WHERE LOWER(name) = ?");
        $stmt->bind_param("s", $char);
        if ($stmt->execute()) {
            $ret = "unequipped cape";
        }
        $stmt->close();
    } else if ($p1 == "ring") {
        $stmt = $db->prepare("UPDATE rpg_chars SET ring = 0 WHERE LOWER(name) = ?");
        $stmt->bind_param("s", $char);
        if ($stmt->execute()) {
            $ret = "unequipped ring";
        }
        $stmt->close();
    } else {
        $stats = getStatsData($db, $char);
        $charid = $stats["id"];

        $stmt2 = $db->prepare("SELECT id, name, type FROM rpg_items WHERE inroom = 0 AND ownerid = ?");
        $stmt2->bind_param("i", $charid);
        if ($stmt2->execute()) {
            $result2 = $stmt2->get_result();
            $row_count2 = mysqli_num_rows($result2);
            if ($row_count2 > 0) {
                while ($row2 = mysqli_fetch_array($result2)) {
                    $itemtype = intval($row2["type"]);
                    $itemid = intval($row2["id"]);
                    if ($p1 == strtolower($row2["name"] . "#" . $row2["id"])) {
                        if ($itemtype == 1) {
                            $stmt = $db->prepare("UPDATE rpg_chars SET weapon = 0 WHERE LOWER(name) = ?");
                            $stmt->bind_param("s", $char);
                            if ($stmt->execute()) {
                                $ret = "unequipped weapon";
                            }
                            $stmt->close();
                        }
                        if ($itemtype == 2) {
                            $stmt = $db->prepare("UPDATE rpg_chars SET body = 0 WHERE LOWER(name) = ?");
                            $stmt->bind_param("s", $char);
                            if ($stmt->execute()) {
                                $ret = "unequipped armor";
                            }
                            $stmt->close();
                        }
                        if ($itemtype == 3) {
                            $stmt = $db->prepare("UPDATE rpg_chars SET legs = 0 WHERE LOWER(name) = ?");
                            $stmt->bind_param("s", $char);
                            if ($stmt->execute()) {
                                $ret = "unequipped legs";
                            }
                            $stmt->close();
                        }
                        if ($itemtype == 4) {
                            $stmt = $db->prepare("UPDATE rpg_chars SET cape = 0 WHERE LOWER(name) = ?");
                            $stmt->bind_param("s", $char);
                            if ($stmt->execute()) {
                                $ret = "unequipped cape";
                            }
                            $stmt->close();
                        }
                        if ($itemtype == 5) {
                            $stmt = $db->prepare("UPDATE rpg_chars SET ring = 0 WHERE LOWER(name) = ?");
                            $stmt->bind_param("s", $char);
                            if ($stmt->execute()) {
                                $ret = "unequipped ring";
                            }
                            $stmt->close();
                        }
                    }
                }
            }
        }
    }

    return $ret;
}

function pick(&$db, $char, $p1)
{
    $ret = "";
    $stmt = $db->prepare("SELECT id, current_room FROM rpg_chars WHERE LOWER(name) = ?");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $charid = intval($row["id"]);
                $roomid = intval($row["current_room"]);
                $stmt2 = $db->prepare("SELECT id, name FROM rpg_items WHERE inroom = 1 AND ownerid = ?");
                $stmt2->bind_param("i", $roomid);
                if ($stmt2->execute()) {
                    $result2 = $stmt2->get_result();
                    $row_count2 = mysqli_num_rows($result2);
                    if ($row_count2 > 0) {
                        while ($row2 = mysqli_fetch_array($result2)) {
                            if (strtolower($row2["name"] . "#" . $row2["id"]) == $p1) {
                                $itemid = intval($row2["id"]);
                                $stmt3 = $db->prepare("UPDATE rpg_items SET inroom = 0, ownerid = ? WHERE id = ?");
                                $stmt3->bind_param("ii", $charid, $itemid);
                                if ($stmt3->execute()) {
                                    $ret = $ret . "picked up {$GLOBALS['z']}" . $row2["name"] . "#" . $row2["id"] . " ";
                                }
                                $stmt3->close();
                            }
                        }
                    }
                }
                $stmt2->close();
            }
        }
    }
    $stmt->close();

    if (strlen($ret) < 1) {
        $ret = "failed to pick up {$GLOBALS['z']}" . $p1;
    }

    return $ret;
}

function sell(&$db, $char, $p1, $p2)
{
    $ret = "";

    if ($p1 == "pet") {
        return sellPet($db, $char, $p2);
    }

    $stmt = $db->prepare("SELECT id, weapon, body, legs, cape, ring, current_room FROM rpg_chars WHERE LOWER(name) = ?");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $charid = intval($row["id"]);
                $roomid = intval($row["current_room"]);
                $weapon_id = intval($row["weapon"]);
                $body_id = intval($row["body"]);
                $legs_id = intval($row["legs"]);
                $cape_id = intval($row["cape"]);
                $ring_id = intval($row["ring"]);
                $stmt2 = $db->prepare("SELECT id, name FROM rpg_items WHERE inroom = 0 AND ownerid = ?");
                $stmt2->bind_param("i", $charid);
                if ($stmt2->execute()) {
                    $result2 = $stmt2->get_result();
                    $row_count2 = mysqli_num_rows($result2);
                    if ($row_count2 > 0) {
                        while ($row2 = mysqli_fetch_array($result2)) {
                            if (strtolower($row2["name"] . "#" . $row2["id"]) == $p1) {
                                $itemid = intval($row2["id"]);
                                if ($itemid == $weapon_id || $itemid == $body_id || $itemid == $legs_id || $itemid == $cape_id || $itemid == $ring_id) {
                                    $ret = "cannot sell equipped items";
                                } else {
                                    $price = intval($p2);
                                    if ($price < 0) {
                                        $price = -1;
                                    }
                                    $stmt3 = $db->prepare("UPDATE rpg_items SET price = ? WHERE id = ?");
                                    $stmt3->bind_param("ii", $price, $itemid);
                                    if ($stmt3->execute()) {
                                        if ($price >= 0) {
                                            $ret = $ret . "is selling {$GLOBALS['z']}" . $row2["name"] . "#" . $row2["id"] . " for " . $price . "g";
                                        } else {
                                            $ret = $ret . "is not selling {$GLOBALS['z']}" . $row2["name"] . "#" . $row2["id"];
                                        }
                                    }
                                    $stmt3->close();
                                }
                            }
                        }
                    }
                }
                $stmt2->close();
            }
        }
    }
    $stmt->close();

    if (strlen($ret) < 1) {
        $ret = "failed to drop {$GLOBALS['z']}" . $p1;
    }

    return $ret;
}

function drop(&$db, $char, $p1)
{
    $ret = "";
    $stmt = $db->prepare("SELECT id, weapon, body, legs, cape, ring, current_room FROM rpg_chars WHERE LOWER(name) = ?");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $charid = intval($row["id"]);
                $roomid = intval($row["current_room"]);
                $weapon_id = intval($row["weapon"]);
                $body_id = intval($row["body"]);
                $legs_id = intval($row["legs"]);
                $cape_id = intval($row["cape"]);
                $ring_id = intval($row["ring"]);
                $stmt2 = $db->prepare("SELECT id, name FROM rpg_items WHERE inroom = 0 AND ownerid = ?");
                $stmt2->bind_param("i", $charid);
                if ($stmt2->execute()) {
                    $result2 = $stmt2->get_result();
                    $row_count2 = mysqli_num_rows($result2);
                    if ($row_count2 > 0) {
                        while ($row2 = mysqli_fetch_array($result2)) {
                            if (strtolower($row2["name"] . "#" . $row2["id"]) == $p1) {
                                $itemid = intval($row2["id"]);
                                if ($itemid == $weapon_id || $itemid == $body_id || $itemid == $legs_id || $itemid == $cape_id || $itemid == $ring_id) {
                                    $ret = "cannot drop equipped items";
                                } else {
                                    $stmt3 = $db->prepare("UPDATE rpg_items SET inroom = 1, ownerid = ? WHERE id = ?");
                                    $stmt3->bind_param("ii", $roomid, $itemid);
                                    if ($stmt3->execute()) {
                                        $ret = $ret . "dropped {$GLOBALS['z']}" . $row2["name"] . "#" . $row2["id"] . " ";
                                    }
                                    $stmt3->close();
                                }
                            }
                        }
                    }
                }
                $stmt2->close();
            }
        }
    }
    $stmt->close();

    if (strlen($ret) < 1) {
        $ret = "failed to drop {$GLOBALS['z']}" . $p1;
    }

    return $ret;
}

function sellPet(&$db, $char, $p1)
{
    if ($p1 == "") {
        return "no pet name provided (use sell pet name#id)";
    }

    $stats = getStatsData($db, $char);
    $charid = $stats["id"];

    $stmt2 = $db->prepare("SELECT c.id, c.name, p.cost, p.petid, c.lvl FROM rpg_chars c INNER JOIN rpg_pets p ON c.id = p.petid WHERE isplayer = 2 AND p.ownerid = ?");
    $stmt2->bind_param("i", $charid);

    if ($stmt2->execute()) {
        $result2 = $stmt2->get_result();
        $row_count2 = mysqli_num_rows($result2);
        if ($row_count2 > 0) {
            while ($row2 = mysqli_fetch_array($result2)) {

                if (strtolower($p1) == strtolower($row2["name"] . "#" . $row2["petid"])) {

                    $cost = intval($row2["lvl"]) * 100;

                    $stmt3 = $db->prepare("UPDATE rpg_chars SET gold = gold + ? WHERE id = ?");
                    $stmt3->bind_param("ii", $cost, $charid);
                    $stmt3->execute();
                    $stmt3->close();

                    $petid = $row2["petid"];

                    $stmt3 = $db->prepare("UPDATE rpg_pets SET ownerid = 0 WHERE petid = ?");
                    $stmt3->bind_param("i", $petid);
                    $stmt3->execute();
                    $stmt3->close();

                    $ret = "sold pet {$GLOBALS['z']}" . $row2["name"] . "#" . $row2["petid"] . " for " . $cost . " {$GLOBALS['z']}GOLD";

                }
            }
        } else {
            $ret = "could not find pet {$GLOBALS['z']}" . $p1;
        }
    }
    $stmt2->close();

    return $ret;
}

function buyPet(&$db, $char, $p1, $charid, $chargold)
{
    
    if ($p1 == "") {
        return "no pet name provided (use buy pet name#id)";
    }

    $ret = "";
    $stmt = $db->prepare("SELECT r.id FROM rpg_rooms r INNER JOIN rpg_chars c WHERE LOWER(c.name) = ? AND c.current_room = r.id");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {

                $npets = 0;

                $stmt2 = $db->prepare("SELECT * FROM rpg_pets WHERE ownerid = ?");
                $stmt2->bind_param("i", $charid);

                if ($stmt2->execute()) {
                    $result2 = $stmt2->get_result();
                    $row_count2 = mysqli_num_rows($result2);
                    $npets = $row_count2;
                }
                $stmt2->close();

                if ($npets > 1) {
                    $ret = "can only have 1 pet at a time";
                } else {
                    $roomid = intval($row["id"]);

                    $stmt2 = $db->prepare("SELECT c.id, c.name, p.cost, p.petid, c.lvl FROM rpg_chars c INNER JOIN rpg_pets p ON c.id = p.petid WHERE current_room = ? AND isplayer = 2 AND p.ownerid = 0");
                    $stmt2->bind_param("i", $roomid);

                    if ($stmt2->execute()) {
                        $result2 = $stmt2->get_result();
                        $row_count2 = mysqli_num_rows($result2);
                        if ($row_count2 > 0) {
                            $foundPet = false;
                            while ($row2 = mysqli_fetch_array($result2)) {

                                if (strtolower($p1) == strtolower($row2["name"] . "#" . $row2["petid"])) {
                                    $foundPet = true;
                                    $cost = intval($row2["lvl"]) * 200;
                                    if ($cost > $chargold) {
                                        $ret = "not enough {$GLOBALS['z']}GOLD ( req " . $cost . " )";
                                    } else {

                                        $stmt3 = $db->prepare("UPDATE rpg_chars SET gold = gold - ? WHERE id = ?");
                                        $stmt3->bind_param("ii", $cost, $charid);
                                        $stmt3->execute();
                                        $stmt3->close();

                                        $petid = $row2["petid"];

                                        $stmt3 = $db->prepare("UPDATE rpg_pets SET ownerid = ? WHERE petid = ?");
                                        $stmt3->bind_param("ii", $charid, $petid);
                                        $stmt3->execute();
                                        $stmt3->close();

                                        $ret = "bought pet {$GLOBALS['z']}" . $row2["name"] . " for " . $cost . " {$GLOBALS['z']}GOLD";

                                    }
                                }
                            }
                            if (!$foundPet) {
                                $ret = "could not find pet {$GLOBALS['z']}" . $p1;
                            }
                        } else {
                            $ret = "could not find pet {$GLOBALS['z']}" . $p1;
                        }
                    }
                    $stmt2->close();
                }
            }
        } else {
            $ret = "could not get current room";
        }
    }
    $stmt->close();

    return $ret;
}

function buy(&$db, $char, $p1, $p2)
{

    $stmt = $db->prepare(getStatQuery());
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $attackerRow = $row;
            }
        }
    }
    $stmt->close();

    $buyerId = intval($attackerRow["id"]);
    $buyerGold = intval($attackerRow["gold"]);
    $sellerId = intval($attackerRow["target"]);


    if ($p1 == "pet") {
        return buyPet($db, $char, $p2, $buyerId, $buyerGold);
    }

    $ret = "";

    if (strlen($p2) > 0) {
        $cnt = intval($p2);
    } else {
        $cnt = 0;
    }


    if ($sellerId <= 0) {
        $ret = $ret . "must target a seller";
    } else {

        $stmt = $db->prepare("SELECT r.id FROM rpg_rooms r INNER JOIN rpg_chars c WHERE LOWER(c.name) = ? AND c.current_room = r.id");
        $stmt->bind_param("s", $char);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row_count = mysqli_num_rows($result);
            if ($row_count > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $roomid = intval($row["id"]);
                    $stmt2 = $db->prepare("SELECT id, name, hp_v1, mp_v1, isplayer FROM rpg_chars WHERE current_room = ?");
                    $stmt2->bind_param("i", $roomid);
                    if ($stmt2->execute()) {
                        $result2 = $stmt2->get_result();
                        $row_count2 = mysqli_num_rows($result2);
                        if ($row_count2 > 0) {
                            while ($row2 = mysqli_fetch_array($result2)) {
                                if (intval($row2["id"]) == $sellerId) {
                                    $sellerName = $row2["name"];
                                    $sellerIsPlayer = intval($row2["isplayer"]);

                                    if ($p1 == "hp-pot") {

                                        $sellerHpPot = $row2["hp_v1"];
                                        $cost = $cnt * 40;

                                        if ($sellerIsPlayer != 3) {
                                            $ret = "can only buy pots from merchants";
                                        } else if ($cnt > $sellerHpPot) {
                                            $ret = "{$GLOBALS['z']}" . $sellerName . " does not have enough {$GLOBALS['z']}HP pots";
                                        } else if ($buyerGold < $cost) {
                                            $ret = "does not have enough {$GLOBALS['z']}GOLD ( req " . $cost . " )";
                                        } else {

                                            $stmt3 = $db->prepare("UPDATE rpg_chars SET gold = gold - ?, hp_v1 = hp_v1 + ? WHERE id = ?");
                                            $stmt3->bind_param("iii", $cost, $cnt, $buyerId);
                                            if ($stmt3->execute()) {
                                                $stmt4 = $db->prepare("UPDATE rpg_chars SET gold = gold + ?, hp_v1 = hp_v1 - ? WHERE id = ?");
                                                $stmt4->bind_param("iii", $cost, $cnt, $sellerId);
                                                if ($stmt4->execute()) {
                                                    $ret = "bought " . $cnt . " {$GLOBALS['z']}HP pots from {$GLOBALS['z']}" . $sellerName . " for " . $cost . " {$GLOBALS['z']}GOLD";
                                                }
                                                $stmt4->close();
                                            }
                                            $stmt3->close();
                                        }
                                    } else if ($p1 == "mp-pot") {

                                        $sellerMpPot = $row2["mp_v1"];
                                        $cost = $cnt * 80;

                                        if ($sellerIsPlayer != 3) {
                                            $ret = "can only buy pots from merchants";
                                        } else if ($cnt > $sellerMpPot) {
                                            $ret = "{$GLOBALS['z']}" . $sellerName . " does not have enough {$GLOBALS['z']}MP pots";
                                        } else if ($buyerGold < $cost) {
                                            $ret = "does not have enough {$GLOBALS['z']}GOLD ( req " . $cost . " )";
                                        } else {

                                            $stmt3 = $db->prepare("UPDATE rpg_chars SET gold = gold - ?, mp_v1 = mp_v1 + ? WHERE id = ?");
                                            $stmt3->bind_param("iii", $cost, $cnt, $buyerId);
                                            if ($stmt3->execute()) {
                                                $stmt4 = $db->prepare("UPDATE rpg_chars SET gold = gold + ?, mp_v1 = mp_v1 - ? WHERE id = ?");
                                                $stmt4->bind_param("iii", $cost, $cnt, $sellerId);
                                                if ($stmt4->execute()) {
                                                    $ret = "bought " . $cnt . " {$GLOBALS['z']}MP pots from {$GLOBALS['z']}" . $sellerName . " for " . $cost . " {$GLOBALS['z']}GOLD";
                                                }
                                                $stmt4->close();
                                            }
                                            $stmt3->close();
                                        }


                                    } else {
                                        $stmt3 = $db->prepare("SELECT id, name, price FROM rpg_items WHERE inroom = 0 AND ownerid = ? AND price >= 0");
                                        $stmt3->bind_param("i", $sellerId);
                                        if ($stmt3->execute()) {
                                            $result3 = $stmt3->get_result();
                                            $row_count3 = mysqli_num_rows($result3);
                                            if ($row_count3 > 0) {
                                                $foundItem = false;
                                                while ($row3 = mysqli_fetch_array($result3)) {
                                                    if (strtolower($row3["name"] . "#" . $row3["id"]) == $p1) {
                                                        $itemid = intval($row3["id"]);
                                                        $itemprice = intval($row3["price"]);
                                                        $foundItem = true;

                                                        if ($buyerGold >= $itemprice) {

                                                            $stmt4 = $db->prepare("UPDATE rpg_items SET inroom = 0, ownerid = ?, price = -1 WHERE id = ?");
                                                            $stmt4->bind_param("ii", $buyerId, $itemid);
                                                            if ($stmt4->execute()) {


                                                                $stmt5 = $db->prepare("UPDATE rpg_chars SET gold = gold + ? WHERE id = ?");
                                                                $stmt5->bind_param("ii", $itemprice, $sellerId);
                                                                if ($stmt5->execute()) {

                                                                    $stmt6 = $db->prepare("UPDATE rpg_chars SET gold = gold - ? WHERE id = ?");
                                                                    $stmt6->bind_param("ii", $itemprice, $buyerId);
                                                                    if ($stmt6->execute()) {

                                                                        $ret = $ret . "bought {$GLOBALS['z']}" . $row3["name"] . "#" . $row3["id"] . " from {$GLOBALS['z']}" . $sellerName . " for " . $itemprice . "g";

                                                                    } else {
                                                                        $ret = $ret . "failed to give gold";
                                                                    }
                                                                    $stmt6->close();

                                                                } else {
                                                                    $ret = $ret . "failed to receive gold";
                                                                }
                                                                $stmt5->close();

                                                            } else {
                                                                $ret = $ret . "failed to transfer item";
                                                            }
                                                            $stmt4->close();

                                                        } else {
                                                            $ret = $ret . "does not have enough gold to buy {$GLOBALS['z']}" . $row3["name"] . "#" . $row3["id"] . " (req " . $itemprice . " g)";
                                                        }
                                                    }
                                                }

                                                if (!$foundItem) {
                                                    $ret = "unknown item";
                                                }
                                            }
                                        }
                                        $stmt3->close();
                                    }

                                }
                            }
                        } else {
                            $ret = "No characters in current room";
                        }
                    } else {
                        $ret = "Could not find character in current room";
                    }
                    $stmt2->close();
                }
            } else {
                $ret = "Could not find current room";
            }
        }
        $stmt->close();

    }
    
    if ($ret == "") {
        $ret = "unknown command";
    }

    return $ret;
}

?>
