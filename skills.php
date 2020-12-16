<?

function reduceMp(&$db, $charid, $amount)
{
    $stmt = $db->prepare("UPDATE rpg_chars SET mp = mp - ? WHERE id = ?");
    $stmt->bind_param("ii", $amount, $charid);
    $stmt->execute();
    $stmt->close();

    $stmt = $db->prepare("SELECT mp FROM rpg_chars WHERE id = ?");
    $stmt->bind_param("i", $charid);

    $ret = -1;

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $ret = intval($row["mp"]);
            }
        }
    }

    $stmt->close();
    return $ret;
}

function resetSkills(&$db, $char)
{
    $stats = getStatsData($db, $char);
	
	if ($GLOBALS['dev'] == false && $stats["lvl"] % 10 != 0) {
		return "can only reset every 10th level (10, 20, 30, ...)";
	}
	
    $charid = $stats["id"];

    $stmt = $db->prepare("SELECT r.type FROM rpg_rooms r INNER JOIN rpg_chars c WHERE LOWER(c.name) = ? AND c.current_room = r.id");
    $stmt->bind_param("s", $char);

    $saferoom = false;
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if (intval($row["type"]) == 1) {
                    $saferoom = true;
                }
            }
        }
    }

    if ($saferoom) {
        $stmt = $db->prepare("DELETE FROM rpg_skills WHERE cid = ?");
        $stmt->bind_param("i", $charid);
        $stmt->execute();

        $stmt = $db->prepare("UPDATE rpg_chars SET sp = lvl WHERE id = ?");
        $stmt->bind_param("i", $charid);
        $stmt->execute();

        return "has reset skills";
    }
    return "can only reset skills in safe rooms";
}

function resetStats(&$db, $char)
{
    $stats = getStatsData($db, $char);
	
	if ($GLOBALS['dev'] == false && $stats["lvl"] % 10 != 0) {
		return "can only reset every 10th level (10, 20, 30, ...)";
	}
	
    $charid = $stats["id"];
    $newcp = 10 * ($stats["lvl"] - 1);

    $stmt = $db->prepare("SELECT r.type FROM rpg_rooms r INNER JOIN rpg_chars c WHERE LOWER(c.name) = ? AND c.current_room = r.id");
    $stmt->bind_param("s", $char);

    $saferoom = false;
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if (intval($row["type"]) == 1) {
                    $saferoom = true;
                }
            }
        }
    }

    if ($saferoom) {
        $stmt = $db->prepare("DELETE FROM rpg_classes WHERE charid = ?");
        $stmt->bind_param("i", $charid);
        $stmt->execute();

        $stmt = $db->prepare("UPDATE rpg_chars SET maxhp=100, hp=100, maxmp=50, mp=50, atk=20, def=20, spd=20, evd=20, int_stat=20, fire_res=0, water_res=0, wind_res=0, ground_res=0, light_res=0, dark_res=0, cp=? WHERE id = ?");
        $stmt->bind_param("ii", $newcp, $charid);
        $stmt->execute();

        return "has reset stats and class";
    }
    return "can only reset stats and class in safe rooms";
}

function useSkill(&$db, $char, $p1, $p2)
{

    $chartarget = -1;

    if (strlen($p2) > 0) {
        target($db, $char, $p2);
    }

    $ret = "";
    $skillId = getSkillId($p1);
    if ($skillId == -1) {
        $ret = "unknown skill " . $p1;
    } else {

        $foundSkill = false;
        $stmt = $db->prepare("SELECT c.id, c.mp, c.target FROM rpg_skills s INNER JOIN rpg_chars c ON s.cid = c.id WHERE LOWER(c.name) = ? AND s.sid = ?;");
        $stmt->bind_param("si", $char, $skillId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row_count = mysqli_num_rows($result);
            if ($row_count > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $charid = intval($row["id"]);
                    $charmp = intval($row["mp"]);
                    $chartarget = intval($row["target"]);
                    $foundSkill = true;
                }
            }
        }
        $stmt->close();

        if ($foundSkill) {

            if ($chartarget <= 0) {
                $ret = $ret . "has no target";
            } else {
                
                $casterStats = getStatsData($db, $char);
                $targetStats = getStatsData($db, getCharNameById($db, $chartarget));
                $targetMaxHp = $targetStats["maxhp"];
                $casterInt = $casterStats["int"];

                $targetLightRes = $targetStats["light_res"];
                $targetDarkRes = $targetStats["dark_res"];
                $targetIsPlayer = $targetStats["isplayer"];

                if ($skillId == 1) {
                    
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        
                        $ret = $casterStats["hp"] . "/" . $casterStats["maxhp"] . " {$GLOBALS['z']}HP " . $casterStats["mp"] . "/" . $casterStats["maxmp"] . " {$GLOBALS['z']}MP " . $ret;
                        
                        $hpIncrease = intval($casterInt / 4);

                        if ($targetIsPlayer == 0) {
                            $hpIncrease -= $targetLightRes;
                        }

                        $stmt = $db->prepare("UPDATE rpg_chars SET hp = LEAST(hp + ?, ?) WHERE id = ?");
                        $stmt->bind_param("iii", $hpIncrease, $targetMaxHp, $chartarget);
                        if ($stmt->execute()) {
                            $stmt2 = $db->prepare("UPDATE rpg_chars SET mp = mp - 10 WHERE id = ?");
                            $stmt2->bind_param("i", $charid);
                            if ($stmt2->execute()) {
                                $ret = $ret . "healed {$GLOBALS['z']}" . getCharNameById($db, $chartarget) . " for " . $hpIncrease . " {$GLOBALS['z']}HP ";
                                reduceAtp($db, $char, 8);

                                $newhp = $targetStats["hp"] + $hpIncrease;
                                if ($newhp > $targetMaxHp) {
                                    $newhp = $targetMaxHp;
                                }

                                if ($newhp <= 0) {
                                    dropItems($db, $casterStats["current_room"], $targetStats["id"]);
                                    killChar($db, $targetStats["id"]);
                                    $ret = $ret . expGain($db, $targetStats["exp"], $casterStats["exp"], $targetStats["name"], $casterStats["name"], $targetStats["gold"], $casterStats["gold"]) . lvlUp($db, strtolower($casterStats["name"])) . gainPots($db, strtolower($casterStats["name"]));
                                    untarget($db, strtolower($casterStats["name"]));
                                    $ret = $ret . checkBattleRoom($db, $casterStats["current_room"], $casterStats["name"]);
                                } else {
                                    $ret = $ret . "(" . $newhp . "/" . $targetMaxHp . " {$GLOBALS['z']}HP left)";
                                }
                            }
                            $stmt2->close();
                        }
                        $stmt->close();
                    }
                } else if ($skillId == 2) {
                    
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        
                        $ret = $casterStats["hp"] . "/" . $casterStats["maxhp"] . " {$GLOBALS['z']}HP " . $casterStats["mp"] . "/" . $casterStats["maxmp"] . " {$GLOBALS['z']}MP " . $ret;

                        $hpIncrease = intval($casterInt / 3);

                        if ($targetIsPlayer == 0) {
                            $hpIncrease -= $targetLightRes;
                        }

                        $stmt = $db->prepare("UPDATE rpg_chars SET hp = LEAST(hp + ?, ?) WHERE id = ?");
                        $stmt->bind_param("iii", $hpIncrease, $targetMaxHp, $chartarget);
                        if ($stmt->execute()) {
                            $stmt2 = $db->prepare("UPDATE rpg_chars SET mp = mp - 10 WHERE id = ?");
                            $stmt2->bind_param("i", $charid);
                            if ($stmt2->execute()) {
                                $ret = $ret . "healed {$GLOBALS['z']}" . getCharNameById($db, $chartarget) . " for " . $hpIncrease . " {$GLOBALS['z']}HP ";
                                reduceAtp($db, $char, 10);

                                $newhp = $targetStats["hp"] + $hpIncrease;
                                if ($newhp > $targetMaxHp) {
                                    $newhp = $targetMaxHp;
                                }

                                if ($newhp <= 0) {
                                    dropItems($db, $casterStats["current_room"], $targetStats["id"]);
                                    killChar($db, $targetStats["id"]);
                                    $ret = $ret . expGain($db, $targetStats["exp"], $casterStats["exp"], $targetStats["name"], $casterStats["name"], $targetStats["gold"], $casterStats["gold"]) . lvlUp($db, strtolower($casterStats["name"])) . gainPots($db, strtolower($casterStats["name"]));
                                    untarget($db, strtolower($casterStats["name"]));
                                    $ret = $ret . checkBattleRoom($db, $casterStats["current_room"], $casterStats["name"]);
                                } else {
                                    $ret = $ret . "(" . $newhp . "/" . $targetMaxHp . " {$GLOBALS['z']}HP left)";
                                }
                            }
                            $stmt2->close();
                        }
                        $stmt->close();
                    }
                } else if ($skillId == 3) {
                    
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        
                        $ret = $casterStats["hp"] . "/" . $casterStats["maxhp"] . " {$GLOBALS['z']}HP " . $casterStats["mp"] . "/" . $casterStats["maxmp"] . " {$GLOBALS['z']}MP " . $ret;
                        
                        $hpIncrease = intval($casterInt / 2);

                        if ($targetIsPlayer == 0) {
                            $hpIncrease -= $targetLightRes;
                        }

                        $stmt = $db->prepare("UPDATE rpg_chars SET hp = LEAST(hp + ?, ?) WHERE id = ?");
                        $stmt->bind_param("iii", $hpIncrease, $targetMaxHp, $chartarget);
                        if ($stmt->execute()) {
                            $stmt2 = $db->prepare("UPDATE rpg_chars SET mp = mp - 10 WHERE id = ?");
                            $stmt2->bind_param("i", $charid);
                            if ($stmt2->execute()) {
                                $ret = $ret . "healed {$GLOBALS['z']}" . getCharNameById($db, $chartarget) . " for " . $hpIncrease . " {$GLOBALS['z']}HP ";
                                reduceAtp($db, $char, 12);

                                $newhp = $targetStats["hp"] + $hpIncrease;
                                if ($newhp > $targetMaxHp) {
                                    $newhp = $targetMaxHp;
                                }

                                if ($newhp <= 0) {
                                    dropItems($db, $casterStats["current_room"], $targetStats["id"]);
                                    killChar($db, $targetStats["id"]);
                                    $ret = $ret . expGain($db, $targetStats["exp"], $casterStats["exp"], $targetStats["name"], $casterStats["name"], $targetStats["gold"], $casterStats["gold"]) . lvlUp($db, strtolower($casterStats["name"])) . gainPots($db, strtolower($casterStats["name"]));
                                    untarget($db, strtolower($casterStats["name"]));
                                    $ret = $ret . checkBattleRoom($db, $casterStats["current_room"], $casterStats["name"]);
                                } else {
                                    $ret = $ret . "(" . $newhp . "/" . $targetMaxHp . " {$GLOBALS['z']}HP left)";
                                }
                            }
                            $stmt2->close();
                        }
                        $stmt->close();
                    }
                } else if ($skillId == 16) {
                    
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        
                        $ret = $casterStats["hp"] . "/" . $casterStats["maxhp"] . " {$GLOBALS['z']}HP " . $casterStats["mp"] . "/" . $casterStats["maxmp"] . " {$GLOBALS['z']}MP " . $ret;

                        $hpDecrease = intval($casterInt / 4);

                        if ($targetIsPlayer == 0) {
                            $hpDecrease -= $targetDarkRes;

                            $stmt = $db->prepare("UPDATE rpg_chars SET hp = LEAST(hp - ?, ?) WHERE id = ?");
                            $stmt->bind_param("iii", $hpDecrease, $targetMaxHp, $chartarget);
                            if ($stmt->execute()) {
                                $stmt2 = $db->prepare("UPDATE rpg_chars SET mp = mp - 10 WHERE id = ?");
                                $stmt2->bind_param("i", $charid);
                                if ($stmt2->execute()) {
                                    $ret = $ret . "harmed {$GLOBALS['z']}" . getCharNameById($db, $chartarget) . " for " . $hpDecrease . " {$GLOBALS['z']}HP ";
                                    reduceAtp($db, $char, 8);

                                    $newhp = $targetStats["hp"] - $hpDecrease;
                                    if ($newhp > $targetMaxHp) {
                                        $newhp = $targetMaxHp;
                                    }

                                    if ($newhp <= 0) {
                                        dropItems($db, $casterStats["current_room"], $targetStats["id"]);
                                        killChar($db, $targetStats["id"]);
                                        $ret = $ret . expGain($db, $targetStats["exp"], $casterStats["exp"], $targetStats["name"], $casterStats["name"], $targetStats["gold"], $casterStats["gold"]) . lvlUp($db, strtolower($casterStats["name"])) . gainPots($db, strtolower($casterStats["name"]));
                                        untarget($db, strtolower($casterStats["name"]));
                                        $ret = $ret . checkBattleRoom($db, $casterStats["current_room"], $casterStats["name"]);
                                    } else {
                                        $ret = $ret . "(" . $newhp . "/" . $targetMaxHp . " {$GLOBALS['z']}HP left)";
                                    }

                                }
                                $stmt2->close();
                            }
                            $stmt->close();
                        } else {
                            $ret = $ret . "can only cast harm on monsters";
                        }
                    }
                } else if ($skillId == 17) {

                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        
                        $ret = $casterStats["hp"] . "/" . $casterStats["maxhp"] . " {$GLOBALS['z']}HP " . $casterStats["mp"] . "/" . $casterStats["maxmp"] . " {$GLOBALS['z']}MP " . $ret;
                        
                        $hpDecrease = intval($casterInt / 3);

                        if ($targetIsPlayer == 0) {
                            $hpDecrease -= $targetDarkRes;

                            $stmt = $db->prepare("UPDATE rpg_chars SET hp = LEAST(hp - ?, ?) WHERE id = ?");
                            $stmt->bind_param("iii", $hpDecrease, $targetMaxHp, $chartarget);
                            if ($stmt->execute()) {
                                $stmt2 = $db->prepare("UPDATE rpg_chars SET mp = mp - 10 WHERE id = ?");
                                $stmt2->bind_param("i", $charid);
                                if ($stmt2->execute()) {
                                    $ret = $ret . "healed {$GLOBALS['z']}" . getCharNameById($db, $chartarget) . " for " . $hpDecrease . " {$GLOBALS['z']}HP ";
                                    reduceAtp($db, $char, 10);

                                    $newhp = $targetStats["hp"] - $hpDecrease;
                                    if ($newhp > $targetMaxHp) {
                                        $newhp = $targetMaxHp;
                                    }

                                    if ($newhp <= 0) {
                                        dropItems($db, $casterStats["current_room"], $targetStats["id"]);
                                        killChar($db, $targetStats["id"]);
                                        $ret = $ret . expGain($db, $targetStats["exp"], $casterStats["exp"], $targetStats["name"], $casterStats["name"], $targetStats["gold"], $casterStats["gold"]) . lvlUp($db, strtolower($casterStats["name"])) . gainPots($db, strtolower($casterStats["name"]));
                                        untarget($db, strtolower($casterStats["name"]));
                                        $ret = $ret . checkBattleRoom($db, $casterStats["current_room"], $casterStats["name"]);
                                    } else {
                                        $ret = $ret . "(" . $newhp . "/" . $targetMaxHp . " {$GLOBALS['z']}HP left)";
                                    }
                                }
                                $stmt2->close();
                            }
                            $stmt->close();
                        } else {
                            $ret = $ret . "can only cast harm on monsters";
                        }
                    }
                } else if ($skillId == 18) {

                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        
                        $ret = $casterStats["hp"] . "/" . $casterStats["maxhp"] . " {$GLOBALS['z']}HP " . $casterStats["mp"] . "/" . $casterStats["maxmp"] . " {$GLOBALS['z']}MP " . $ret;
                        
                        $hpDecrease = intval($casterInt / 2);

                        if ($targetIsPlayer == 0) {
                            $hpDecrease -= $targetDarkRes;

                            $stmt = $db->prepare("UPDATE rpg_chars SET hp = LEAST(hp - ?, ?) WHERE id = ?");
                            $stmt->bind_param("iii", $hpDecrease, $targetMaxHp, $chartarget);
                            if ($stmt->execute()) {
                                $stmt2 = $db->prepare("UPDATE rpg_chars SET mp = mp - 10 WHERE id = ?");
                                $stmt2->bind_param("i", $charid);
                                if ($stmt2->execute()) {
                                    $ret = $ret . "healed {$GLOBALS['z']}" . getCharNameById($db, $chartarget) . " for " . $hpDecrease . " {$GLOBALS['z']}HP ";
                                    reduceAtp($db, $char, 12);

                                    $newhp = $targetStats["hp"] - $hpDecrease;
                                    if ($newhp > $targetMaxHp) {
                                        $newhp = $targetMaxHp;
                                    }

                                    if ($newhp <= 0) {
                                        dropItems($db, $casterStats["current_room"], $targetStats["id"]);
                                        killChar($db, $targetStats["id"]);
                                        $ret = $ret . expGain($db, $targetStats["exp"], $casterStats["exp"], $targetStats["name"], $casterStats["name"], $targetStats["gold"], $casterStats["gold"]) . lvlUp($db, strtolower($casterStats["name"])) . gainPots($db, strtolower($casterStats["name"]));
                                        untarget($db, strtolower($casterStats["name"]));
                                        $ret = $ret . checkBattleRoom($db, $casterStats["current_room"], $casterStats["name"]);
                                    } else {
                                        $ret = $ret . "(" . $newhp . " {$GLOBALS['z']}HP left" . ")";
                                    }
                                }
                                $stmt2->close();
                            }
                            $stmt->close();
                        } else {
                            $ret = $ret . "can only cast harm on monsters";
                        }
                    }
                } else if ($skillId == 4) { // fire
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}fire ");
                    }
                } else if ($skillId == 5) { // fira
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}fira ");
                    }
                } else if ($skillId == 6) { // firu
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}firu ");
                    }
                } else if ($skillId == 7) { // water
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}water ");
                    }
                } else if ($skillId == 8) { // watera
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}watera ");
                    }
                } else if ($skillId == 9) { // wateru
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}wateru ");
                    }
                } else if ($skillId == 10) { // ground
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}ground ");
                    }
                } else if ($skillId == 11) { // grounda
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}grounda " );
                    }
                } else if ($skillId == 12) { // groundu
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}groundu ");
                    }
                } else if ($skillId == 13) { // wind
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}wind ");
                    }
                } else if ($skillId == 14) { // winda
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}winda " );
                    }
                } else if ($skillId == 15) { // windu
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}windu ");
                    }
                } else if ($skillId == 16) { // harm
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}harm ");
                    }
                } else if ($skillId == 17) { // harma
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}harma " );
                    }
                } else if ($skillId == 18) { // harmu
                    if ($charmp < 10) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 10)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "casts {$GLOBALS['z']}harmu ");
                    }
                } else if ($skillId == 19) { // recover
                    $ret = $ret . "uses {$GLOBALS['z']}recover " . recover($db, $char, false);
                } else if ($skillId == 20) { // shield bash
                    if ($charmp < 2) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 2)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "performs {$GLOBALS['z']}shield-bash ");
                    }
                } else if ($skillId == 21) {
                    if ($charmp < 24) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 24)";
                    } else {

                        $stmt = $db->prepare("UPDATE rpg_chars SET atp = LEAST(spd, atp + 24) WHERE id = ?");
                        $stmt->bind_param("i", $chartarget);
                        if ($stmt->execute()) {
                            $stmt2 = $db->prepare("UPDATE rpg_chars SET mp = mp - 24 WHERE id = ?");
                            $stmt2->bind_param("i", $charid);
                            if ($stmt2->execute()) {
                                $ret = $ret . "cast {$GLOBALS['z']}haste on {$GLOBALS['z']}" . getCharNameById($db, $chartarget) . " for 24 {$GLOBALS['z']}ATP ";
                                reduceAtp($db, $char, 2);
                            }
                            $stmt2->close();
                        }
                        $stmt->close();
                    }
                } else if ($skillId == 22) { // assassinate
                    if ($charmp < 8) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 8)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "performs {$GLOBALS['z']}assassinate ");
                    }
                } else if ($skillId == 23) { // pierce
                    if ($charmp < 2) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 2)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "performs {$GLOBALS['z']}pierce ");
                    }
                } else if ($skillId == 24) { // quick-attack
                    if ($charmp < 2) {
                        $ret = $ret . "has not enough {$GLOBALS['z']}MP (req 2)";
                    } else {
                        $ret = $ret . attack($db, $char, $chartarget, $skillId, "performs {$GLOBALS['z']}quick-attack ");
                    }
                } else {
                    $ret = "skill {$GLOBALS['z']}" . $p1 . " does not do anything yet";
                }
            }
        } else {
            $ret = "has not learned skill {$GLOBALS['z']}" . $p1;
        }
    }
    return $ret;
}

function getSkillName($sid)
{
    if ($sid == 1) {
        return "heal";
    }
    if ($sid == 2) {
        return "heala";
    }
    if ($sid == 3) {
        return "healu";
    }
    if ($sid == 4) {
        return "fire";
    }
    if ($sid == 5) {
        return "fira";
    }
    if ($sid == 6) {
        return "firu";
    }
    if ($sid == 7) {
        return "water";
    }
    if ($sid == 8) {
        return "watra";
    }
    if ($sid == 9) {
        return "watru";
    }
    if ($sid == 10) {
        return "ground";
    }
    if ($sid == 11) {
        return "grouda";
    }
    if ($sid == 12) {
        return "groudu";
    }
    if ($sid == 13) {
        return "wind";
    }
    if ($sid == 14) {
        return "wida";
    }
    if ($sid == 15) {
        return "widu";
    }
    if ($sid == 16) {
        return "harm";
    }
    if ($sid == 17) {
        return "harma";
    }
    if ($sid == 18) {
        return "harmu";
    }
    if ($sid == 19) {
        return "recover";
    }
    if ($sid == 20) {
        return "shield-bash";
    }
    if ($sid == 21) {
        return "haste";
    }
    if ($sid == 22) {
        return "assassinate";
    }
    if ($sid == 23) {
        return "pierce";
    }
    if ($sid == 24) {
        return "quick-attack";
    }
    return "unknown";
}

function getSkillSp($sid)
{

    if ($sid == 1) {
        return 4;
    }
    if ($sid == 2) {
        return 4;
    }
    if ($sid == 3) {
        return 4;
    }
    if ($sid == 4) {
        return 3;
    }
    if ($sid == 5) {
        return 3;
    }
    if ($sid == 6) {
        return 3;
    }
    if ($sid == 7) {
        return 3;
    }
    if ($sid == 8) {
        return 3;
    }
    if ($sid == 9) {
        return 3;
    }
    if ($sid == 10) {
        return 3;
    }
    if ($sid == 11) {
        return 3;
    }
    if ($sid == 12) {
        return 3;
    }
    if ($sid == 13) {
        return 3;
    }
    if ($sid == 14) {
        return 3;
    }
    if ($sid == 15) {
        return 3;
    }
    if ($sid == 16) {
        return 6;
    }
    if ($sid == 17) {
        return 6;
    }
    if ($sid == 18) {
        return 6;
    }
    if ($sid == 19) {
        return 0;
    }
    if ($sid == 20) {
        return 2;
    }
    if ($sid == 21) {
        return 2;
    }
    if ($sid == 22) {
        return 2;
    }
    if ($sid == 23) {
        return 2;
    }
    if ($sid == 24) {
        return 2;
    }
    return -1;
}

function getSkillId($sname)
{

    if ($sname == "heal") {
        return 1;
    }
    if ($sname == "heala") {
        return 2;
    }
    if ($sname == "healu") {
        return 3;
    }

    if ($sname == "fire") {
        return 4;
    }
    if ($sname == "fira") {
        return 5;
    }
    if ($sname == "firu") {
        return 6;
    }

    if ($sname == "water") {
        return 7;
    }
    if ($sname == "watra") {
        return 8;
    }
    if ($sname == "watru") {
        return 9;
    }

    if ($sname == "ground") {
        return 10;
    }
    if ($sname == "grouda") {
        return 11;
    }
    if ($sname == "groudu") {
        return 12;
    }

    if ($sname == "wind") {
        return 13;
    }
    if ($sname == "wida") {
        return 14;
    }
    if ($sname == "widu") {
        return 15;
    }

    if ($sname == "harm") {
        return 16;
    }
    if ($sname == "harma") {
        return 17;
    }
    if ($sname == "harmu") {
        return 18;
    }

    if ($sname == "recover") {
        return 19;
    }
    if ($sname == "shield-bash") {
        return 20;
    }
    if ($sname == "haste") {
        return 21;
    }
    if ($sname == "assassinate") {
        return 22;
    }
    if ($sname == "pierce") {
        return 23;
    }
    if ($sname == "quick-attack") {
        return 24;
    }
    return -1;
}

function learnSkill(&$db, $char, $p1)
{

    $ret = "";

    $skillId = getSkillId($p1);

    $cid = -1;
    $stmt = $db->prepare("SELECT id, sp FROM rpg_chars WHERE LOWER(name) = ?");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $cid = intval($row["id"]);
            }
        }
    }
    $stmt->close();

    $stmt = $db->prepare("SELECT class FROM rpg_classes WHERE charid = ?");
    $stmt->bind_param("i", $cid);
    $className = "";
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $className = getClassById(intval($row["class"]));
            }
        }
    }
    $stmt->close();

    $s_heal = 0;
    $s_heal2 = 0;
    $s_heal3 = 0;

    $s_fire = 0;
    $s_fire2 = 0;
    $s_fire3 = 0;

    $s_water = 0;
    $s_water2 = 0;
    $s_water3 = 0;

    $s_ground = 0;
    $s_ground2 = 0;
    $s_ground3 = 0;

    $s_wind = 0;
    $s_wind2 = 0;
    $s_wind3 = 0;

    $s_harm = 0;
    $s_harm2 = 0;
    $s_harm3 = 0;

    $s_recover = 0;
    $s_sbash = 0;
    $s_haste = 0;
    $s_assassinate = 0;
    $s_pierce = 0;
    $s_quickattack = 0;

    if ($skillId == -1) {
        $ret . "unknown skill " . $p1;
    } else {

        $skillCost = getSkillSp($skillId);

        $knowsSkill = false;
        $stmt = $db->prepare("SELECT s.sid FROM rpg_skills s INNER JOIN rpg_chars c ON s.cid = c.id WHERE LOWER(c.name) = ?;");
        $stmt->bind_param("s", $char);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row_count = mysqli_num_rows($result);
            if ($row_count > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $sid = intval($row["sid"]);
                    if ($sid == $skillId) {
                        $knowsSkill = true;
                    }

                    if ($sid == 1) {
                        $s_heal = 1;
                    }
                    if ($sid == 2) {
                        $s_heal2 = 1;
                    }
                    if ($sid == 3) {
                        $s_heal3 = 1;
                    }

                    if ($sid == 4) {
                        $s_fire = 1;
                    }
                    if ($sid == 5) {
                        $s_fire2 = 1;
                    }
                    if ($sid == 6) {
                        $s_fire3 = 1;
                    }

                    if ($sid == 7) {
                        $s_water = 1;
                    }
                    if ($sid == 8) {
                        $s_water2 = 1;
                    }
                    if ($sid == 9) {
                        $s_water3 = 1;
                    }

                    if ($sid == 10) {
                        $s_ground = 1;
                    }
                    if ($sid == 11) {
                        $s_ground2 = 1;
                    }
                    if ($sid == 12) {
                        $s_ground3 = 1;
                    }

                    if ($sid == 13) {
                        $s_wind = 1;
                    }
                    if ($sid == 14) {
                        $s_wind2 = 1;
                    }
                    if ($sid == 15) {
                        $s_wind3 = 1;
                    }

                    if ($sid == 16) {
                        $s_harm = 1;
                    }
                    if ($sid == 17) {
                        $s_harm2 = 1;
                    }
                    if ($sid == 18) {
                        $s_harm3 = 1;
                    }

                    if ($sid == 19) {
                        $s_recover = 1;
                    }
                    if ($sid == 20) {
                        $s_sbash = 1;
                    }
                    if ($sid == 21) {
                        $s_haste = 1;
                    }
                    if ($sid == 22) {
                        $s_assassinate = 1;
                    }
                    if ($sid == 23) {
                        $s_pierce = 1;
                    }
                    if ($sid == 24) {
                        $s_quickattack = 1;
                    }
                }
            }
        }
        $stmt->close();

        $canLearn = false;
        if ($skillId == 1) {
            $canLearn = true;
        }
        if ($skillId == 2 && $s_heal == 1) {
            $canLearn = true;
        }
        if ($skillId == 3 && $s_heal2 == 1 && $className == "Mage") {
            $canLearn = true;
        }

        if ($skillId == 4) {
            $canLearn = true;
        }
        if ($skillId == 5 && $s_fire == 4) {
            $canLearn = true;
        }
        if ($skillId == 6 && $s_fire2 == 4 && $className == "Mage") {
            $canLearn = true;
        }

        if ($skillId == 7) {
            $canLearn = true;
        }
        if ($skillId == 8 && $s_water == 7) {
            $canLearn = true;
        }
        if ($skillId == 9 && $s_water2 == 7 && $className == "Mage") {
            $canLearn = true;
        }

        if ($skillId == 10) {
            $canLearn = true;
        }
        if ($skillId == 11 && $s_ground == 10) {
            $canLearn = true;
        }
        if ($skillId == 12 && $s_ground2 == 10 && $className == "Mage") {
            $canLearn = true;
        }

        if ($skillId == 13) {
            $canLearn = true;
        }
        if ($skillId == 14 && $s_wind == 13) {
            $canLearn = true;
        }
        if ($skillId == 15 && $s_wind2 == 13 && $className == "Mage") {
            $canLearn = true;
        }

        if ($skillId == 16) {
            $canLearn = true;
        }
        if ($skillId == 17 && $s_harm == 16) {
            $canLearn = true;
        }
        if ($skillId == 18 && $s_harm2 == 16 && $className == "Mage") {
            $canLearn = true;
        }

        if ($skillId == 19) {
            $canLearn = true;
        }
        if ($skillId == 20 && $className == "Warrior") { // shield-bash
            $canLearn = true;
        }
        if ($skillId == 21 && $className == "Thief") { // assassinate
            $canLearn = true;
        }
        if ($skillId == 22 && $className == "Thief") { // haste
            $canLearn = true;
        }
        if ($skillId == 23 && $className == "Warrior") { // pierce
            $canLearn = true;
        }
        if ($skillId == 24 && $className == "Thief") { // quick-attack
            $canLearn = true;
        }

        if (!$canLearn) {
            $ret = $ret . "cannot learn {$GLOBALS['z']}" . $p1 . " yet";
        } else if ($knowsSkill) {
            $ret = $ret . "already knows {$GLOBALS['z']}" . $p1;
        } else {
            $foundChar = false;
            $stmt = $db->prepare("SELECT id, sp FROM rpg_chars WHERE LOWER(name) = ?");
            $stmt->bind_param("s", $char);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $row_count = mysqli_num_rows($result);
                if ($row_count > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $cid = intval($row["id"]);
                        $csp = intval($row["sp"]);
                        $foundChar = true;
                    }
                }
            }
            $stmt->close();


            if ($foundChar) {
                if ($csp < $skillCost) {
                    $ret = $ret . "does not have enough {$GLOBALS['z']}SP to learn {$GLOBALS['z']}" . $p1 . " (req " . $skillCost . ")";
                } else {

                    $stmt = $db->prepare("INSERT INTO rpg_skills (sid, cid) VALUES (?, ?)");
                    $stmt->bind_param("ii", $skillId, $cid);
                    if ($stmt->execute()) {

                        $newcsp = $csp - $skillCost;
                        $stmt2 = $db->prepare("UPDATE rpg_chars SET sp = ? WHERE id = ?");
                        $stmt2->bind_param("ii", $newcsp, $cid);
                        if ($stmt2->execute()) {
                            $ret = $ret . "learned skill {$GLOBALS['z']}" . $p1;
                        } else {
                            $ret = $ret . "could not update {$GLOBALS['z']}SP";
                        }
                        $stmt2->close();
                    } else {
                        $ret = $ret . "could not add skill";
                    }
                    $stmt->close();

                }
            } else {
                $ret = $ret . "unknown character";
            }
        }
    }


    return $ret;
}

function skillTree(&$db, $char, $p1)
{

    if ($p1 == "reset") {
        return resetSkills($db, $char);
    }

    $ret = "";

    $s_heal = 0;
    $s_heal2 = 0;
    $s_heal3 = 0;

    $s_fire = 0;
    $s_fire2 = 0;
    $s_fire3 = 0;

    $s_water = 0;
    $s_water2 = 0;
    $s_water3 = 0;

    $s_ground = 0;
    $s_ground2 = 0;
    $s_ground3 = 0;

    $s_wind = 0;
    $s_wind2 = 0;
    $s_wind3 = 0;

    $s_harm = 0;
    $s_harm2 = 0;
    $s_harm3 = 0;

    $s_recover = 0;
    $s_sbash = 0;
    $s_haste = 0;
    $s_assassinate = 0;
    $s_pierce = 0;
    $s_quickattack = 0;

    $foundChar = false;

    $stmt = $db->prepare("SELECT id, sp FROM rpg_chars WHERE LOWER(name) = ?");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $cid = intval($row["id"]);
                $csp = intval($row["sp"]);
                $foundChar = true;
            }
        }
    }
    $stmt->close();

    $stmt = $db->prepare("SELECT class FROM rpg_classes WHERE charid = ?");
    $stmt->bind_param("i", $cid);
    $className = "";
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $className = getClassById(intval($row["class"]));
            }
        }
    }
    $stmt->close();

    $ret = "has " . $csp . " {$GLOBALS['z']}SP ";

    $stmt = $db->prepare("SELECT s.sid FROM rpg_skills s INNER JOIN rpg_chars c ON s.cid = c.id WHERE LOWER(c.name) = ?;");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            $ret = $ret . "and knows skills ";
            while ($row = mysqli_fetch_array($result)) {
                $sid = intval($row["sid"]);

                if ($sid == 1) {
                    $s_heal = 1;
                }
                if ($sid == 2) {
                    $s_heal2 = 1;
                }
                if ($sid == 3) {
                    $s_heal3 = 1;
                }

                if ($sid == 4) {
                    $s_fire = 1;
                }
                if ($sid == 5) {
                    $s_fire2 = 1;
                }
                if ($sid == 6) {
                    $s_fire3 = 1;
                }

                if ($sid == 7) {
                    $s_water = 1;
                }
                if ($sid == 8) {
                    $s_water2 = 1;
                }
                if ($sid == 9) {
                    $s_water3 = 1;
                }

                if ($sid == 10) {
                    $s_ground = 1;
                }
                if ($sid == 11) {
                    $s_ground2 = 1;
                }
                if ($sid == 12) {
                    $s_ground3 = 1;
                }

                if ($sid == 13) {
                    $s_wind = 1;
                }
                if ($sid == 14) {
                    $s_wind2 = 1;
                }
                if ($sid == 15) {
                    $s_wind3 = 1;
                }

                if ($sid == 16) {
                    $s_harm = 1;
                }
                if ($sid == 17) {
                    $s_harm2 = 1;
                }
                if ($sid == 18) {
                    $s_harm3 = 1;
                }

                if ($sid == 19) {
                    $s_recover = 1;
                }
                if ($sid == 20) {
                    $s_sbash = 1;
                }
                if ($sid == 21) {
                    $s_haste = 1;
                }
                if ($sid == 22) {
                    $s_assassinate = 1;
                }
                if ($sid == 23) {
                    $s_pierce = 1;
                }
                if ($sid == 24) {
                    $s_quickattack = 1;
                }

                $ret = $ret . "{$GLOBALS['z']}" . getSkillName($sid) . " ";
            }
        } else {
            $ret = $ret . "and knows no skills ";
        }
    }
    $stmt->close();

    $learnStr = " and can learn ";

    if ($s_recover == 0) {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(19) . " " . getSkillSp(19) . " {$GLOBALS['z']}SP ";
    }
    if ($s_sbash == 0 && $className == "Warrior") {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(20) . " " . getSkillSp(20) . " {$GLOBALS['z']}SP ";
    }
    if ($s_haste == 0 && $className == "Thief") {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(21) . " " . getSkillSp(21) . " {$GLOBALS['z']}SP ";
    }
    if ($s_assassinate == 0 && $className == "Thief") {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(22) . " " . getSkillSp(22) . " {$GLOBALS['z']}SP ";
    }
    if ($s_pierce == 0 && $className == "Warrior") {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(23) . " " . getSkillSp(23) . " {$GLOBALS['z']}SP ";
    }
    if ($s_quickattack == 0 && $className == "Thief") {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(24) . " " . getSkillSp(24) . " {$GLOBALS['z']}SP ";
    }

    if ($s_heal == 0) {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(1) . " " . getSkillSp(1) . " {$GLOBALS['z']}SP ";
    } else if ($s_heal2 == 0) {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(2) . " " . getSkillSp(2) . " {$GLOBALS['z']}SP ";
    } else if ($s_heal3 == 0 && $className == "Mage") {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(3) . " " . getSkillSp(3) . " {$GLOBALS['z']}SP ";
    }

    if ($s_fire == 0) {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(4) . " " . getSkillSp(4) . " {$GLOBALS['z']}SP ";
    } else if ($s_fire2 == 0) {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(5) . " " . getSkillSp(5) . " {$GLOBALS['z']}SP ";
    } else if ($s_fire3 == 0 && $className == "Mage") {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(6) . " " . getSkillSp(6) . " {$GLOBALS['z']}SP ";
    }

    if ($s_water == 0) {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(7) . " " . getSkillSp(7) . " {$GLOBALS['z']}SP ";
    } else if ($s_water2 == 0) {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(8) . " " . getSkillSp(8) . " {$GLOBALS['z']}SP ";
    } else if ($s_water3 == 0 && $className == "Mage") {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(9) . " " . getSkillSp(9) . " {$GLOBALS['z']}SP ";
    }

    if ($s_ground == 0) {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(10) . " " . getSkillSp(10) . " {$GLOBALS['z']}SP ";
    } else if ($s_ground2 == 0) {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(11) . " " . getSkillSp(11) . " {$GLOBALS['z']}SP ";
    } else if ($s_ground3 == 0 && $className == "Mage") {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(12) . " " . getSkillSp(12) . " {$GLOBALS['z']}SP ";
    }

    if ($s_wind == 0) {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(13) . " " . getSkillSp(13) . " {$GLOBALS['z']}SP ";
    } else if ($s_wind2 == 0) {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(14) . " " . getSkillSp(14) . " {$GLOBALS['z']}SP ";
    } else if ($s_wind3 == 0 && $className == "Mage") {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(15) . " " . getSkillSp(15) . " {$GLOBALS['z']}SP ";
    }

    if ($s_harm == 0) {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(16) . " " . getSkillSp(16) . " {$GLOBALS['z']}SP ";
    } else if ($s_harm2 == 0) {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(17) . " " . getSkillSp(17) . " {$GLOBALS['z']}SP ";
    } else if ($s_harm3 == 0 && $className == "Mage") {
        $learnStr = $learnStr . "{$GLOBALS['z']}" . getSkillName(18) . " " . getSkillSp(18) . " {$GLOBALS['z']}SP ";
    }

    if ($learnStr == " and can learn ") {
        $ret = $ret . " no more skills to learn ";
    } else {
        $ret = $ret . $learnStr;
    }

    return $ret . "(type 'skills reset' to reset skills)";
}

?>
