<?

function monsterDrops(&$db, $mon, $monid)
{
    $ret = "";
    if ($mon == "Snake" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "WoodenSword", 0, $monid, -1);
    }

    if ($mon == "Snake" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "WoodenShield", 0, $monid, -1);
    }

    if ($mon == "Snake" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "LeatherShoes", 0, $monid, -1);
    }

    if ($mon == "Snake" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "ClothCape", 0, $monid, -1);
    }

    if ($mon == "Hippogriff" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "IronSword", 0, $monid, -1);
    }

    if ($mon == "Hippogriff" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "IronShield", 0, $monid, -1);
    }

    if ($mon == "Hippogriff" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "LeatherBoots", 0, $monid, -1);
    }

    if ($mon == "Hippogriff" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "SilkCape", 0, $monid, -1);
    }

    if ($mon == "Hippogriff" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "Cane", 0, $monid, -1);
    }

    if ($mon == "ShroomMom" && rand(1, 100) < 10) {
        $ret = $ret . spawnItem($db, "Katana", 0, $monid, -1);
    }

    if ($mon == "ShroomMom" && rand(1, 100) < 10) {
        $ret = $ret . spawnItem($db, "Dagger", 0, $monid, -1);
    }

    if ($mon == "ShroomMom" && rand(1, 100) < 10) {
        $ret = $ret . spawnItem($db, "Robe", 0, $monid, -1);
    }
    
    if ($mon == "ShroomMom" && rand(1, 100) < 10) {
        $ret = $ret . spawnItem($db, "TreeRing", 0, $monid, -1);
    }

    if ($mon == "IceDragon" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "SteelSword", 0, $monid, -1);
    }

    if (($mon == "IceDragon" || $mon == "CaveBear") && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "SteelShield", 0, $monid, -1);
    }

    if (($mon == "IceDragon" || $mon == "CaveBear") && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "PowerBoots", 0, $monid, -1);
    }

    if (($mon == "IceDragon" || $mon == "CaveBear") && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "BloodCape", 0, $monid, -1);
    }

    if ($mon == "IceDragon" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "WaterCane", 0, $monid, -1);
    }

    if ($mon == "CaveBear" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "FireCane", 0, $monid, -1);
    }
    
    if ($mon == "TitanWiz" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "SilverSword", 0, $monid, -1);
    }
    
    if ($mon == "TitanWiz" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "SilverShield", 0, $monid, -1);
    }
    
    if ($mon == "TitanWiz" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "RunningShoes", 0, $monid, -1);
    }
    
    if ($mon == "TitanWiz" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "WindCape", 0, $monid, -1);
    }
    
    if ($mon == "TitanWiz" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "GroundCaneII", 0, $monid, -1);
    }
    
    if ($mon == "TitanWiz" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "SilverDagger", 0, $monid, -1);
    }
    
    if ($mon == "Spyritis" && rand(1, 100) < 10) {
        $ret = $ret . spawnItem($db, "RubyRing", 0, $monid, -1);
    }
	
	if ($mon == "Spyritis" && rand(1, 100) < 10) {
        $ret = $ret . spawnItem($db, "SteelKatana", 0, $monid, -1);
    }

    if ($mon == "Spyritis" && rand(1, 100) < 10) {
        $ret = $ret . spawnItem($db, "SteelDagger", 0, $monid, -1);
    }

    if ($mon == "Spyritis" && rand(1, 100) < 10) {
        $ret = $ret . spawnItem($db, "SilkRobe", 0, $monid, -1);
    }
	
	if ($mon == "MindFlayer" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "GoldenSword", 0, $monid, -1);
    }
    
    if ($mon == "MindFlayer" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "GoldenShield", 0, $monid, -1);
    }
    
    if ($mon == "MindFlayer" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "GoldenDagger", 0, $monid, -1);
    }
    
    if ($mon == "MindFlayer" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "HeavyBoots", 0, $monid, -1);
    }
    
    if ($mon == "MindFlayer" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "WaterCape", 0, $monid, -1);
    }
	
	if ($mon == "MindFlayer" && rand(1, 100) < 25) {
        $ret = $ret . spawnItem($db, "Rod", 0, $monid, -1);
    }

    return $ret;
}

?>
