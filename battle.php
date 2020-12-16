<?

function gainPots(&$db, $char)
{
    $ret = "";
    if (rand(0, 100) <= 20) {
        $stmt = $db->prepare("UPDATE rpg_chars SET hp_v1 = LEAST(50, hp_v1 + 1) WHERE LOWER(name) = ?");
        $stmt->bind_param("s", $char);
        if ($stmt->execute()) {
            $ret = $ret . "{$GLOBALS['z']}HP-pot 1 ";
        }
        $stmt->close();
    }
    if (rand(0, 100) <= 10) {
        $stmt = $db->prepare("UPDATE rpg_chars SET mp_v1 = LEAST(50, mp_v1 + 1) WHERE LOWER(name) = ?");
        $stmt->bind_param("s", $char);
        if ($stmt->execute()) {
            $ret = $ret . "{$GLOBALS['z']}MP-pot 1 ";
        }
        $stmt->close();
    }
    return $ret;
}

function dropItems(&$db, $roomid, $ownerid)
{
    $stmt = $db->prepare("UPDATE rpg_items SET inroom = 1, ownerid = ? WHERE inroom = 0 AND ownerid = ?");
    $stmt->bind_param("ii", $roomid, $ownerid);
    $ret = $stmt->execute();
    $stmt->close();
    return $ret;
}

function killChar(&$db, $kchar)
{
	$ret = "";

    $stmt = $db->prepare("SELECT name, isplayer, lvl, gold, exp, current_room FROM rpg_chars WHERE id = ?");
    $stmt->bind_param("i", $kchar);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if (intval($row["isplayer"]) == 0) {
                    $stmt2 = $db->prepare("DELETE FROM rpg_chars WHERE id = ?");
                    $stmt2->bind_param("i", $kchar);
                    $stmt2->execute();
                    $stmt2->close();

                    $stmt2 = $db->prepare("DELETE FROM rpg_skills WHERE cid = ?");
                    $stmt2->bind_param("i", $kchar);
                    $stmt2->execute();
                    $stmt2->close();
                }
                if (intval($row["isplayer"]) == 1) {
                    
                    $newexp = pow(intval($row["lvl"]), 4);
                    $newgold = intval(intval($row["gold"]) / 2);
                    $diffexp = intval($row["exp"]) - $newexp;
                    $diffgold = intval($row["gold"]) - $newgold;
					$current_room = intval($row["current_room"]);
					$move_room = 1;
					if ($current_room > 101) {
						$move_room = 106;
					}
                    
                    $stmt2 = $db->prepare("UPDATE rpg_chars SET current_room = ?, exp = ?, gold = ? WHERE id = ?");
                    $stmt2->bind_param("iiii", $move_room, $newexp, $newgold, $kchar);
                    $stmt2->execute();
                    $stmt2->close();

                    untarget($db, strtolower($row["name"]));
                    recover($db, strtolower($row["name"]), false);
                    
                    $ret = "lost " . $diffexp . " {$GLOBALS['z']}EXP and " . $diffgold . " {$GLOBALS['z']}GOLD";
                }
            }
        }
    }

    return $ret;
}

function expGain(&$db, $loserExp, $winnerExp, $loserChar, $winnerChar, $loserGold, $winnerGold)
{
    $ret = "";
    $ret = $ret . "{$GLOBALS['z']}" . $loserChar . " was defeated! {$GLOBALS['z']}" . $winnerChar . " gains {$GLOBALS['z']}EXP " . $loserExp . " {$GLOBALS['z']}GOLD " . $loserGold . " ";
    $stmt = $db->prepare("UPDATE rpg_chars SET exp = ?, gold = ?  WHERE LOWER(name) = ?");
    $newexp = $loserExp + $winnerExp;
    $newgold = $loserGold + $winnerGold;
    $winnerchartolower = strtolower($winnerChar);
    $stmt->bind_param("iis", $newexp, $newgold, $winnerchartolower);
    $ok = $stmt->execute();
    $stmt->close();
    if ($ok) {
        return $ret;
    }
    return "failed to gain exp";
}

function getDmg($attacker, $defender)
{
    $dmg = $attacker - $defender;
    if ($dmg < 0) {
        $dmg = 0;
    }
    return $dmg;
}

function getNewHp(&$db, $attackerHp, $dmg, $name)
{
    $newhp = $attackerHp - $dmg;
    $stmt = $db->prepare("UPDATE rpg_chars SET hp = ? WHERE LOWER(name) = ?");
    $stmt->bind_param("is", $newhp, $name);
    $ok = $stmt->execute();
    $stmt->close();
    if ($ok) {
        return $newhp;
    }
    return -1;
}

function checkBattleRoom(&$db, $roomid, $char)
{
    $foundMonsters = false;
    $stmt2 = $db->prepare("SELECT name, isplayer FROM rpg_chars WHERE current_room = ?");
    $stmt2->bind_param("i", $roomid);
    if ($stmt2->execute()) {
        $result2 = $stmt2->get_result();
        $row_count2 = mysqli_num_rows($result2);

        if ($row_count2 > 0) {
            while ($row2 = mysqli_fetch_array($result2)) {
                if (intval($row2["isplayer"]) == 0) {
                    $foundMonsters = true;
                    break;
                }
            }
        }
    }
    $stmt2->close();

    if ($foundMonsters == true) {
        return see($db, $char);
    } else {
        return getConnections($db, $char);
    }
}

function defenderTurn(&$db, $defenderPlusAtk, $attackerPlusDef, $attackerPlusEvd, $defenderName, $attackerHp, $attackerName, $attackerRoom, $attackerId, $attackerExp, $defenderExp, $attackerGold, $defenderGold, $prepend, $defenderHp, $defenderMp, $defenderMaxHp, $defenderMaxMp)
{
    $arr = array();
    $exitBattle = false;
    $ret = "";
    $dmg = getDmg($defenderPlusAtk, $attackerPlusDef);
    $defenderStats = " " . $defenderHp . "/" . $defenderMaxHp . " {$GLOBALS['z']}HP " . $defenderMp . "/" . $defenderMaxMp . " {$GLOBALS['z']}MP ";
    if (rand(0, 100) < $attackerPlusEvd) {
        $ret = $ret . " {$GLOBALS['z']}" . $defenderName . $defenderStats . $prepend . "missed! ";
    } else {
        $newhp = getNewHp($db, $attackerHp, $dmg, strtolower($attackerName));
        $ret = $ret . " {$GLOBALS['z']}" . $defenderName . $defenderStats . $prepend . "hits {$GLOBALS['z']}" . $attackerName . " for " . $dmg . " damage ";
        if ($newhp <= 0) {
            //dropItems($db, $attackerRoom, $attackerId);
            $ret = $ret . " {$GLOBALS['z']}" . $attackerName . " was defeated! " . killChar($db, $attackerId);
            //$ret = $ret . expGain($db, $attackerExp, $defenderExp, $attackerName, $defenderName, $attackerGold, $defenderGold) . lvlUp($db, strtolower($defenderName)) . gainPots($db, strtolower($defenderName));
            $exitBattle = true;
            untarget($db, strtolower($defenderName));
        } else {
            $ret = $ret . "(" . $newhp . " {$GLOBALS['z']}HP left)";
        }
    }
    array_push($arr, $exitBattle);
    array_push($arr, $ret);
    return $arr;
}

function attackerTurn(&$db, $attackerPlusAtk, $defenderPlusDef, $defenderPlusEvd, $attackerName, $defenderHp, $defenderName, $attackerRoom, $defenderId, $defenderExp, $attackerExp, $defenderGold, $attackerGold)
{
    $arr = array();
    $exitBattle = false;
    $ret = "";
    $dmg = getDmg($attackerPlusAtk, $defenderPlusDef);
    if (rand(0, 100) < $defenderPlusEvd) {
        $ret = $ret . " missed! ";
    } else {
        $newhp = getNewHp($db, $defenderHp, $dmg, strtolower($defenderName));
        $ret = $ret . " hits {$GLOBALS['z']}" . $defenderName . " for " . $dmg . " damage ";
        if ($newhp <= 0) {
            dropItems($db, $attackerRoom, $defenderId);
            killChar($db, $defenderId);
            $ret = $ret . expGain($db, $defenderExp, $attackerExp, $defenderName, $attackerName, $defenderGold, $attackerGold) . lvlUp($db, strtolower($attackerName)) . gainPots($db, strtolower($attackerName));
            $exitBattle = true;
            untarget($db, strtolower($attackerName));
            
            $ret = $ret . checkBattleRoom($db, $attackerRoom, $attackerName);
        } else {
            $ret = $ret . "(" . $newhp . " {$GLOBALS['z']}HP left)";
        }
    }
    array_push($arr, $exitBattle);
    array_push($arr, $ret);
    return $arr;
}

function attack(&$db, $char, $paramTarget, $specId, $ret = "")
{

    if (strlen($paramTarget) > 0) {
        target($db, $char, $paramTarget);
    }

    $attackerRow = getStatsData($db, $char);

    $attackerId = $attackerRow["id"];
    $defenderId = $attackerRow["target"];

    if ($attackerId == $defenderId) {
        $ret = "cannot attack itself";
    } else if ($defenderId < 0) {
        $ret = "unknown target";
    } else if ($defenderId == 0) {
        $ret = "has no target";
    } else {

        $defenderName = getCharNameById($db, $defenderId);

        $foundDefender = false;
        if (strlen($defenderName) > 0) {
            $defenderRow = getStatsData($db, $defenderName);
            $foundDefender = true;
        }

        if ($foundDefender) {

            // defender type
            $defenderType = $defenderRow["isplayer"];

            // name & exp
            $attackerName = $attackerRow["name"];
            $defenderName = $defenderRow["name"];
            $attackerExp = $attackerRow["exp"];
            $defenderExp = $defenderRow["exp"];
            $attackerGold = $attackerRow["gold"];
            $defenderGold = $defenderRow["gold"];
            $attackerHp = $attackerRow["hp"];
            $defenderHp = $defenderRow["hp"];
            $attackerMaxHp = $attackerRow["maxhp"];
            $defenderMaxHp = $defenderRow["maxhp"];
            $attackerMp = $attackerRow["mp"];
            $defenderMp = $defenderRow["mp"];
            $attackerMaxMp = $attackerRow["maxmp"];
            $defenderMaxMp = $defenderRow["maxmp"];
            $attackerAtp = $attackerRow["atp"];
            $defenderAtp = $defenderRow["atp"];
            $attackerStamina = $attackerRow["stamina"];

            $attackerSpd = $attackerRow["spd"];
            $defenderSpd = $defenderRow["spd"];

            // stats
            $attackerPlusAtk = $attackerRow["atk"];
            $attackerPlusDef = $attackerRow["def"];
            $attackerPlusSpd = $attackerRow["spd"];
            $attackerPlusEvd = $attackerRow["evd"];
            $defenderPlusAtk = $defenderRow["atk"];
            $defenderPlusDef = $defenderRow["def"];
            $defenderPlusSpd = $defenderRow["spd"];
            $defenderPlusEvd = $defenderRow["evd"];

            $attackerInt = $attackerRow["int"];
            $defenderInt = $defenderRow["int"];
            $attackerFireRes = $attackerRow["fire_res"];
            $defenderFireRes = $defenderRow["fire_res"];
            $attackerWaterRes = $attackerRow["water_res"];
            $defenderWaterRes = $defenderRow["water_res"];
            $attackerWindRes = $attackerRow["wind_res"];
            $defenderWindRes = $defenderRow["wind_res"];
            $attackerGroundRes = $attackerRow["ground_res"];
            $defenderGroundRes = $defenderRow["ground_res"];
            $attackerLightRes = $attackerRow["light_res"];
            $defenderLightRes = $defenderRow["light_res"];
            $attackerDarkRes = $attackerRow["dark_res"];
            $defenderDarkRes = $defenderRow["dark_res"];

            // add randomness

            $attackerPlusSpd += rand(0, $attackerPlusSpd);
            $defenderPlusSpd += rand(0, $defenderPlusSpd);
            $attackerPlusEvd += rand(0, $attackerPlusEvd);
            $defenderPlusEvd += rand(0, $defenderPlusEvd);

            $attackerPenalty = 0;
            $defenderPenalty = 0;
            $resMulti = 15;

            // set evade

            if ($attackerPlusEvd > $defenderPlusEvd) {
                $attackerPlusEvd = $attackerPlusEvd - $defenderPlusEvd + 1;
                $defenderPlusEvd = 1;
            } else {
                $defenderPlusEvd = $defenderPlusEvd - $attackerPlusEvd + 1;
                $attackerPlusEvd = 1;
            }

            $attackerPlusEvd = intval(log($attackerPlusEvd, 1.5));
            $defenderPlusEvd = intval(log($defenderPlusEvd, 1.5));

            if ($attackerPlusEvd > 95) {
                $attackerPlusEvd = 95;
            }
            if ($defenderPlusEvd > 95) {
                $defenderPlusEvd = 95;
            }

            if ($specId == 4) { // fire
                $attackerPlusAtk = $attackerInt + rand(0, $attackerInt);
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderFireRes * $resMulti;
                $attackerPenalty = 8;
            } else if ($specId == 5) {
                $attackerPlusAtk = ($attackerInt + rand(0, $attackerInt)) * 2;
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderFireRes * $resMulti;
                $attackerPenalty = 10;
            } else if ($specId == 6) {
                $attackerPlusAtk = ($attackerInt + rand(0, $attackerInt)) * 3;
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderFireRes * $resMulti;
                $attackerPenalty = 12;
            } else if ($specId == 7) { // water
                $attackerPlusAtk = $attackerInt + rand(0, $attackerInt);
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderWaterRes * $resMulti;
                $attackerPenalty = 8;
            } else if ($specId == 8) {
                $attackerPlusAtk = ($attackerInt + rand(0, $attackerInt)) * 2;
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderWaterRes * $resMulti;
                $attackerPenalty = 10;
            } else if ($specId == 9) {
                $attackerPlusAtk = ($attackerInt + rand(0, $attackerInt)) * 3;
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderWaterRes * $resMulti;
                $attackerPenalty = 12;
            } else if ($specId == 10) { // ground
                $attackerPlusAtk = $attackerInt + rand(0, $attackerInt);
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderGroundRes * $resMulti;
                $attackerPenalty = 8;
            } else if ($specId == 11) {
                $attackerPlusAtk = ($attackerInt + rand(0, $attackerInt)) * 2;
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderGroundRes * $resMulti;
                $attackerPenalty = 10;
            } else if ($specId == 12) {
                $attackerPlusAtk = ($attackerInt + rand(0, $attackerInt)) * 3;
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderGroundRes * $resMulti;
                $attackerPenalty = 12;
            } else if ($specId == 13) { // wind
                $attackerPlusAtk = $attackerInt + rand(0, $attackerInt);
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderWindRes * $resMulti;
                $attackerPenalty = 8;
            } else if ($specId == 14) {
                $attackerPlusAtk = ($attackerInt + rand(0, $attackerInt)) * 2;
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderWindRes * $resMulti;
                $attackerPenalty = 10;
            } else if ($specId == 15) {
                $attackerPlusAtk = ($attackerInt + rand(0, $attackerInt)) * 3;
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderWindRes * $resMulti;
                $attackerPenalty = 12;
            } else if ($specId == 16) { // harm
                $attackerPlusAtk = $attackerInt + rand(0, $attackerInt);
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderDarkRes * $resMulti;
                $attackerPenalty = 8;
            } else if ($specId == 17) {
                $attackerPlusAtk = ($attackerInt + rand(0, $attackerInt)) * 2;
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderDarkRes * $resMulti;
                $attackerPenalty = 10;
            } else if ($specId == 18) {
                $attackerPlusAtk = ($attackerInt + rand(0, $attackerInt)) * 3;
                $defenderPlusDef = intval($defenderPlusDef / 2) + $defenderDarkRes * $resMulti;
                $attackerPenalty = 12;
            } else if ($specId == 20) {
                $attackerPlusAtk += rand(0, $attackerPlusAtk);
                $defenderPlusDef += rand(0, $defenderPlusDef);
                $attackerPlusAtk = intval($attackerPlusAtk / 2);
                $attackerPlusDef = $attackerPlusDef * 2;
                $attackerPenalty = 2;
            } else if ($specId == 22) {
                $attackerPlusAtk += rand(0, $attackerPlusAtk);
                $defenderPlusDef += rand(0, $defenderPlusDef);
                $attackerPlusAtk += $attackerPlusEvd * 33;
                $attackerPenalty = 12;
            } else if ($specId == 23) {
                $attackerPlusAtk += rand(0, $attackerPlusAtk);
                $defenderPlusDef += rand(0, $defenderPlusDef);
                $attackerPlusAtk = $attackerPlusAtk * 2;
                $attackerPlusDef = intval($attackerPlusDef / 2);
                $attackerPenalty = 4;
            } else if ($specId == 24) {
                $attackerPlusAtk += rand(0, $attackerPlusAtk);
                $defenderPlusDef += rand(0, $defenderPlusDef);
                $attackerPlusSpd = $attackerPlusSpd * 1.2;
                $attackerPenalty = -24;
            } else { // normal fight
                $attackerPlusAtk += rand(0, $attackerPlusAtk);
                $defenderPlusDef += rand(0, $defenderPlusDef);
            }

            $defenderSkills = array();
            $stmt = $db->prepare("SELECT sid FROM rpg_skills WHERE cid = ?");
            $stmt->bind_param("i", $defenderId);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $row_count = mysqli_num_rows($result);
                if ($row_count > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        array_push($defenderSkills, intval($row["sid"]));
                    }
                }
            }
            $stmt->close();

            $defenderUseSkill = false;

            if (count($defenderSkills) > 0 && $defenderMp > 20) {
                if ($defenderInt > $defenderPlusAtk) {
                    if (rand(1, 100) <= 90) {
                        $defenderUseSkill = true;
                    }
                } else {
                    if (rand(1, 100) <= 10) {
                        $defenderUseSkill = true;
                    }
                }
            }

            $defenderSkillName = "";
            $defenderSpecId = -1;

            if ($defenderUseSkill) {

                $defenderSpecId = $defenderSkills[rand(0, count($defenderSkills) - 1)];

                if ($defenderSpecId == 4) { // fire
                    $defenderPlusAtk = $defenderInt + rand(0, $defenderInt);
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerFireRes * $resMulti;
                    $defenderPenalty = 8;
                } else if ($defenderSpecId == 5) {
                    $defenderPlusAtk = ($defenderInt + rand(0, $defenderInt)) * 2;
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerFireRes * $resMulti;
                    $defenderPenalty = 10;
                } else if ($defenderSpecId == 6) {
                    $defenderPlusAtk = ($defenderInt + rand(0, $defenderInt)) * 3;
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerFireRes * $resMulti;
                    $defenderPenalty = 12;
                } else if ($defenderSpecId == 7) { // water
                    $defenderPlusAtk = $defenderInt + rand(0, $defenderInt);
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerWaterRes * $resMulti;
                    $defenderPenalty = 8;
                } else if ($defenderSpecId == 8) {
                    $defenderPlusAtk = ($defenderInt + rand(0, $defenderInt)) * 2;
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerWaterRes * $resMulti;
                    $defenderPenalty = 10;
                } else if ($defenderSpecId == 9) {
                    $defenderPlusAtk = ($defenderInt + rand(0, $defenderInt)) * 3;
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerWaterRes * $resMulti;
                    $defenderPenalty = 12;
                } else if ($defenderSpecId == 10) { // ground
                    $defenderPlusAtk = $defenderInt + rand(0, $defenderInt);
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerGroundRes * $resMulti;
                    $defenderPenalty = 8;
                } else if ($defenderSpecId == 11) {
                    $defenderPlusAtk = ($defenderInt + rand(0, $defenderInt)) * 2;
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerGroundRes * $resMulti;
                    $defenderPenalty = 10;
                } else if ($defenderSpecId == 12) {
                    $defenderPlusAtk = ($defenderInt + rand(0, $defenderInt)) * 3;
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerGroundRes * $resMulti;
                    $defenderPenalty = 12;
                } else if ($defenderSpecId == 13) { // wind
                    $defenderPlusAtk = $defenderInt + rand(0, $defenderInt);
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerWindRes * $resMulti;
                    $defenderPenalty = 8;
                } else if ($defenderSpecId == 14) {
                    $defenderPlusAtk = ($defenderInt + rand(0, $defenderInt)) * 2;
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerWindRes * $resMulti;
                    $defenderPenalty = 10;
                } else if ($defenderSpecId == 15) {
                    $defenderPlusAtk = ($defenderInt + rand(0, $defenderInt)) * 3;
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerWindRes * $resMulti;
                    $defenderPenalty = 12;
                } else if ($defenderSpecId == 16) { // harm
                    $defenderPlusAtk = $defenderInt + rand(0, $defenderInt);
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerDarkRes * $resMulti;
                    $defenderPenalty = 8;
                } else if ($defenderSpecId == 17) {
                    $defenderPlusAtk = ($defenderInt + rand(0, $defenderInt)) * 2;
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerDarkRes * $resMulti;
                    $defenderPenalty = 10;
                } else if ($defenderSpecId == 18) {
                    $defenderPlusAtk = ($defenderInt + rand(0, $defenderInt)) * 3;
                    $attackerPlusDef = intval($attackerPlusDef / 2) + $attackerDarkRes * $resMulti;
                    $defenderPenalty = 12;
                } else if ($defenderSpecId == 20) {
                    $defenderPlusAtk += rand(0, $defenderPlusAtk);
                    $attackerPlusDef += rand(0, $attackerPlusDef);
                    $defenderPlusAtk = intval($defenderPlusAtk / 2);
                    $defenderPlusDef = $defenderPlusDef * 2;
                    $defenderPenalty = 2;
                } else if ($defenderSpecId == 22) {
                    $defenderPlusAtk += rand(0, $defenderPlusAtk);
                    $attackerPlusDef += rand(0, $attackerPlusDef);
                    $defenderPlusAtk += $defenderPlusEvd * 33;
                    $defenderPenalty = 12;
                } else if ($defenderSpecId == 23) {
                    $defenderPlusAtk += rand(0, $defenderPlusAtk);
                    $attackerPlusDef += rand(0, $attackerPlusDef);
                    $defenderPlusAtk = $defenderPlusAtk * 2;
                    $defenderPlusDef = intval($defenderPlusDef / 2);
                    $defenderPenalty = 4;
                } else if ($defenderSpecId == 24) {
                    $defenderPlusAtk += rand(0, $defenderPlusAtk);
                    $attackerPlusDef += rand(0, $attackerPlusDef);
                    $defenderPlusSpd = $defenderPlusSpd * 1.2;
                    $defenderPenalty = -24;
                }

                $defenderSkillName = "uses skill {$GLOBALS['z']}" . getSkillName($defenderSpecId) . " ";

            } else {
                $defenderPlusAtk += rand(0, $defenderPlusAtk);
                $attackerPlusDef += rand(0, $attackerPlusDef);
            }

            // get room type
            $attackerRoom = $attackerRow["current_room"];
            $roomType = -1;
            $stmt = $db->prepare("SELECT type FROM rpg_rooms WHERE id = ?");
            $stmt->bind_param("i", $attackerRoom);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $row_count = mysqli_num_rows($result);
                if ($row_count > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $roomType = intval($row["type"]);
                    }
                }
            }
            $stmt->close();
        }

        if (!$foundDefender) {
            $ret = "unknown target";
        } else if ($attackerStamina < 1) {
            $ret = "is out of stamina and cannot attack (use action: day)";
        } else if ($roomType == 0 && $defenderType == 0) {

            reduceStamina($db, $char);
            $exitBattle = false;

            if ($attackerSpd < 1) {
                $attackerSpd = 1;
            }

            if ($defenderSpd < 1) {
                $defenderSpd = 1;
            }

            $attackerAtp += $attackerSpd;
            $defenderAtp += $defenderSpd;

            $atpLimit = max($attackerRow["spd"], $defenderRow["spd"]);

            if ($attackerAtp < $atpLimit) {
                $ret = $attackerHp . "/" . $attackerMaxHp . " {$GLOBALS['z']}HP " . $attackerMp . "/" . $attackerMaxMp . " {$GLOBALS['z']}MP " . $ret;
                $ret = $ret . "not enough {$GLOBALS['z']}ATP " . $attackerAtp . "/" . $atpLimit . " ";
            }

            if ($attackerAtp >= $atpLimit || $defenderAtp >= $atpLimit) {

                if ($attackerAtp > $defenderAtp) {

                    $newmp = $attackerMp;
                    if ($specId > 0) {
                        $newmp = reduceMp($db, $attackerId, 10);
                    }

                    $ret = $attackerHp . "/" . $attackerMaxHp . " {$GLOBALS['z']}HP " . $newmp . "/" . $attackerMaxMp . " {$GLOBALS['z']}MP " . $ret;
                    $battleResult = attackerTurn($db, $attackerPlusAtk, $defenderPlusDef, $defenderPlusEvd, $attackerName, $defenderHp, $defenderName, $attackerRoom, $defenderId, $defenderExp, $attackerExp, $defenderGold, $attackerGold);
                    $exitBattle = $battleResult[0];
                    $ret = $ret . $battleResult[1];

                    if (!$exitBattle && $defenderAtp >= $atpLimit) {

                        $newmp = $defenderMp;
                        if ($defenderSpecId > 0) {
                            $newmp = reduceMp($db, $defenderId, 10);
                        }

                        $battleResult = defenderTurn($db, $defenderPlusAtk, $attackerPlusDef, $attackerPlusEvd, $defenderName, $attackerHp, $attackerName, $attackerRoom, $attackerId, $attackerExp, $defenderExp, $attackerGold, $defenderGold, $defenderSkillName, $defenderHp, $newmp, $defenderMaxHp, $defenderMaxMp);
                        $exitBattle = $battleResult[0];
                        $ret = $ret . $battleResult[1];
                    }
                } else {

                    $newmp = $defenderMp;
                    if ($defenderSpecId > 0) {
                        $newmp = reduceMp($db, $defenderId, 10);
                    }

                    $battleResult = defenderTurn($db, $defenderPlusAtk, $attackerPlusDef, $attackerPlusEvd, $defenderName, $attackerHp, $attackerName, $attackerRoom, $attackerId, $attackerExp, $defenderExp, $attackerGold, $defenderGold, $defenderSkillName, $defenderHp, $newmp, $defenderMaxHp, $defenderMaxMp);
                    $exitBattle = $battleResult[0];
                    $ret = $ret . $battleResult[1];

                    if (!$exitBattle && $attackerAtp >= $atpLimit) {

                        $newmp = $attackerMp;
                        if ($specId > 0) {
                            $newmp = reduceMp($db, $attackerId, 10);
                        }

                        $ret = $attackerHp . "/" . $attackerMaxHp . " {$GLOBALS['z']}HP " . $newmp . "/" . $attackerMaxMp . " {$GLOBALS['z']}MP " . $ret;
                        $battleResult = attackerTurn($db, $attackerPlusAtk, $defenderPlusDef, $defenderPlusEvd, $attackerName, $defenderHp, $defenderName, $attackerRoom, $defenderId, $defenderExp, $attackerExp, $defenderGold, $attackerGold);
                        $exitBattle = $battleResult[0];
                        $ret = $ret . $battleResult[1];
                    }
                }
            } else {
                $ret = "both characters are regaining {$GLOBALS['z']}ATP";
            }

            $attackerPenalty = -$attackerPenalty + intval(($attackerAtp - $atpLimit) / 2);
            $defenderPenalty = -$defenderPenalty + intval(($defenderAtp - $atpLimit) / 2);
            if ($attackerPenalty > $attackerSpd) {
                $attackerPenalty = $attackerSpd;
            }
            if ($defenderPenalty > $defenderSpd) {
                $defenderPenalty = $defenderSpd;
            }

            if ($attackerAtp >= $atpLimit) {
                $stmt = $db->prepare("UPDATE rpg_chars SET atp = ? WHERE id = ?");
                $stmt->bind_param("ii", $attackerPenalty, $attackerId);
                $stmt->execute();
            } else {
                $stmt = $db->prepare("UPDATE rpg_chars SET atp = ? WHERE id = ?");
                $stmt->bind_param("ii", $attackerAtp, $attackerId);
                $stmt->execute();
            }

            if ($defenderAtp >= $atpLimit) {
                $stmt = $db->prepare("UPDATE rpg_chars SET atp = ? WHERE id = ?");
                $stmt->bind_param("ii", $defenderPenalty, $defenderId);
                $stmt->execute();
            } else {
                $stmt = $db->prepare("UPDATE rpg_chars SET atp = ? WHERE id = ?");
                $stmt->bind_param("ii", $defenderAtp, $defenderId);
                $stmt->execute();
            }


        } else {
            $ret = $ret . "cannot attack {$GLOBALS['z']}" . $defenderName . " in this room";
        }
    }
    return $ret;
}

?>
