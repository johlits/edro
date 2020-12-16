<?

function triggerSwitches(&$db) {
	$stmt = $db->prepare("SELECT goto_room, s1, s2, s3, s4 FROM rpg_switches");
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $goto_room = intval($row["goto_room"]);
				$s1 = ($row["s1"]);
				$s1cnt = 0;
				$s2 = ($row["s2"]);
				$s2cnt = 0;
				$s3 = ($row["s3"]);
				$s3cnt = 0;
				$s4 = ($row["s4"]);
				$s4cnt = 0;
				
				if ($s1 != -1) {
					$stmt2 = $db->prepare("SELECT COUNT(*) as cnt FROM rpg_chars WHERE isplayer = 1 AND current_room = ?");
					$stmt2->bind_param("i", $s1);
					if ($stmt2->execute()) {
						$result2 = $stmt2->get_result();
						$row_count2 = mysqli_num_rows($result2);
						if ($row_count2 > 0) {
							while ($row2 = mysqli_fetch_array($result2)) {
								$s1cnt = intval($row2["cnt"]);
							}
						}
					}
					$stmt2->close();
				}
				
				if ($s2 != -1) {
					$stmt2 = $db->prepare("SELECT COUNT(*) as cnt FROM rpg_chars WHERE isplayer = 1 AND current_room = ?");
					$stmt2->bind_param("i", $s2);
					if ($stmt2->execute()) {
						$result2 = $stmt2->get_result();
						$row_count2 = mysqli_num_rows($result2);
						if ($row_count2 > 0) {
							while ($row2 = mysqli_fetch_array($result2)) {
								$s2cnt = intval($row2["cnt"]);
							}
						}
					}
					$stmt2->close();
				}
				
				if ($s3 != -1) {
					$stmt2 = $db->prepare("SELECT COUNT(*) as cnt FROM rpg_chars WHERE isplayer = 1 AND current_room = ?");
					$stmt2->bind_param("i", $s3);
					if ($stmt2->execute()) {
						$result2 = $stmt2->get_result();
						$row_count2 = mysqli_num_rows($result2);
						if ($row_count2 > 0) {
							while ($row2 = mysqli_fetch_array($result2)) {
								$s3cnt = intval($row2["cnt"]);
							}
						}
					}
					$stmt2->close();
				}
				
				if ($s4 != -1) {
					$stmt2 = $db->prepare("SELECT COUNT(*) as cnt FROM rpg_chars WHERE isplayer = 1 AND current_room = ?");
					$stmt2->bind_param("i", $s4);
					if ($stmt2->execute()) {
						$result2 = $stmt2->get_result();
						$row_count2 = mysqli_num_rows($result2);
						if ($row_count2 > 0) {
							while ($row2 = mysqli_fetch_array($result2)) {
								$s4cnt = intval($row2["cnt"]);
							}
						}
					}
					$stmt2->close();
				}
				
				$trigger = true;
				if ($s1 > -1 && $s1cnt < 1) {
					$trigger = false;
				}
				if ($s2 > -1 && $s2cnt < 1) {
					$trigger = false;
				}
				if ($s3 > -1 && $s3cnt < 1) {
					$trigger = false;
				}
				if ($s4 > -1 && $s4cnt < 1) {
					$trigger = false;
				}
				
				if ($trigger) {
					$stmt2 = $db->prepare("UPDATE rpg_chars SET current_room = ? WHERE current_room = ? OR current_room = ? OR current_room = ? OR current_room = ?");
					$stmt2->bind_param("iiiii", $goto_room, $s1, $s2, $s3, $s4);
					$stmt2->execute();
					$stmt2->close();
				}
            }
        }
    }
    $stmt->close();
}

function getWelcome(&$db) {
	$v = "";
	$stmt = $db->prepare("SELECT MAX(id) as v FROM rpg_patches");
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $v = $row["v"];
            }
        }
    }
    $stmt->close();
	return "Welcome to EDRO v.0.{$v}! Type help as action to get started.";
}

function getHelp(&$db)
{
    $helplink = "";
    $stmt = $db->prepare("SELECT helplink FROM rpg_server WHERE id = ?");
    $stmt->bind_param("i", $GLOBALS['serverId']);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $helplink = " TUTORIAL: " . $row["helplink"];
            }
        }
    }
    $stmt->close();

    return "ACTIONS: attack (x), buy x (y), class (x), create, day, delete x, drop x, equip x, feed x, follow x, forge x, help, inspect x, inventory, learn x, load, move x (y), pick x, rename x y, room, save, see, sell x y, skill x (y), skills, stats (x), target x, unequip [weapon, armor, legs, cape, ring], unfollow, untarget, use x y" . $helplink;
}

function cntCommands(&$db, $char) {
    $ret = 999999;
    $stmt = $db->prepare("SELECT COUNT(*) FROM rpg_commands WHERE cdate > NOW() - INTERVAL 1 DAY AND LOWER(name) = ?");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = mysqli_fetch_array($result)) {
            $ret = intval($row[0]);
        }
    }
    $stmt->close();
    return $ret;
}

function getMap(&$db, $p1, $p2) {
    $chars = explode("_", $p1);
    $ret = "";

    $sql = "SELECT name, current_room FROM rpg_chars WHERE LOWER(name) = ?";
    $stmt = $db->prepare($sql);

    $rooms = array();

    for ($i = 0; $i < count($chars); $i++) {
        $stmt->bind_param("s", $chars[$i]);
        $stmt->execute();
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $ret = $ret . $row["name"] . " " . $row["current_room"] . "<";
                array_push($rooms, $row["current_room"]);
            }
        }
    }

    $ret = substr($ret, 0, -1) . ">";

    $stmt->close();
	if ($p2 == "group") {
		$stmt = $db->prepare("SELECT from_room, to_room FROM rpg_connections WHERE from_room = ? OR to_room = ?");
		
		for ($i = 0; $i < count($rooms); $i++) {
			$stmt->bind_param("ii", $rooms[$i], $rooms[$i]);
			$stmt->execute();
			$result = $stmt->get_result();
			$row_count = mysqli_num_rows($result);
			if ($row_count > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$ret = $ret . $row["from_room"] . " " . $row["to_room"] . "<";
				}
			}
		}
		$stmt->close();
	}

	if ($p2 == "all") {
		$stmt = $db->prepare("SELECT from_room, to_room FROM rpg_connections");
		$stmt->execute();
		$result = $stmt->get_result();
		$row_count = mysqli_num_rows($result);
		if ($row_count > 0) {
			while ($row = mysqli_fetch_array($result)) {
				$ret = $ret . $row["from_room"] . " " . $row["to_room"] . "<";
			}
		}
		$stmt->close();
	}
    

    $ret = substr($ret, 0, -1) . ">";

    $stmt = $db->prepare("SELECT id, name FROM rpg_rooms");
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $ret = $ret . $row["name"] . " " . $row["id"] . "<";
            }
        }
    }
    $stmt->close();

    return substr($ret, 0, -1);
}

function charExists(&$db, $char, $email) {
    $ret = false;
    $stmt = $db->prepare("SELECT id, name, current_room, lvl FROM rpg_chars WHERE LOWER(name) = ? AND owner = ?");
    $stmt->bind_param("ss", $char, $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            $ret = true;
        }
    }
    $stmt->close();
    return $ret;
}

function deleteChar(&$db, $char, $p1)
{

    if ($p1 == date("Y-m-d")) {
        $stats = getStatsData($db, $char);
        $charId = $stats["id"];

        $stmt = $db->prepare("UPDATE rpg_chars SET isplayer = 0 WHERE id = ?");
        $stmt->bind_param("i", $charId);
        $stmt->execute();
        $stmt->close();

        killChar($db, $charId);

        return "deleted permanently";
    } else {
        return "please provide current date yyyy-mm-dd as parameter to delete char";
    }
}

function moveFollowers($db, $char, $newroomid, $lvlcap)
{

    $stats = getStatsData($db, $char);
    $charId = $stats["id"];

    $stmt = $db->prepare("SELECT id, name, current_room, lvl FROM rpg_chars WHERE follow = ?");
    $stmt->bind_param("i", $charId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $fid = intval($row["id"]);
                $rid = intval($row["current_room"]);
                $flvl = intval($row["lvl"]);

                if ($rid != $newroomid && $lvlcap <= $flvl) {
                    $stmt2 = $db->prepare("UPDATE rpg_chars SET current_room = ? WHERE id = ?");
                    $stmt2->bind_param("ii", $newroomid, $fid);
                    $stmt2->execute();
                    $stmt2->close();
                    moveFollowers($db, $row["name"], $newroomid, $lvlcap);
                    movePets($db, $row["name"], $newroomid);
                }
            }
        }
    }
    $stmt->close();

}

function getCharNameById(&$db, $cid)
{

    $ret = "";
    $stmt = $db->prepare("SELECT id, name, isplayer FROM rpg_chars WHERE id = ?");
    $stmt->bind_param("i", $cid);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if (intval($row["isplayer"]) == 2) {
                    $ret = $ret . $row["name"] . "#" . $row["id"];
                } else {
                    $ret = $ret . $row["name"];
                }

            }
        }
    }
    $stmt->close();
    return $ret;

}

function getInventory(&$db, $char, $p1)
{
    if (strlen($p1) > 0) {
        target($db, $char, $p1);
    }

    $stats = getStatsData($db, $char);
    $targetId = intval($stats["target"]);
    if ($targetId == 0) {
        $targetId = intval($stats["id"]);
    }

    $ret = "";
    $stmt = $db->prepare(getStatQuery(true));
    $stmt->bind_param("i", $targetId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {

                $ret = $ret . "inventorizes ~" . $row["name"] . " ";
                $weapon = intval($row["weapon"]);
                $body = intval($row["body"]);
                $legs = intval($row["legs"]);
                $cape = intval($row["cape"]);
                $ring = intval($row["ring"]);

                $itemstr = "";
                $equipstr = "";
                $charid = $row["id"];
                $stmt2 = $db->prepare("SELECT id,name,atk,def,spd,evd,price,lvl,hp,mp,int_stat,fire_res,water_res,ground_res,wind_res,light_res,dark_res FROM rpg_items WHERE inroom = 0 AND ownerid = ?");
                $stmt2->bind_param("i", $charid);
                if ($stmt2->execute()) {
                    $result2 = $stmt2->get_result();
                    $row_count2 = mysqli_num_rows($result2);
                    if ($row_count2 > 0) {
                        $equipstr = "EQUIPPED: ";
                        $itemstr = " INVENTORY: ";
                        while ($row2 = mysqli_fetch_array($result2)) {

                            $resstr = $row2["fire_res"] . "/" . $row2["water_res"] . "/" . $row2["ground_res"] . "/" . $row2["wind_res"] . "/" . $row2["light_res"] . "/" . $row2["dark_res"];

                            if (intval($row2["id"]) == $weapon || intval($row2["id"]) == $body || intval($row2["id"]) == $legs || intval($row2["id"]) == $cape || intval($row2["id"]) == $ring) {
                                $equipstr = $equipstr . "L" . $row2["lvl"] . " {$GLOBALS['z']}" . $row2["name"] . "#" . $row2["id"] . " (" . $row2["atk"] . "/" . $row2["def"] . "/" . $row2["spd"] . "/" . $row2["evd"] . "/" . $row2["int_stat"] . " " . $row2["hp"] . "/" . $row2["mp"] . " " . $resstr . ") ";
                            } else {
                                $price = intval($row2["price"]);
                                $pricestr = "";
                                if ($price >= 0) {
                                    $pricestr = "[FOR SALE " . $price . "g] ";
                                }
                                $itemstr = $itemstr . "L" . $row2["lvl"] . " {$GLOBALS['z']}" . $row2["name"] . "#" . $row2["id"] . " (" . $row2["atk"] . "/" . $row2["def"] . "/" . $row2["spd"] . "/" . $row2["evd"] . "/" . $row2["int_stat"] . " " . $row2["hp"] . "/" . $row2["mp"] . " " . $resstr . ") " . $pricestr;
                            }
                        }
                        if ($itemstr == " INVENTORY: ") {
                            $itemstr = $itemstr . "None";
                        }
                        $itemstr = $itemstr . " ";
                    }
                }
                $stmt2->close();

                if ($equipstr == "EQUIPPED: ") {
                    $equipstr = "";
                }

                $ret = $ret . $equipstr . $itemstr;
            }
        } else {
            $ret = "unknown character";
        }
    }
    $stmt->close();
    return $ret;
}

function inspect(&$db, $char, $p1)
{
    $ret = "";

    $stats = getStatsData($db, $char);
    $roomid = $stats["current_room"];

    $stmt2 = $db->prepare("SELECT name, isplayer, id FROM rpg_chars WHERE current_room = ?");
    $stmt2->bind_param("i", $roomid);
    if ($stmt2->execute()) {
        $result2 = $stmt2->get_result();
        $row_count2 = mysqli_num_rows($result2);
        if ($row_count2 > 0) {
            while ($row2 = mysqli_fetch_array($result2)) {

                $inspectName = $row2["name"];
                if (intval($row2["isplayer"]) == 2) {
                    $inspectName = $row2["name"] . "#" . $row2["id"];
                }
                $inspectId = intval($row2["id"]);

                if (strtolower($inspectName) == $p1) {
                    $stmt3 = $db->prepare(getStatQuery(true));
                    $stmt3->bind_param("i", $inspectId);
                    if ($stmt3->execute()) {
                        $result3 = $stmt3->get_result();
                        $row_count3 = mysqli_num_rows($result3);
                        if ($row_count3 > 0) {
                            while ($row3 = mysqli_fetch_array($result3)) {
                                $ret = "inspects {$GLOBALS['z']}" . $inspectName . " and finds " . getStats($db, $row3["name"], $inspectId);
                            }
                        } else {
                            $ret = "does not exist. Type '/rpg create' to create";
                        }
                    }
                    $stmt3->close();
                }
            }
        }
    } else {
        $ret = "Could not find character in current room";
    }
    $stmt2->close();

    return $ret;
}

function getPetGarden(&$db)
{
    $Pet_Garden = -1;
    $stmt3 = $db->prepare("SELECT id FROM rpg_rooms WHERE LOWER(name) = 'Pet_Garden'");
    if ($stmt3->execute()) {
        $result3 = $stmt3->get_result();
        $row_count3 = mysqli_num_rows($result3);
        if ($row_count3 > 0) {
            while ($row3 = mysqli_fetch_array($result3)) {
                $Pet_Garden = intval($row3["id"]);
            }
        }
    }
    $stmt3->close();
    return $Pet_Garden;
}

function target(&$db, $char, $p1)
{
    $ret = "";
    $stats = getStatsData($db, $char);

    $tChar = $p1;
    if (strpos($p1, '#') !== false) {
        $tChar = explode("#", $p1)[0];
    }

    $charId = intval($stats["id"]);
    $charRoom = intval($stats["current_room"]);

    $stmt = $db->prepare("SELECT name, id, isplayer FROM rpg_chars WHERE LOWER(name) = ? AND current_room = ? ORDER BY isplayer ASC");
    $stmt->bind_param("si", $tChar, $charRoom);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {

            while ($row = mysqli_fetch_array($result)) {
                $tName = $row["name"];
                $tId = intval($row["id"]);
                $tIsPlayer = intval($row["isplayer"]);
                break;
            }

            if ($tIsPlayer == 2) {
                $tName = $row["name"] . "#" . $row["id"];
            }

            if (($tIsPlayer == 2 && $p1 == strtolower($tName)) || ($tIsPlayer != 2)) {

                $stmt2 = $db->prepare("UPDATE rpg_chars SET target = ? WHERE id = ?");
                $stmt2->bind_param("ii", $tId, $charId);
                if ($stmt2->execute()) {
                    $ret = "has targeted {$GLOBALS['z']}{$tName}";
                }
                $stmt2->close();
            }
            else {
                $ret = "Unknown character {$p1}";
            }

        } else {
            $ret = "Unknown character {$p1}";
        }
    }
    $stmt->close();

    return $ret;
}

function untargetChar(&$db, $char)
{
    $ret = "";
    $stmt = $db->prepare("SELECT id FROM rpg_chars WHERE LOWER(name) = ?");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if (untarget($db, $char)) {
                    $ret = "has no target";
                }
            }
        } else {
            $ret = "Unknown character " . $char;
        }
    }
    $stmt->close();
    return $ret;
}

function untarget(&$db, $untargetName)
{
    $stmt2 = $db->prepare("UPDATE rpg_chars SET target = 0 WHERE LOWER(name) = ?");
    $stmt2->bind_param("s", $untargetName);
    $ret = $stmt2->execute();
    $stmt2->close();
    return $ret;
}

function getRoom(&$db, $char, $seeConnections)
{
    $ret = "";
    $stmt = $db->prepare("SELECT r.name, r.description FROM rpg_rooms r INNER JOIN rpg_chars c WHERE LOWER(c.name) = ? AND c.current_room = r.id");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $roomStr = "is in room {$GLOBALS['z']}" . $row["name"] . " ";
                if (strlen($row["description"]) > 0) {
                    $roomStr = $roomStr . $row["description"] . " ";
                }
                $ret = $roomStr;
                if ($seeConnections) {
                    $ret = $ret . getConnections($db, $char);
                }
            }
        } else {
            $ret = "Could not find current room";
        }
    }
    $stmt->close();
    return $ret;
}

function getRoomType(&$db, $char)
{
    $ret = -1;
    $stmt = $db->prepare("SELECT r.type FROM rpg_rooms r INNER JOIN rpg_chars c WHERE LOWER(c.name) = ? AND c.current_room = r.id");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $ret = intval($row["type"]);
            }
        }
    }
    $stmt->close();
    return $ret;
}

function recover(&$db, $char, $allRooms)
{

    $stats = getStatsData($db, $char);
    $maxhp = $stats["maxhp"];
    $maxmp = $stats["maxmp"];

    $ret = "can only recover in safe rooms";
    $stmt = $db->prepare("SELECT r.type FROM rpg_rooms r INNER JOIN rpg_chars c WHERE LOWER(c.name) = ? AND c.current_room = r.id");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if (intval($row["type"]) == 1 || $allRooms) {
                    $stmt2 = $db->prepare("UPDATE rpg_chars SET hp = ?, mp = ?, atp = 0 WHERE LOWER(name) = ?");
                    $stmt2->bind_param("iis", $maxhp, $maxmp, $char);
                    $stmt2->execute();
                    $stmt2->close();
                    $ret = "has recovered to full {$GLOBALS['z']}HP and {$GLOBALS['z']}MP";
                }
            }
        }
    }
    $stmt->close();
    return $ret;
}

function move(&$db, $char, $p1, $p2)
{
    $ret = "";
    $stmt = $db->prepare("SELECT r.id, r.type, c.stamina, c.lvl, c.follow FROM rpg_rooms r INNER JOIN rpg_chars c WHERE LOWER(c.name) = ? AND c.current_room = r.id");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {

                $roomid = $row["id"];
                $roomtype = intval($row["type"]);
                $charstamina = intval($row["stamina"]);
                $charlvl = intval($row["lvl"]);
                $charfollow = intval($row["follow"]);

                $canMove = "";

                if ($charfollow > 0) {
                    $canMove = "is following {$GLOBALS['z']}" . getCharNameById($db, $charfollow) . " and cannot move";
                } else if ($charstamina < 1) {
                    $canMove = "is out of stamina and cannot move (use action: day)";
                } else if ($roomtype == 0 && $p2 != "escape") {
                    $stmt4 = $db->prepare("SELECT id FROM rpg_chars WHERE current_room = ? AND isplayer = 0");
                    $stmt4->bind_param("i", $roomid);
                    if ($stmt4->execute()) {
                        $result4 = $stmt4->get_result();
                        $row_count4 = mysqli_num_rows($result4);
                        if ($row_count4 > 0) {
                            $canMove = "cannot move when monsters are present";
                        }
                    }
                    $stmt4->close();
                }
                if (strlen($canMove) > 0) {
                    $ret = $canMove;
                } else {

                    $stmt2 = $db->prepare("SELECT r.id, r.name, con.lvlcap FROM rpg_rooms r INNER JOIN rpg_connections con ON r.id = con.to_room WHERE con.from_room = ?");
                    $stmt2->bind_param("i", $roomid);
                    if ($stmt2->execute()) {
                        $result2 = $stmt2->get_result();
                        $row_count2 = mysqli_num_rows($result2);
                        if ($row_count2 > 0) {
                            $foundRoom = false;
                            while ($row2 = mysqli_fetch_array($result2)) {
                                if (strtolower($row2["name"]) == strtolower($p1)) {

                                    $lvlcap = intval($row2["lvlcap"]);
                                    $foundRoom = true;

                                    if ($charlvl < $lvlcap) {
                                        $ret = "cannot enter because of level requirement (cap " . $lvlcap . ")";
                                    } else {

                                        $checkEscape = false;
                                        if ($p2 == "escape") {
                                            if ($charstamina >= 800) {
                                                $stmt3 = $db->prepare("UPDATE rpg_chars SET stamina = stamina - 800 WHERE LOWER(name) = ?");
                                                $stmt3->bind_param("s", $char);
                                                $stmt3->execute();
                                                $stmt3->close();
                                                $checkEscape = true;
                                            }
                                        } else {
                                            reduceStamina($db, $char);
                                            $checkEscape = true;
                                        }

                                        if ($checkEscape) {
                                            $newroomid = intval($row2["id"]);

                                            $stmt3 = $db->prepare("UPDATE rpg_chars SET current_room = ?, target = 0 WHERE LOWER(name) = ?");
                                            $stmt3->bind_param("is", $newroomid, $char);
                                            if ($stmt3->execute()) {
                                                $ret = getRoom($db, $char, true);

                                                $ret = $ret . createMonsters($db, $newroomid);
                                                movePets($db, $char, $newroomid);
                                                moveFollowers($db, $char, $newroomid, $lvlcap);
                                                $ret = $ret . see($db, $char);
                                            }
                                            $stmt3->close();
                                        }
                                    }
                                }
                            }
                            if (!$foundRoom) {
                                $ret = $p1 . " is not in connection with current room";
                            }
                        } else {
                            $ret = "your current room has no connections";
                        }
                    }
                    $stmt2->close();
                }
            }

        } else {
            $ret = "Could not find current room";
        }
    }
    $stmt->close();
	
	if (getRoomType($db, $char) == 4) {
		triggerSwitches($db);
		$ret = $ret . " Switch triggered!";
	}
	
    return $ret;
}

function see(&$db, $char)
{
    $ret = "";
    $stmt = $db->prepare("SELECT r.id FROM rpg_rooms r INNER JOIN rpg_chars c WHERE LOWER(c.name) = ? AND c.current_room = r.id");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {

                $roomid = $row["id"];

                $stmt2 = $db->prepare("SELECT id, name, isplayer FROM rpg_chars WHERE current_room = ?");
                $stmt2->bind_param("i", $roomid);
                $see = "sees ";
                if ($stmt2->execute()) {
                    $result2 = $stmt2->get_result();
                    $row_count2 = mysqli_num_rows($result2);
                    if ($row_count2 > 0) {
                        while ($row2 = mysqli_fetch_array($result2)) {
                            if (intval($row2["isplayer"]) == 2) {

                                $cid = $row2["id"];
                                $see = $see . "{$GLOBALS['z']}" . $row2["name"] . "#" . $cid . " ";


                                $stmt3 = $db->prepare("SELECT ownerid FROM rpg_pets WHERE petid = ?");
                                $stmt3->bind_param("i", $cid);
                                if ($stmt3->execute()) {
                                    $result3 = $stmt3->get_result();
                                    $row_count3 = mysqli_num_rows($result3);
                                    if ($row_count3 > 0) {
                                        while ($row3 = mysqli_fetch_array($result3)) {

                                            if (intval($row3["ownerid"]) > 0) {
                                                $see = $see . "owned by {$GLOBALS['z']}" . getCharNameById($db, $row3["ownerid"]) . " ";
                                            }

                                        }
                                    }
                                }
                            } else {
                                $see = $see . "{$GLOBALS['z']}" . $row2["name"] . " ";
                            }
                        }
                        $see = rtrim($see, " ");
                    } else {
                        $see = "no characters";
                    }
                    $ret = $see;
                } else {
                    $ret = "Could not find characters in current room";
                }
                $stmt2->close();

                $stmt2 = $db->prepare("SELECT id, name FROM rpg_items WHERE inroom = 1 AND ownerid = ?");
                $stmt2->bind_param("i", $roomid);
                $see = "";
                if ($stmt2->execute()) {
                    $result2 = $stmt2->get_result();
                    $row_count2 = mysqli_num_rows($result2);
                    if ($row_count2 > 0) {
                        $see = " Room contains items ";
                        while ($row2 = mysqli_fetch_array($result2)) {
                            $see = $see . "{$GLOBALS['z']}" . $row2["name"] . "#" . $row2["id"] . " ";
                        }
                        $see = rtrim($see, " ");
                        $ret = $ret . $see;
                    } else {
                    }

                }
                $stmt2->close();
            }
        } else {
            $ret = "Could not find current room";
        }
    }
    $stmt->close();
    return $ret;
}

function getConnections(&$db, $char)
{
    $ret = "";
    $stmt = $db->prepare("SELECT r.id FROM rpg_rooms r INNER JOIN rpg_chars c WHERE LOWER(c.name) = ? AND c.current_room = r.id");
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $stmt2 = $db->prepare("SELECT r.name FROM rpg_rooms r INNER JOIN rpg_connections con ON r.id = con.to_room WHERE con.from_room = ?");
                $roomid = $row["id"];
                $stmt2->bind_param("i", $roomid);
                if ($stmt2->execute()) {
                    $result2 = $stmt2->get_result();
                    $row_count2 = mysqli_num_rows($result2);
                    if ($row_count2 > 0) {
                        $roomstr = "Room has connections to ";
                        while ($row2 = mysqli_fetch_array($result2)) {
                            $roomstr = $roomstr . "{$GLOBALS['z']}" . $row2["name"] . " ";
                        }
                        $ret = $roomstr;
                    } else {
                        $ret = "Has no connections. ";
                    }
                }
                $stmt2->close();
            }

        } else {
            $ret = "Could not find current room. ";
        }
    }
    $stmt->close();
    return $ret;
}

?>
