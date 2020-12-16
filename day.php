<?

function getDay(&$db)
{
    $ret = "";
    $stmt = $db->prepare("SELECT sname, sdate, sname, sweather, sday FROM rpg_server WHERE id = 1");
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $daystr = "Day " . $row["sday"] . " in " . $row["sname"] . " (" . $row["sweather"] . "), ";

                $sdate = explode(" ", $row["sdate"])[0];
                $ndate = date("Y-m-d");

                $weather = "N/A";
                $wr = rand(1, 4);
                if ($wr == 1) {
                    $weather = "Sunny";
                }
                if ($wr == 2) {
                    $weather = "Cloudy";
                }
                if ($wr == 3) {
                    $weather = "Windy";
                }
                if ($wr == 4) {
                    $weather = "Rain";
                }

                if ($sdate != $ndate) {
                    $stmt2 = $db->prepare("UPDATE rpg_server SET sdate = ?, sweather = ?, sday = sday + 1 WHERE id = 1");
                    $stmt2->bind_param("ss", $ndate, $weather);
                    if ($stmt2->execute()) {
						
						// Patches
						
						$patch_init = false;
						$patch_p1 = false;
						$patch_p2 = false;
						$patch_p3 = false;
                        $patch_p4 = false;
						
						$stmt3 = $db->prepare("SELECT LOWER(name) as name FROM rpg_patches");
                        if ($stmt3->execute()) {
                            $result3 = $stmt3->get_result();
                            $row_count3 = mysqli_num_rows($result3);
                            if ($row_count3 > 0) {
                                while ($row3 = mysqli_fetch_array($result3)) {
									if ($row3["name"] == "init") {
										$patch_init = true;
									}
									if ($row3["name"] == "p1") {
										$patch_p1 = true;
									}
									if ($row3["name"] == "p2") {
										$patch_p2 = true;
									}
									if ($row3["name"] == "p3") {
										$patch_p3 = true;
									}
                                    if ($row3["name"] == "p4") {
										$patch_p4 = true;
									}
                                }
                            }
                        }
                        $stmt3->close();
                        
						if (!$patch_init) {
                            if (forest1_rooms($db) && forest1_connections($db)) {
                                $stmt3 = $db->prepare("INSERT INTO rpg_patches (name, pdate) VALUES ('init', NOW())");
                                $stmt3->execute();
                                $stmt3->close();
                            }
						}
						
						if (!$patch_p1) {
                            if (pubcrawl_rooms($db) && pubcrawl_switches($db) && pubcrawl_connections($db)) {
                                $stmt3 = $db->prepare("INSERT INTO rpg_patches (name, pdate) VALUES ('p1', NOW())");
                                $stmt3->execute();
                                $stmt3->close();
                            }
						}
						
						if (!$patch_p2) {
                            if (cave3_rooms($db) && cave3_connections($db)) {
                                $stmt3 = $db->prepare("INSERT INTO rpg_patches (name, pdate) VALUES ('p2', NOW())");
                                $stmt3->execute();
                                $stmt3->close();
                            }
						}
						
						if (!$patch_p3) {
                            if (taxi_rooms_connections($db) && cave_library($db)) {
                                $stmt3 = $db->prepare("INSERT INTO rpg_patches (name, pdate) VALUES ('p3', NOW())");
                                $stmt3->execute();
                                $stmt3->close();
                            }
						}
                        
                        if (!$patch_p4) {
                            if (cave3_rename($db)) {
                                $stmt3 = $db->prepare("INSERT INTO rpg_patches (name, pdate) VALUES ('p4', NOW())");
                                $stmt3->execute();
                                $stmt3->close();
                            }
						}
						
						// Day stuff
						
						$daystr = "A new day has begun! ";
                        $daystr = $daystr . "Day " . (intval($row["sday"]) + 1) . " in " . $row["sname"] . " (" . $weather . "), ";

						// recover stamina
						
                        $stmt3 = $db->prepare("UPDATE rpg_chars SET stamina = maxstamina WHERE isplayer = 1");
                        if ($stmt3->execute()) {
                            $daystr = $daystr . " and everyone feels refreshed!";
                        }
                        $stmt3->close();
						
						// delete items on ground

                        $stmt3 = $db->prepare("DELETE FROM rpg_items WHERE inroom = 1");
                        $stmt3->execute();
                        $stmt3->close();

                        // Pets

                        $Pet_Garden = getPetGarden($db);

                        $petsToRemove = array();

                        $stmt3 = $db->prepare("SELECT petid FROM rpg_pets WHERE ownerid NOT IN (SELECT id FROM rpg_chars)");
                        if ($stmt3->execute()) {
                            $result3 = $stmt3->get_result();
                            $row_count3 = mysqli_num_rows($result3);
                            if ($row_count3 > 0) {
                                while ($row3 = mysqli_fetch_array($result3)) {
                                    array_push($petsToRemove, intval($row3["petid"]));
                                }
                            }
                        }
                        $stmt3->close();

                        foreach ($petsToRemove as $pet) {
                            $stmt3 = $db->prepare("DELETE FROM rpg_chars WHERE id = ?");
                            $stmt3->bind_param("i", $pet);
                            $stmt3->execute();
                            $stmt3->close();

                            $stmt3 = $db->prepare("DELETE FROM rpg_pets WHERE petid = ?");
                            $stmt3->bind_param("i", $pet);
                            $stmt3->execute();
                            $stmt3->close();
                        }

                        $stmt3 = $db->prepare("SELECT id FROM rpg_chars WHERE isplayer = 2 AND current_room = ?");
                        $stmt3->bind_param("i", $Pet_Garden);
                        if ($stmt3->execute()) {
                            $result3 = $stmt3->get_result();
                            $row_count3 = mysqli_num_rows($result3);
                            if ($row_count3 > 0) {
                                while ($row3 = mysqli_fetch_array($result3)) {

                                    $petid = $row3["id"];
                                    $stmt4 = $db->prepare("UPDATE rpg_chars SET exp = exp + 10 WHERE id = ?");
                                    $stmt4->bind_param("i", $petid);
                                    $stmt4->execute();
                                    $stmt4->close();

                                    $petName = getCharNameById($db, $petid);

                                    lvlUp($db, strtolower($petName));
                                }
                            }
                        }
                        $stmt3->close();

                        if (rand(1, 2) <= 1) {
                            $stmt3 = $db->prepare("INSERT INTO rpg_chars (name, isplayer, current_room) VALUES ('Cat_PET', 2, ?)");
                            $stmt3->bind_param("i", $Pet_Garden);
                            $stmt3->execute();
                            $petiid = intval($stmt3->insert_id);
                            $stmt3->close();

                            $stmt3 = $db->prepare("INSERT INTO rpg_pets (ownerid, petid, cost) VALUES (0, ?, 100)");
                            $stmt3->bind_param("i", $petiid);
                            $stmt3->execute();
                            $stmt3->close();

                        }
                        if (rand(1, 2) <= 1) {
                            $stmt3 = $db->prepare("INSERT INTO rpg_chars (name, isplayer, current_room) VALUES ('Dog_PET', 2, ?)");
                            $stmt3->bind_param("i", $Pet_Garden);
                            $stmt3->execute();
                            $petiid = intval($stmt3->insert_id);
                            $stmt3->close();

                            $stmt3 = $db->prepare("INSERT INTO rpg_pets (ownerid, petid, cost) VALUES (0, ?, 100)");
                            $stmt3->bind_param("i", $petiid);
                            $stmt3->execute();
                            $stmt3->close();
                        }
                        if (rand(1, 2) <= 1) {
                            $stmt3 = $db->prepare("INSERT INTO rpg_chars (name, isplayer, current_room) VALUES ('Duck_PET', 2, ?)");
                            $stmt3->bind_param("i", $Pet_Garden);
                            $stmt3->execute();
                            $petiid = intval($stmt3->insert_id);
                            $stmt3->close();

                            $stmt3 = $db->prepare("INSERT INTO rpg_pets (ownerid, petid, cost) VALUES (0, ?, 100)");
                            $stmt3->bind_param("i", $petiid);
                            $stmt3->execute();
                            $stmt3->close();
                        }
						
						// Merchants
						
                        $Merchant_A = -1;
                        $Merchant_B = -1;
                        $Merchant_C = -1;

                        $stmt3 = $db->prepare("SELECT id, name FROM rpg_chars WHERE isplayer = 3");
                        if ($stmt3->execute()) {
                            $result3 = $stmt3->get_result();
                            $row_count3 = mysqli_num_rows($result3);
                            if ($row_count3 > 0) {
                                while ($row3 = mysqli_fetch_array($result3)) {
                                    if ($row3["name"] == "Merchant_A") {
                                        $Merchant_A = intval($row3["id"]);
                                    }
                                    if ($row3["name"] == "Merchant_B") {
                                        $Merchant_B = intval($row3["id"]);
                                    }
                                    if ($row3["name"] == "Merchant_C") {
                                        $Merchant_C = intval($row3["id"]);
                                    }
                                }
                            }
                        }
                        $stmt3->close();

                        $stmt3 = $db->prepare("SELECT id FROM rpg_chars WHERE name = 'Merchant_C'");
                        if ($stmt3->execute()) {
                            $result3 = $stmt3->get_result();
                            $row_count3 = mysqli_num_rows($result3);
                            if ($row_count3 > 0) {
                                while ($row3 = mysqli_fetch_array($result3)) {
                                    $Merchant_C = intval($row3["id"]);
                                }
                            }
                        }
                        $stmt3->close();

                        if ($Merchant_A == -1) {
                            $stmt3 = $db->prepare("INSERT INTO rpg_chars (name, current_room, isplayer) VALUES ('Merchant_A', 15, 3)");
                            $stmt3->execute();
                            $Merchant_A = intval($stmt3->insert_id);
                            $stmt3->close();
                        }

                        if ($Merchant_B == -1) {
                            $stmt3 = $db->prepare("INSERT INTO rpg_chars (name, current_room, isplayer) VALUES ('Merchant_B', 15, 3)");
                            $stmt3->execute();
                            $Merchant_B = intval($stmt3->insert_id);
                            $stmt3->close();
                        }

                        if ($Merchant_C == -1) {
                            $stmt3 = $db->prepare("INSERT INTO rpg_chars (name, current_room, isplayer) VALUES ('Merchant_C', 138, 3)");
                            $stmt3->execute();
                            $Merchant_C = intval($stmt3->insert_id);
                            $stmt3->close();
                        }

                        $stmt3 = $db->prepare("DELETE FROM rpg_items WHERE inroom = 0 AND ownerid = ? OR ownerid = ? OR ownerid = ?");
                        $stmt3->bind_param("iii", $Merchant_A, $Merchant_B, $Merchant_B);
                        $stmt3->execute();
                        $stmt3->close();

                        $mahpincr = rand(1, 9);
                        $mampincr = rand(1, 9);

                        $stmt3 = $db->prepare("UPDATE rpg_chars SET hp_v1 = hp_v1 + ?, mp_v1 = mp_v1 + ? WHERE id = ?");
                        $stmt3->bind_param("iii", $mahpincr, $mampincr, $Merchant_A);
                        $stmt3->execute();
                        $stmt3->close();

                        $mahpincr = rand(1, 9);
                        $mampincr = rand(1, 9);

                        $stmt3 = $db->prepare("UPDATE rpg_chars SET hp_v1 = hp_v1 + ?, mp_v1 = mp_v1 + ? WHERE id = ?");
                        $stmt3->bind_param("iii", $mahpincr, $mampincr, $Merchant_B);
                        $stmt3->execute();
                        $stmt3->close();

                        $mahpincr = rand(1, 9);
                        $mampincr = rand(1, 9);

                        $stmt3 = $db->prepare("UPDATE rpg_chars SET hp_v1 = hp_v1 + ?, mp_v1 = mp_v1 + ? WHERE id = ?");
                        $stmt3->bind_param("iii", $mahpincr, $mampincr, $Merchant_C);
                        $stmt3->execute();
                        $stmt3->close();

                        for ($x = 0; $x < 5; $x++) {
                            $iadd = rand(1, 4);
                            if ($iadd == 1) {
                                $ret = $ret . spawnItem($db, "WoodenSword", 0, $Merchant_A, 80 + rand(0, 40));
                            }
                            if ($iadd == 2) {
                                $ret = $ret . spawnItem($db, "WoodenShield", 0, $Merchant_A, 80 + rand(0, 40));
                            }
                            if ($iadd == 3) {
                                $ret = $ret . spawnItem($db, "LeatherShoes", 0, $Merchant_A, 80 + rand(0, 40));
                            }
                            if ($iadd == 4) {
                                $ret = $ret . spawnItem($db, "ClothCape", 0, $Merchant_A, 80 + rand(0, 40));
                            }
                        }

                        for ($x = 0; $x < 5; $x++) {
                            $iadd = rand(1, 4);
                            if ($iadd == 1) {
                                $ret = $ret . spawnItem($db, "IronSword", 0, $Merchant_B, 800 + rand(0, 400));
                            }
                            if ($iadd == 2) {
                                $ret = $ret . spawnItem($db, "IronShield", 0, $Merchant_B, 800 + rand(0, 400));
                            }
                            if ($iadd == 3) {
                                $ret = $ret . spawnItem($db, "LeatherBoots", 0, $Merchant_B, 800 + rand(0, 400));
                            }
                            if ($iadd == 4) {
                                $ret = $ret . spawnItem($db, "SilkCape", 0, $Merchant_B, 800 + rand(0, 400));
                            }
                        }

                        for ($x = 0; $x < 5; $x++) {
                            $iadd = rand(1, 4);
                            if ($iadd == 1) {
                                $ret = $ret . spawnItem($db, "SteelSword", 0, $Merchant_C, 8000 + rand(0, 4000));
                            }
                            if ($iadd == 2) {
                                $ret = $ret . spawnItem($db, "SteelShield", 0, $Merchant_C, 8000 + rand(0, 4000));
                            }
                            if ($iadd == 3) {
                                $ret = $ret . spawnItem($db, "PowerBoots", 0, $Merchant_C, 8000 + rand(0, 4000));
                            }
                            if ($iadd == 4) {
                                $ret = $ret . spawnItem($db, "BloodCape", 0, $Merchant_C, 8000 + rand(0, 4000));
                            }
                        }
						
						// Recover

                        $stmt3 = $db->prepare("SELECT name FROM rpg_chars WHERE isplayer = 1");
                        if ($stmt3->execute()) {
                            $result3 = $stmt3->get_result();
                            $row_count3 = mysqli_num_rows($result3);
                            if ($row_count3 > 0) {
                                while ($row3 = mysqli_fetch_array($result3)) {
                                    recover($db, strtolower($row3["name"]), true);
                                }
                            }
                        }
                        $stmt3->close();
                    }
                    $stmt2->close();

                } else {
                    $today = new DateTime('now');
                    $tomorrow = new DateTime('tomorrow');
                    $difference = $today->diff($tomorrow);
                    $daystr = $daystr . $difference->format('%h hours %i minutes %s seconds until tomorrow');
                }

                $ret = $ret . $daystr;
            }
        }
    }
    $stmt->close();
    return $ret;
}

?>