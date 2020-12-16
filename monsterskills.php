<?

/*
1 = "heal"
2 = "heala"
3 = "healu"
4 = "fire"
5 = "fira"
6 = "firu"
7 = "water"
8 = "watra"
9 = "watru"
10 = "ground"
11 = "grouda"
12 = "groudu"
13 = "wind"
14 = "wida"
15 = "widu"
16 = "harm"
17 = "harma"
18 = "harmu"
19 = "recover"
20 = "shield-bash"
21 = "haste"
22 = "assassinate"
23 = "pierce"
24 = "quick-attack"
*/

function monsterSkills(&$db, $mon, $monid)
{
	if ($mon == "Hippogriff") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 7, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
	
	if ($mon == "SeaDragon") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 7, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    if ($mon == "FireWorm") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 4, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    if ($mon == "SandRaptor") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 10, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    if ($mon == "IceDragon") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 7, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 13, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
	
	if ($mon == "MentalShroom") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 4, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 7, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 10, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 13, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }

    if ($mon == "FireShroom") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 4, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    if ($mon == "WaterShroom") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 7, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    if ($mon == "GroundShroom") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 10, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    if ($mon == "WindShroom") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 13, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
	
	if ($mon == "Troll") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 4, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 10, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
	
	if ($mon == "RubiFlower") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 5, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    if ($mon == "QuarzDroplet") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 8, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    if ($mon == "MagneMon") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 11, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    if ($mon == "DiamondDrake") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 14, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    if ($mon == "TitanWiz") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 5, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 8, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 11, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 14, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
	if ($mon == "Weltencasw") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 5, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    if ($mon == "Jaritmegrese") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 8, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    if ($mon == "Biswuered") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 11, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    if ($mon == "Jealknaidsc") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 14, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
	if ($mon == "Spyritis") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 5, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 8, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 11, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 14, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    
	if ($mon == "Cloaker") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 8, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
    if ($mon == "MindFlayer") {
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 5, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 8, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 11, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
        $stmtSkill = $db->prepare("INSERT INTO rpg_skills( sid, cid ) VALUES( 14, ? )");
        $stmtSkill->bind_param("i", $monid);
        $stmtSkill->execute();
        $stmtSkill->close();
    }
}

?>
