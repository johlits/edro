<?

function getPetStats(&$db, $charid)
{
    $plus = array();
    $plus["atk"] = 0;
    $plus["def"] = 0;
    $plus["spd"] = 0;
    $plus["evd"] = 0;
    $plus["int"] = 0;

    $stmt2 = $db->prepare("SELECT atk, def, spd, evd, int_stat FROM rpg_pets p INNER JOIN rpg_chars c ON p.petid = c.id AND p.ownerid = ?");
    $stmt2->bind_param("i", $charid);
    if ($stmt2->execute()) {
        $result2 = $stmt2->get_result();
        $row_count2 = mysqli_num_rows($result2);
        if ($row_count2 > 0) {
            while ($row2 = mysqli_fetch_array($result2)) {
                $plus["atk"] += intval(intval($row2["atk"]) / 2);
                $plus["def"] += intval(intval($row2["def"]) / 2);
                $plus["spd"] += intval(intval($row2["spd"]) / 2);
                $plus["evd"] += intval(intval($row2["evd"]) / 2);
                $plus["int"] += intval(intval($row2["int_stat"]) / 2);
            }
        }
    }
    $stmt2->close();

    return $plus;
}

function movePets(&$db, $char, $newroomid)
{

    $stats = getStatsData($db, $char);
    $charId = $stats["id"];

    $stmt = $db->prepare("SELECT petid from rpg_pets WHERE ownerid = ?");
    $stmt->bind_param("i", $charId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $petid = intval($row["petid"]);

                $stmt2 = $db->prepare("UPDATE rpg_chars SET current_room = ? WHERE id = ?");
                $stmt2->bind_param("ii", $newroomid, $petid);
                $stmt2->execute();
                $stmt2->close();
            }
        }
    }
    $stmt->close();

}

function renamePet(&$db, $char, $p1)
{
    $stats = getStatsData($db, $char);
    $charId = $stats["id"];

    $stmt = $db->prepare("SELECT petid from rpg_pets WHERE ownerid = ?");
    $stmt->bind_param("i", $charId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $petid = intval($row["petid"]);

                $stmt2 = $db->prepare("UPDATE rpg_chars SET name = ? WHERE id = ?");
                $stmt2->bind_param("si", $p1, $petid);
                $stmt2->execute();
                $stmt2->close();

                $ret = "changed name of pet to {$GLOBALS['z']}" . $p1;
            }
        } else {
            $ret = "does not own a pet";
        }
    }
    $stmt->close();

    return $ret;
}

function feedPet(&$db, $char, $p1, $p2)
{

    if (strlen($p2) > 0) {
        target($db, $char, $p2);
    }

    $ret = "";
    $feedId = -1;
    $feederId = -1;

    $stmt = $db->prepare(getStatQuery());
    $stmt->bind_param("s", $char);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $feederRow = $row;
                $feederId = intval($feederRow["id"]);
                $feedId = intval($feederRow["target"]);
            }
        }
    }
    $stmt->close();

    if ($feederId == $feedId) {
        $ret = "cannot feed itself";
    } else if ($feedId < 0) {
        $ret = "unknown target";
    } else if ($feedId == 0) {
        $ret = "has no target";
    } else {

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
                    $stmt2 = $db->prepare("SELECT id, name, lvl FROM rpg_items WHERE inroom = 0 AND ownerid = ?");
                    $stmt2->bind_param("i", $charid);
                    if ($stmt2->execute()) {
                        $result2 = $stmt2->get_result();
                        $row_count2 = mysqli_num_rows($result2);
                        if ($row_count2 > 0) {
                            while ($row2 = mysqli_fetch_array($result2)) {
                                if (strtolower($row2["name"] . "#" . $row2["id"]) == $p1) {
                                    $itemid = intval($row2["id"]);
                                    if ($itemid == $weapon_id || $itemid == $body_id || $itemid == $legs_id || $itemid == $cape_id || $itemid == $ring_id) {
                                        $ret = "cannot feed equipped items";
                                    } else {

                                        $itemexp = intval($row2["lvl"]) * 10;

                                        $stmt3 = $db->prepare("UPDATE rpg_chars SET exp = exp + ? WHERE id = ?");
                                        $stmt3->bind_param("ii", $itemexp, $feedId);
                                        $stmt3->execute();
                                        $stmt3->close();

                                        $petName = getCharNameById($db, $feedId);

                                        lvlUp($db, strtolower($petName));

                                        $stmt3 = $db->prepare("DELETE FROM rpg_items WHERE id = ?");
                                        $stmt3->bind_param("i", $itemid);
                                        $stmt3->execute();
                                        $stmt3->close();

                                        $ret = "fed {$GLOBALS['z']}" . $petName . " with {$GLOBALS['z']}" . $row2["name"] . "#" . $row2["id"];

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
            $ret = "failed to feed item";
        }
    }

    return $ret;
}

?>
