<?php
    
function tier2Hp($tier, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($tier == 1) {
        return intval(10 * $balance / 100);
    }
    if ($tier == 2) {
        return intval(40 * $balance / 100);
    }
    if ($tier == 3) {
        return intval(80 * $balance / 100);
    }
    if ($tier == 4) {
        return intval(160 * $balance / 100);
    }
    return intval($tier * 50 * $balance / 100);
}
    
function tier2Mp($tier, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($tier == 1) {
        return intval(5 * $balance / 100);
    }
    if ($tier == 2) {
        return intval(20 * $balance / 100);
    }
    if ($tier == 3) {
        return intval(40 * $balance / 100);
    }
    if ($tier == 4) {
        return intval(80 * $balance / 100);
    }
    return intval($tier * 25 * $balance / 100);
}
    
function tier2Atk($tier, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($tier == 1) {
        return intval(5 * $balance / 100);
    }
    if ($tier == 2) {
        return intval(20 * $balance / 100);
    }
    if ($tier == 3) {
        return intval(40 * $balance / 100);
    }
    if ($tier == 4) {
        return intval(80 * $balance / 100);
    }
    return intval($tier * 20 * $balance / 100);
}
    
function tier2Def($tier, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($tier == 1) {
        return intval(5 * $balance / 100);
    }
    if ($tier == 2) {
        return intval(20 * $balance / 100);
    }
    if ($tier == 3) {
        return intval(40 * $balance / 100);
    }
    if ($tier == 4) {
        return intval(80 * $balance / 100);
    }
    return intval($tier * 20 * $balance / 100);
}
    
function tier2Spd($tier, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($tier == 1) {
        return intval(5 * $balance / 100);
    }
    if ($tier == 2) {
        return intval(20 * $balance / 100);
    }
    if ($tier == 3) {
        return intval(40 * $balance / 100);
    }
    if ($tier == 4) {
        return intval(80 * $balance / 100);
    }
    return intval($tier * 20 * $balance / 100);
}
    
function tier2Evd($tier, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($tier == 1) {
        return intval(5 * $balance / 100);
    }
    if ($tier == 2) {
        return intval(20 * $balance / 100);
    }
    if ($tier == 3) {
        return intval(40 * $balance / 100);
    }
    if ($tier == 4) {
        return intval(80 * $balance / 100);
    }
    return intval($tier * 20 * $balance / 100);
}
    
function tier2Int($tier, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($tier == 1) {
        return intval(5 * $balance / 100);
    }
    if ($tier == 2) {
        return intval(20 * $balance / 100);
    }
    if ($tier == 3) {
        return intval(40 * $balance / 100);
    }
    if ($tier == 4) {
        return intval(80 * $balance / 100);
    }
    return intval($tier * 20 * $balance / 100);
}
    
function tier2Res($tier, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($tier == 1) {
        return intval(2 * $balance / 100);
    }
    if ($tier == 2) {
        return intval(4 * $balance / 100);
    }
    if ($tier == 3) {
        return intval(8 * $balance / 100);
    }
    if ($tier == 4) {
        return intval(16 * $balance / 100);
    }
    return intval($tier * 7 * $balance / 100);
}

function spawnItem(&$db, $iname, $iinroom, $ownerid, $iprice) {

    $ret = "";

    $iclassreq = 0;

    $foundItem = false;
    
    // SWORDS

    if ($iname == "WoodenSword") {
        $itype = 1;
        $tier = 1;
        
        $ihp = tier2Hp($tier, 40);
        $imp = tier2Mp($tier, 20);
        $iatk = tier2Atk($tier, 100);
        $idef = tier2Def($tier, 20);
        $ispd = tier2Spd($tier, 20);
        $ievd = tier2Evd($tier, 30);
        $iint = tier2Int($tier, 0);
        
        $ifire_res = tier2Res($tier, 0);
        $iwater_res = tier2Res($tier, 0);
        $iground_res = tier2Res($tier, 0);
        $iwind_res = tier2Res($tier, 0);
        $ilight_res = tier2Res($tier, 0);
        $idark_res = tier2Res($tier, 0);
        
        $foundItem = true;
    }
    
    if ($iname == "IronSword") {
        $itype = 1;
        $tier = 2;
        
        $ihp = tier2Hp($tier, 80);
        $imp = tier2Mp($tier, 10);
        $iatk = tier2Atk($tier, 100);
        $idef = tier2Def($tier, 20);
        $ispd = tier2Spd($tier, 30);
        $ievd = tier2Evd($tier, 10);
        $iint = tier2Int($tier, 10);
        
        $ifire_res = tier2Res($tier, 0);
        $iwater_res = tier2Res($tier, 0);
        $iground_res = tier2Res($tier, 0);
        $iwind_res = tier2Res($tier, 0);
        $ilight_res = tier2Res($tier, 0);
        $idark_res = tier2Res($tier, 0);
        
        $foundItem = true;
    }
    
    if ($iname == "SteelSword") {
        $itype = 1;
        $tier = 3;
        
        $ihp = tier2Hp($tier, 40);
        $imp = tier2Mp($tier, 10);
        $iatk = tier2Atk($tier, 100);
        $idef = tier2Def($tier, 30);
        $ispd = tier2Spd($tier, 50);
        $ievd = tier2Evd($tier, 10);
        $iint = tier2Int($tier, 0);
        
        $ifire_res = tier2Res($tier, 0);
        $iwater_res = tier2Res($tier, 0);
        $iground_res = tier2Res($tier, 0);
        $iwind_res = tier2Res($tier, 0);
        $ilight_res = tier2Res($tier, 0);
        $idark_res = tier2Res($tier, 0);
        
        $foundItem = true;
    }
    
    if ($iname == "SilverSword") {
        $itype = 1;
        $tier = 4;
        
        $ihp = tier2Hp($tier, 40);
        $imp = tier2Mp($tier, 10);
        $iatk = tier2Atk($tier, 100);
        $idef = tier2Def($tier, 30);
        $ispd = tier2Spd($tier, 50);
        $ievd = tier2Evd($tier, 10);
        $iint = tier2Int($tier, 0);
        
        $ifire_res = tier2Res($tier, 0);
        $iwater_res = tier2Res($tier, 0);
        $iground_res = tier2Res($tier, 0);
        $iwind_res = tier2Res($tier, 0);
        $ilight_res = tier2Res($tier, 0);
        $idark_res = tier2Res($tier, 0);
        
        $foundItem = true;
    }
    
    if ($iname == "GoldenSword") {
        $itype = 1;
        $tier = 5;
        
        $ihp = tier2Hp($tier, 40);
        $imp = tier2Mp($tier, 10);
        $iatk = tier2Atk($tier, 100);
        $idef = tier2Def($tier, 30);
        $ispd = tier2Spd($tier, 50);
        $ievd = tier2Evd($tier, 10);
        $iint = tier2Int($tier, 0);
        
        $ifire_res = tier2Res($tier, 0);
        $iwater_res = tier2Res($tier, 0);
        $iground_res = tier2Res($tier, 0);
        $iwind_res = tier2Res($tier, 0);
        $ilight_res = tier2Res($tier, 0);
        $idark_res = tier2Res($tier, 0);
        
        $foundItem = true;
    }
    
    // SHIELDS

    if ($iname == "WoodenShield") {
        $itype = 2;
        $tier = 1;
        
        $ihp = tier2Hp($tier, 80);
        $imp = tier2Mp($tier, 0);
        $iatk = tier2Atk($tier, 20);
        $idef = tier2Def($tier, 100);
        $ispd = tier2Spd($tier, 20);
        $ievd = tier2Evd($tier, 40);
        $iint = tier2Int($tier, 0);
        
        $ifire_res = tier2Res($tier, 50);
        $iwater_res = tier2Res($tier, 50);
        $iground_res = tier2Res($tier, 50);
        $iwind_res = tier2Res($tier, 50);
        $ilight_res = tier2Res($tier, 50);
        $idark_res = tier2Res($tier, 50);
        
        $foundItem = true;
    }
    
    if ($iname == "IronShield") {
        $itype = 2;
        $tier = 2;
        
        $ihp = tier2Hp($tier, 100);
        $imp = tier2Mp($tier, 10);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 100);
        $ispd = tier2Spd($tier, 20);
        $ievd = tier2Evd($tier, 20);
        $iint = tier2Int($tier, 10);
        
        $ifire_res = tier2Res($tier, 50);
        $iwater_res = tier2Res($tier, 50);
        $iground_res = tier2Res($tier, 50);
        $iwind_res = tier2Res($tier, 50);
        $ilight_res = tier2Res($tier, 50);
        $idark_res = tier2Res($tier, 50);
        
        $foundItem = true;
    }
    
    if ($iname == "SteelShield") {
        $itype = 2;
        $tier = 3;
        
        $ihp = tier2Hp($tier, 90);
        $imp = tier2Mp($tier, 10);
        $iatk = tier2Atk($tier, 20);
        $idef = tier2Def($tier, 100);
        $ispd = tier2Spd($tier, 20);
        $ievd = tier2Evd($tier, 40);
        $iint = tier2Int($tier, 10);
        
        $ifire_res = tier2Res($tier, 30);
        $iwater_res = tier2Res($tier, 30);
        $iground_res = tier2Res($tier, 30);
        $iwind_res = tier2Res($tier, 30);
        $ilight_res = tier2Res($tier, 30);
        $idark_res = tier2Res($tier, 30);
        
        $foundItem = true;
    }
    
    if ($iname == "SilverShield") {
        $itype = 2;
        $tier = 4;
        
        $ihp = tier2Hp($tier, 90);
        $imp = tier2Mp($tier, 10);
        $iatk = tier2Atk($tier, 20);
        $idef = tier2Def($tier, 100);
        $ispd = tier2Spd($tier, 20);
        $ievd = tier2Evd($tier, 40);
        $iint = tier2Int($tier, 10);
        
        $ifire_res = tier2Res($tier, 30);
        $iwater_res = tier2Res($tier, 30);
        $iground_res = tier2Res($tier, 30);
        $iwind_res = tier2Res($tier, 30);
        $ilight_res = tier2Res($tier, 30);
        $idark_res = tier2Res($tier, 30);
        
        $foundItem = true;
    }
    
    if ($iname == "GoldenShield") {
        $itype = 2;
        $tier = 5;
        
        $ihp = tier2Hp($tier, 90);
        $imp = tier2Mp($tier, 10);
        $iatk = tier2Atk($tier, 20);
        $idef = tier2Def($tier, 100);
        $ispd = tier2Spd($tier, 20);
        $ievd = tier2Evd($tier, 40);
        $iint = tier2Int($tier, 10);
        
        $ifire_res = tier2Res($tier, 30);
        $iwater_res = tier2Res($tier, 30);
        $iground_res = tier2Res($tier, 30);
        $iwind_res = tier2Res($tier, 30);
        $ilight_res = tier2Res($tier, 30);
        $idark_res = tier2Res($tier, 30);
        
        $foundItem = true;
    }
    
    // SHOES

    if ($iname == "LeatherShoes") {
        $itype = 3;
        $tier = 1;
        
        $ihp = tier2Hp($tier, 40);
        $imp = tier2Mp($tier, 40);
        $iatk = tier2Atk($tier, 0);
        $idef = tier2Def($tier, 20);
        $ispd = tier2Spd($tier, 100);
        $ievd = tier2Evd($tier, 40);
        $iint = tier2Int($tier, 40);
        
        $ifire_res = tier2Res($tier, 20);
        $iwater_res = tier2Res($tier, 20);
        $iground_res = tier2Res($tier, 20);
        $iwind_res = tier2Res($tier, 20);
        $ilight_res = tier2Res($tier, 20);
        $idark_res = tier2Res($tier, 20);
        
        $foundItem = true;
    }
    
    if ($iname == "LeatherBoots") {
        $itype = 3;
        $tier = 2;
        
        $ihp = tier2Hp($tier, 20);
        $imp = tier2Mp($tier, 40);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 20);
        $ispd = tier2Spd($tier, 100);
        $ievd = tier2Evd($tier, 40);
        $iint = tier2Int($tier, 40);
        
        $ifire_res = tier2Res($tier, 10);
        $iwater_res = tier2Res($tier, 10);
        $iground_res = tier2Res($tier, 10);
        $iwind_res = tier2Res($tier, 10);
        $ilight_res = tier2Res($tier, 10);
        $idark_res = tier2Res($tier, 10);
        
        $foundItem = true;
    }
    
    if ($iname == "PowerBoots") {
        $itype = 3;
        $tier = 3;
        
        $ihp = tier2Hp($tier, 20);
        $imp = tier2Mp($tier, 40);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 30);
        $ispd = tier2Spd($tier, 100);
        $ievd = tier2Evd($tier, 50);
        $iint = tier2Int($tier, 40);
        
        $ifire_res = tier2Res($tier, 30);
        $iwater_res = tier2Res($tier, 30);
        $iground_res = tier2Res($tier, 30);
        $iwind_res = tier2Res($tier, 30);
        $ilight_res = tier2Res($tier, 30);
        $idark_res = tier2Res($tier, 30);
        
        $foundItem = true;
    }
    
    if ($iname == "RunningShoes") {
        $itype = 3;
        $tier = 4;
        
        $ihp = tier2Hp($tier, 20);
        $imp = tier2Mp($tier, 40);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 30);
        $ispd = tier2Spd($tier, 140);
        $ievd = tier2Evd($tier, 50);
        $iint = tier2Int($tier, 40);
        
        $ifire_res = tier2Res($tier, 30);
        $iwater_res = tier2Res($tier, 30);
        $iground_res = tier2Res($tier, 30);
        $iwind_res = tier2Res($tier, 30);
        $ilight_res = tier2Res($tier, 30);
        $idark_res = tier2Res($tier, 30);
        
        $foundItem = true;
    }
    
    if ($iname == "HeavyBoots") {
        $itype = 3;
        $tier = 5;
        
        $ihp = tier2Hp($tier, 20);
        $imp = tier2Mp($tier, 40);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 30);
        $ispd = tier2Spd($tier, 140);
        $ievd = tier2Evd($tier, 50);
        $iint = tier2Int($tier, 40);
        
        $ifire_res = tier2Res($tier, 30);
        $iwater_res = tier2Res($tier, 30);
        $iground_res = tier2Res($tier, 30);
        $iwind_res = tier2Res($tier, 30);
        $ilight_res = tier2Res($tier, 30);
        $idark_res = tier2Res($tier, 30);
        
        $foundItem = true;
    }
    
    // CAPES

    if ($iname == "ClothCape") {
        $itype = 4;
        $tier = 1;
        
        $ihp = tier2Hp($tier, 20);
        $imp = tier2Mp($tier, 100);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 20);
        $ispd = tier2Spd($tier, 40);
        $ievd = tier2Evd($tier, 40);
        $iint = tier2Int($tier, 80);
        
        $ifire_res = tier2Res($tier, 30);
        $iwater_res = tier2Res($tier, 30);
        $iground_res = tier2Res($tier, 30);
        $iwind_res = tier2Res($tier, 30);
        $ilight_res = tier2Res($tier, 30);
        $idark_res = tier2Res($tier, 30);
        
        $foundItem = true;
    }

    if ($iname == "SilkCape") {
        $itype = 4;
        $tier = 2;
        
        $ihp = tier2Hp($tier, 10);
        $imp = tier2Mp($tier, 80);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 20);
        $ispd = tier2Spd($tier, 50);
        $ievd = tier2Evd($tier, 70);
        $iint = tier2Int($tier, 90);
        
        $ifire_res = tier2Res($tier, 40);
        $iwater_res = tier2Res($tier, 40);
        $iground_res = tier2Res($tier, 40);
        $iwind_res = tier2Res($tier, 40);
        $ilight_res = tier2Res($tier, 40);
        $idark_res = tier2Res($tier, 40);
        
        $foundItem = true;
    }
    
    if ($iname == "BloodCape") {
        $itype = 4;
        $tier = 3;
        
        $ihp = tier2Hp($tier, 20);
        $imp = tier2Mp($tier, 90);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 30);
        $ispd = tier2Spd($tier, 40);
        $ievd = tier2Evd($tier, 60);
        $iint = tier2Int($tier, 100);
        
        $ifire_res = tier2Res($tier, 80);
        $iwater_res = tier2Res($tier, 80);
        $iground_res = tier2Res($tier, 80);
        $iwind_res = tier2Res($tier, 80);
        $ilight_res = tier2Res($tier, 80);
        $idark_res = tier2Res($tier, 80);
        
        $foundItem = true;
    }
    
    if ($iname == "WindCape") {
        $itype = 4;
        $tier = 4;
        
        $ihp = tier2Hp($tier, 20);
        $imp = tier2Mp($tier, 90);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 30);
        $ispd = tier2Spd($tier, 40);
        $ievd = tier2Evd($tier, 60);
        $iint = tier2Int($tier, 100);
        
        $ifire_res = tier2Res($tier, 80);
        $iwater_res = tier2Res($tier, 80);
        $iground_res = tier2Res($tier, 80);
        $iwind_res = tier2Res($tier, 100);
        $ilight_res = tier2Res($tier, 80);
        $idark_res = tier2Res($tier, 80);
        
        $foundItem = true;
    }

    if ($iname == "WaterCape") {
        $itype = 4;
        $tier = 5;
        
        $ihp = tier2Hp($tier, 20);
        $imp = tier2Mp($tier, 90);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 30);
        $ispd = tier2Spd($tier, 40);
        $ievd = tier2Evd($tier, 60);
        $iint = tier2Int($tier, 100);
        
        $ifire_res = tier2Res($tier, 80);
        $iwater_res = tier2Res($tier, 100);
        $iground_res = tier2Res($tier, 80);
        $iwind_res = tier2Res($tier, 80);
        $ilight_res = tier2Res($tier, 80);
        $idark_res = tier2Res($tier, 80);
        
        $foundItem = true;
    }

    // CANES & RODS

    if ($iname == "Cane") {
        $itype = 1;
        $tier = 2;
        
        $ihp = tier2Hp($tier, 10);
        $imp = tier2Mp($tier, 90);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 10);
        $ispd = tier2Spd($tier, 40);
        $ievd = tier2Evd($tier, 20);
        $iint = tier2Int($tier, 100);
        
        $ifire_res = tier2Res($tier, 80);
        $iwater_res = tier2Res($tier, 80);
        $iground_res = tier2Res($tier, 80);
        $iwind_res = tier2Res($tier, 80);
        $ilight_res = tier2Res($tier, 80);
        $idark_res = tier2Res($tier, 80);
        
        $iclassreq = 3;
        $foundItem = true;
    }

    if ($iname == "WaterCane") {
        $itype = 1;
        $tier = 3;
        
        $ihp = tier2Hp($tier, 30);
        $imp = tier2Mp($tier, 90);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 10);
        $ispd = tier2Spd($tier, 40);
        $ievd = tier2Evd($tier, 30);
        $iint = tier2Int($tier, 100);
        
        $ifire_res = tier2Res($tier, 50);
        $iwater_res = tier2Res($tier, 100);
        $iground_res = tier2Res($tier, 50);
        $iwind_res = tier2Res($tier, 50);
        $ilight_res = tier2Res($tier, 50);
        $idark_res = tier2Res($tier, 50);
        
        $iclassreq = 3;
        $foundItem = true;
    }

    if ($iname == "FireCane") {
        $itype = 1;
        $tier = 4;
        
        $ihp = tier2Hp($tier, 30);
        $imp = tier2Mp($tier, 90);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 10);
        $ispd = tier2Spd($tier, 40);
        $ievd = tier2Evd($tier, 30);
        $iint = tier2Int($tier, 100);
        
        $ifire_res = tier2Res($tier, 100);
        $iwater_res = tier2Res($tier, 50);
        $iground_res = tier2Res($tier, 50);
        $iwind_res = tier2Res($tier, 50);
        $ilight_res = tier2Res($tier, 50);
        $idark_res = tier2Res($tier, 50);
        
        $iclassreq = 3;
        $foundItem = true;
    }
    
    if ($iname == "GroundCaneII") {
        $itype = 1;
        $tier = 4;
        
        $ihp = tier2Hp($tier, 30);
        $imp = tier2Mp($tier, 90);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 10);
        $ispd = tier2Spd($tier, 40);
        $ievd = tier2Evd($tier, 30);
        $iint = tier2Int($tier, 100);
        
        $ifire_res = tier2Res($tier, 50);
        $iwater_res = tier2Res($tier, 50);
        $iground_res = tier2Res($tier, 100);
        $iwind_res = tier2Res($tier, 50);
        $ilight_res = tier2Res($tier, 50);
        $idark_res = tier2Res($tier, 50);
        
        $iclassreq = 3;
        $foundItem = true;
    }
    
    if ($iname == "Rod") {
        $itype = 1;
        $tier = 5;
        
        $ihp = tier2Hp($tier, 30);
        $imp = tier2Mp($tier, 90);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 10);
        $ispd = tier2Spd($tier, 40);
        $ievd = tier2Evd($tier, 30);
        $iint = tier2Int($tier, 110);
        
        $ifire_res = tier2Res($tier, 90);
        $iwater_res = tier2Res($tier, 90);
        $iground_res = tier2Res($tier, 90);
        $iwind_res = tier2Res($tier, 90);
        $ilight_res = tier2Res($tier, 90);
        $idark_res = tier2Res($tier, 90);
        
        $iclassreq = 3;
        $foundItem = true;
    }
    
    // KATANAS
    
    if ($iname == "Katana") {
        $itype = 1;
        $tier = 2;
        
        $ihp = tier2Hp($tier, 60);
        $imp = tier2Mp($tier, 40);
        $iatk = tier2Atk($tier, 100);
        $idef = tier2Def($tier, 10);
        $ispd = tier2Spd($tier, 80);
        $ievd = tier2Evd($tier, 80);
        $iint = tier2Int($tier, 20);
        
        $ifire_res = tier2Res($tier, 0);
        $iwater_res = tier2Res($tier, 0);
        $iground_res = tier2Res($tier, 0);
        $iwind_res = tier2Res($tier, 0);
        $ilight_res = tier2Res($tier, 0);
        $idark_res = tier2Res($tier, 0);
        
        $iclassreq = 1;
        $foundItem = true;
    }

    if ($iname == "SteelKatana") {
        $itype = 1;
        $tier = 3;
        
        $ihp = tier2Hp($tier, 60);
        $imp = tier2Mp($tier, 40);
        $iatk = tier2Atk($tier, 100);
        $idef = tier2Def($tier, 10);
        $ispd = tier2Spd($tier, 80);
        $ievd = tier2Evd($tier, 80);
        $iint = tier2Int($tier, 20);
        
        $ifire_res = tier2Res($tier, 0);
        $iwater_res = tier2Res($tier, 0);
        $iground_res = tier2Res($tier, 0);
        $iwind_res = tier2Res($tier, 0);
        $ilight_res = tier2Res($tier, 0);
        $idark_res = tier2Res($tier, 0);
        
        $iclassreq = 1;
        $foundItem = true;
    }
    
    // DAGGERS
    
    if ($iname == "Dagger") {
        $itype = 1;
        $tier = 2;
        
        $ihp = tier2Hp($tier, 20);
        $imp = tier2Mp($tier, 60);
        $iatk = tier2Atk($tier, 80);
        $idef = tier2Def($tier, 20);
        $ispd = tier2Spd($tier, 100);
        $ievd = tier2Evd($tier, 100);
        $iint = tier2Int($tier, 20);
        
        $ifire_res = tier2Res($tier, 0);
        $iwater_res = tier2Res($tier, 0);
        $iground_res = tier2Res($tier, 0);
        $iwind_res = tier2Res($tier, 0);
        $ilight_res = tier2Res($tier, 0);
        $idark_res = tier2Res($tier, 0);
        
        $iclassreq = 2;
        $foundItem = true;
    }
    
    if ($iname == "SteelDagger") {
        $itype = 1;
        $tier = 3;
        
        $ihp = tier2Hp($tier, 20);
        $imp = tier2Mp($tier, 60);
        $iatk = tier2Atk($tier, 80);
        $idef = tier2Def($tier, 20);
        $ispd = tier2Spd($tier, 100);
        $ievd = tier2Evd($tier, 100);
        $iint = tier2Int($tier, 20);
        
        $ifire_res = tier2Res($tier, 0);
        $iwater_res = tier2Res($tier, 0);
        $iground_res = tier2Res($tier, 0);
        $iwind_res = tier2Res($tier, 0);
        $ilight_res = tier2Res($tier, 0);
        $idark_res = tier2Res($tier, 0);
        
        $iclassreq = 2;
        $foundItem = true;
    }
    
    if ($iname == "SilverDagger") {
        $itype = 1;
        $tier = 4;
        
        $ihp = tier2Hp($tier, 20);
        $imp = tier2Mp($tier, 60);
        $iatk = tier2Atk($tier, 80);
        $idef = tier2Def($tier, 20);
        $ispd = tier2Spd($tier, 100);
        $ievd = tier2Evd($tier, 100);
        $iint = tier2Int($tier, 20);
        
        $ifire_res = tier2Res($tier, 10);
        $iwater_res = tier2Res($tier, 20);
        $iground_res = tier2Res($tier, 10);
        $iwind_res = tier2Res($tier, 20);
        $ilight_res = tier2Res($tier, 10);
        $idark_res = tier2Res($tier, 20);
        
        $iclassreq = 2;
        $foundItem = true;
    }
    
    if ($iname == "GoldenDagger") {
        $itype = 1;
        $tier = 5;
        
        $ihp = tier2Hp($tier, 20);
        $imp = tier2Mp($tier, 60);
        $iatk = tier2Atk($tier, 80);
        $idef = tier2Def($tier, 20);
        $ispd = tier2Spd($tier, 100);
        $ievd = tier2Evd($tier, 100);
        $iint = tier2Int($tier, 20);
        
        $ifire_res = tier2Res($tier, 30);
        $iwater_res = tier2Res($tier, 20);
        $iground_res = tier2Res($tier, 30);
        $iwind_res = tier2Res($tier, 20);
        $ilight_res = tier2Res($tier, 30);
        $idark_res = tier2Res($tier, 20);
        
        $iclassreq = 2;
        $foundItem = true;
    }

    // ROBES
    
    if ($iname == "Robe") {
        $itype = 2;
        $tier = 2;
        
        $ihp = tier2Hp($tier, 10);
        $imp = tier2Mp($tier, 100);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 20);
        $ispd = tier2Spd($tier, 80);
        $ievd = tier2Evd($tier, 40);
        $iint = tier2Int($tier, 100);
        
        $ifire_res = tier2Res($tier, 100);
        $iwater_res = tier2Res($tier, 100);
        $iground_res = tier2Res($tier, 100);
        $iwind_res = tier2Res($tier, 100);
        $ilight_res = tier2Res($tier, 100);
        $idark_res = tier2Res($tier, 100);
        
        $iclassreq = 3;
        $foundItem = true;
    }
    
    if ($iname == "SilkRobe") {
        $itype = 2;
        $tier = 3;
        
        $ihp = tier2Hp($tier, 10);
        $imp = tier2Mp($tier, 100);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 20);
        $ispd = tier2Spd($tier, 80);
        $ievd = tier2Evd($tier, 40);
        $iint = tier2Int($tier, 100);
        
        $ifire_res = tier2Res($tier, 100);
        $iwater_res = tier2Res($tier, 100);
        $iground_res = tier2Res($tier, 100);
        $iwind_res = tier2Res($tier, 100);
        $ilight_res = tier2Res($tier, 100);
        $idark_res = tier2Res($tier, 100);
        
        $iclassreq = 3;
        $foundItem = true;
    }
    
    // RINGS
    
    if ($iname == "TreeRing") {
        $itype = 5;
        $tier = 1;
        
        $ihp = tier2Hp($tier, 10);
        $imp = tier2Mp($tier, 100);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 20);
        $ispd = tier2Spd($tier, 20);
        $ievd = tier2Evd($tier, 40);
        $iint = tier2Int($tier, 100);
        
        $ifire_res = tier2Res($tier, 100);
        $iwater_res = tier2Res($tier, 100);
        $iground_res = tier2Res($tier, 100);
        $iwind_res = tier2Res($tier, 100);
        $ilight_res = tier2Res($tier, 100);
        $idark_res = tier2Res($tier, 100);
        
        $foundItem = true;
    }

    if ($iname == "RubyRing") {
        $itype = 5;
        $tier = 2;
        
        $ihp = tier2Hp($tier, 10);
        $imp = tier2Mp($tier, 100);
        $iatk = tier2Atk($tier, 10);
        $idef = tier2Def($tier, 20);
        $ispd = tier2Spd($tier, 20);
        $ievd = tier2Evd($tier, 40);
        $iint = tier2Int($tier, 100);
        
        $ifire_res = tier2Res($tier, 200);
        $iwater_res = tier2Res($tier, 100);
        $iground_res = tier2Res($tier, 100);
        $iwind_res = tier2Res($tier, 100);
        $ilight_res = tier2Res($tier, 100);
        $idark_res = tier2Res($tier, 100);
        
        $foundItem = true;
    }

    if ($foundItem) {
        $stmt = $db->prepare("INSERT INTO rpg_items( name, type, inroom, ownerid, atk, def, spd, evd, hp, mp, int_stat, fire_res, water_res, ground_res, wind_res, light_res, dark_res, price, classreq ) VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
        $stmt->bind_param("siiiiiiiiiiiiiiiiii", $iname, $itype, $iinroom, $ownerid, $iatk, $idef, $ispd, $ievd, $ihp, $imp, $iint, $ifire_res, $iwater_res, $iground_res, $iwind_res, $ilight_res, $idark_res, $iprice, $iclassreq);
        if (!$stmt->execute()) {
            $ret = "could not spawn item {$iname}: could not execute query";
        }
        $stmt->close();
    }
    else {
        $ret = "could not spawn item {$iname}: unknown item";
    }

    return $ret;
}

?>
