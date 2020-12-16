<?

function lvl2Hp($lvl, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($lvl < 10) {
        return intval($lvl * 10 * $balance / 100);
    }
    if ($lvl < 20) {
        return intval($lvl * 20 * $balance / 100);
    }
    if ($lvl < 30) {
        return intval($lvl * 40 * $balance / 100);
    }
    if ($lvl < 40) {
        return intval($lvl * 70 * $balance / 100);
    }
    return intval($lvl * 100 * $balance / 100);
}

function lvl2Mp($lvl, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($lvl < 10) {
        return intval($lvl * 5 * $balance / 100);
    }
    if ($lvl < 20) {
        return intval($lvl * 10 * $balance / 100);
    }
    if ($lvl < 30) {
        return intval($lvl * 20 * $balance / 100);
    }
    if ($lvl < 40) {
        return intval($lvl * 35 * $balance / 100);
    }
    return intval($lvl * 50 * $balance / 100);
}

function lvl2Atk($lvl, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($lvl < 10) {
        return intval($lvl * 7 * $balance / 100);
    }
    if ($lvl < 20) {
        return intval($lvl * 10 * $balance / 100);
    }
    if ($lvl < 30) {
        return intval($lvl * 14 * $balance / 100);
    }
    if ($lvl < 40) {
        return intval($lvl * 19 * $balance / 100);
    }
    return intval($lvl * 25 * $balance / 100);
}

function lvl2Def($lvl, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($lvl < 10) {
        return intval($lvl * 7 * $balance / 100);
    }
    if ($lvl < 20) {
        return intval($lvl * 10 * $balance / 100);
    }
    if ($lvl < 30) {
        return intval($lvl * 14 * $balance / 100);
    }
    if ($lvl < 40) {
        return intval($lvl * 19 * $balance / 100);
    }
    return intval($lvl * 25 * $balance / 100);
}

function lvl2Spd($lvl, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($lvl < 10) {
        return intval($lvl * 7 * $balance / 100);
    }
    if ($lvl < 20) {
        return intval($lvl * 10 * $balance / 100);
    }
    if ($lvl < 30) {
        return intval($lvl * 14 * $balance / 100);
    }
    if ($lvl < 40) {
        return intval($lvl * 19 * $balance / 100);
    }
    return intval($lvl * 25 * $balance / 100);
}

function lvl2Evd($lvl, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($lvl < 10) {
        return intval($lvl * 7 * $balance / 100);
    }
    if ($lvl < 20) {
        return intval($lvl * 10 * $balance / 100);
    }
    if ($lvl < 30) {
        return intval($lvl * 14 * $balance / 100);
    }
    if ($lvl < 40) {
        return intval($lvl * 19 * $balance / 100);
    }
    return intval($lvl * 25 * $balance / 100);
}

function lvl2Int($lvl, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($lvl < 10) {
        return intval($lvl * 7 * $balance / 100);
    }
    if ($lvl < 20) {
        return intval($lvl * 10 * $balance / 100);
    }
    if ($lvl < 30) {
        return intval($lvl * 14 * $balance / 100);
    }
    if ($lvl < 40) {
        return intval($lvl * 19 * $balance / 100);
    }
    return intval($lvl * 25 * $balance / 100);
}

function lvl2Exp($lvl, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($lvl < 10) {
        return intval($lvl * 5 * $balance / 100);
    }
    if ($lvl < 20) {
        return intval($lvl * 10 * $balance / 100);
    }
    if ($lvl < 30) {
        return intval($lvl * 15 * $balance / 100);
    }
    if ($lvl < 40) {
        return intval($lvl * 20 * $balance / 100);
    }
    return intval($lvl * 25 * $balance / 100);
}

function lvl2Gold($lvl, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    if ($lvl < 10) {
        return intval($lvl * 3 * $balance / 100);
    }
    if ($lvl < 20) {
        return intval($lvl * 5 * $balance / 100);
    }
    if ($lvl < 30) {
        return intval($lvl * 8 * $balance / 100);
    }
    if ($lvl < 40) {
        return intval($lvl * 12 * $balance / 100);
    }
    return intval($lvl * 17 * $balance / 100);
}

function lvl2Res($lvl, $balance = 100) {
    $variance = $balance * 0.2;
    $balance = $balance - $variance + rand(0, $variance * 2);
    
    return intval(($lvl / 2) * $balance / 100);
}

function monsterStats(&$db, $mon, $name, $room)
{

    if ($mon == "Critter") {
        $lvl = 2;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Spider") {
        $lvl = 3;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Bird") {
        $lvl = 4;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Frog") {
        $lvl = 5;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Snake") {
        $lvl = 6;
        $hp = lvl2Hp($lvl, 400);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 120);
        $def = lvl2Def($lvl, 80);
        $spd = lvl2Spd($lvl, 110);
        $evd = lvl2Evd($lvl, 130);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 400);
        $gold = lvl2Gold($lvl, 400);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Dino") {
        $lvl = 8;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Turtle") {
        $lvl = 8;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 80);
        $def = lvl2Def($lvl, 120);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 80);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Rex") {
        $lvl = 9;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Piraya") {
        $lvl = 9;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 160);
        $def = lvl2Def($lvl, 50);
        $spd = lvl2Spd($lvl, 140);
        $evd = lvl2Evd($lvl, 140);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Hippogriff") {
        $lvl = 11;
        $hp = lvl2Hp($lvl, 500);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 80);
        $def = lvl2Def($lvl, 120);
        $spd = lvl2Spd($lvl, 90);
        $evd = lvl2Evd($lvl, 110);
        $int = lvl2Int($lvl, 130);
        $exp = lvl2Exp($lvl, 400);
        $gold = lvl2Gold($lvl, 400);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 50);
        $wind_res = lvl2Res($lvl, 50);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "FireShroom") {
        $lvl = 12;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 100);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "WaterShroom") {
        $lvl = 12;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 100);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "GroundShroom") {
        $lvl = 12;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 100);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "WindShroom") {
        $lvl = 12;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 100);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "MentalShroom") {
        $lvl = 12;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 50);
        $ground_res = lvl2Res($lvl, 50);
        $water_res = lvl2Res($lvl, 50);
        $wind_res = lvl2Res($lvl, 50);
        $light_res = lvl2Res($lvl, 50);
        $dark_res = lvl2Res($lvl, 50);
    }
    else if ($mon == "ShroomMom") {
        $lvl = 13;
        $hp = lvl2Hp($lvl, 150);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 150);
        $def = lvl2Def($lvl, 150);
        $spd = lvl2Spd($lvl, 150);
        $evd = lvl2Evd($lvl, 150);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 150);
        $gold = lvl2Gold($lvl, 150);
        $fire_res = lvl2Res($lvl, 20);
        $ground_res = lvl2Res($lvl, 20);
        $water_res = lvl2Res($lvl, 20);
        $wind_res = lvl2Res($lvl, 20);
        $light_res = lvl2Res($lvl, 20);
        $dark_res = lvl2Res($lvl, 20);
    }
    else if ($mon == "SeaDragon") {
        $lvl = 14;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 100);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "FireWorm") {
        $lvl = 15;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 100);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Dactyl") {
        $lvl = 16;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 120);
        $def = lvl2Def($lvl, 50);
        $spd = lvl2Spd($lvl, 150);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 100);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "SandRaptor") {
        $lvl = 17;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 90);
        $def = lvl2Def($lvl, 150);
        $spd = lvl2Spd($lvl, 140);
        $evd = lvl2Evd($lvl, 60);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 100);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Mammoth") {
        $lvl = 18;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 120);
        $def = lvl2Def($lvl, 120);
        $spd = lvl2Spd($lvl, 80);
        $evd = lvl2Evd($lvl, 80);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "IceDragon") {
        $lvl = 20;
        $hp = lvl2Hp($lvl, 600);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 120);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 140);
        $evd = lvl2Evd($lvl, 90);
        $int = lvl2Int($lvl, 140);
        $exp = lvl2Exp($lvl, 400);
        $gold = lvl2Gold($lvl, 400);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 100);
        $wind_res = lvl2Res($lvl, 100);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Golem") {
        $lvl = 21;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Bat") {
        $lvl = 22;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 80);
        $spd = lvl2Spd($lvl, 120);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Tarantula") {
        $lvl = 23;
        $hp = lvl2Hp($lvl, 100);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 100);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Mole") {
        $lvl = 24;
        $hp = lvl2Hp($lvl, 130);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 120);
        $def = lvl2Def($lvl, 140);
        $spd = lvl2Spd($lvl, 80);
        $evd = lvl2Evd($lvl, 70);
        $int = lvl2Int($lvl, 50);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 0);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "Troll") {
        $lvl = 25;
        $hp = lvl2Hp($lvl, 90);
        $mp = lvl2Mp($lvl, 110);
        $atk = lvl2Atk($lvl, 80);
        $def = lvl2Def($lvl, 90);
        $spd = lvl2Spd($lvl, 110);
        $evd = lvl2Evd($lvl, 120);
        $int = lvl2Int($lvl, 140);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 50);
        $ground_res = lvl2Res($lvl, 50);
        $water_res = lvl2Res($lvl, 50);
        $wind_res = lvl2Res($lvl, 50);
        $light_res = lvl2Res($lvl, 50);
        $dark_res = lvl2Res($lvl, 50);
    }
    else if ($mon == "CaveBear") {
        $lvl = 27;
        $hp = lvl2Hp($lvl, 600);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 160);
        $def = lvl2Def($lvl, 140);
        $spd = lvl2Spd($lvl, 80);
        $evd = lvl2Evd($lvl, 80);
        $int = lvl2Int($lvl, 60);
        $exp = lvl2Exp($lvl, 400);
        $gold = lvl2Gold($lvl, 400);
        $fire_res = lvl2Res($lvl, 0);
        $ground_res = lvl2Res($lvl, 100);
        $water_res = lvl2Res($lvl, 0);
        $wind_res = lvl2Res($lvl, 0);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "SilverRaptor") {
        $lvl = 29;
        $hp = lvl2Hp($lvl, 110);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 120);
        $def = lvl2Def($lvl, 60);
        $spd = lvl2Spd($lvl, 140);
        $evd = lvl2Evd($lvl, 130);
        $int = lvl2Int($lvl, 90);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 40);
        $ground_res = lvl2Res($lvl, 40);
        $water_res = lvl2Res($lvl, 40);
        $wind_res = lvl2Res($lvl, 40);
        $light_res = lvl2Res($lvl, 40);
        $dark_res = lvl2Res($lvl, 40);
    }
    else if ($mon == "GoldRaptor") {
        $lvl = 31;
        $hp = lvl2Hp($lvl, 110);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 120);
        $def = lvl2Def($lvl, 70);
        $spd = lvl2Spd($lvl, 130);
        $evd = lvl2Evd($lvl, 140);
        $int = lvl2Int($lvl, 90);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 40);
        $ground_res = lvl2Res($lvl, 40);
        $water_res = lvl2Res($lvl, 40);
        $wind_res = lvl2Res($lvl, 40);
        $light_res = lvl2Res($lvl, 40);
        $dark_res = lvl2Res($lvl, 40);
    }
    else if ($mon == "RubiFlower") {
        $lvl = 30;
        $hp = lvl2Hp($lvl, 90);
        $mp = lvl2Mp($lvl, 120);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 110);
        $spd = lvl2Spd($lvl, 90);
        $evd = lvl2Evd($lvl, 100);
        $int = lvl2Int($lvl, 130);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 100);
        $ground_res = lvl2Res($lvl, 20);
        $water_res = lvl2Res($lvl, 20);
        $wind_res = lvl2Res($lvl, 20);
        $light_res = lvl2Res($lvl, 20);
        $dark_res = lvl2Res($lvl, 20);
    }
    else if ($mon == "QuarzDroplet") {
        $lvl = 30;
        $hp = lvl2Hp($lvl, 110);
        $mp = lvl2Mp($lvl, 130);
        $atk = lvl2Atk($lvl, 100);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 110);
        $evd = lvl2Evd($lvl, 90);
        $int = lvl2Int($lvl, 120);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 20);
        $ground_res = lvl2Res($lvl, 20);
        $water_res = lvl2Res($lvl, 100);
        $wind_res = lvl2Res($lvl, 20);
        $light_res = lvl2Res($lvl, 0);
        $dark_res = lvl2Res($lvl, 0);
    }
    else if ($mon == "DiamondDrake") {
        $lvl = 30;
        $hp = lvl2Hp($lvl, 130);
        $mp = lvl2Mp($lvl, 130);
        $atk = lvl2Atk($lvl, 140);
        $def = lvl2Def($lvl, 90);
        $spd = lvl2Spd($lvl, 80);
        $evd = lvl2Evd($lvl, 150);
        $int = lvl2Int($lvl, 130);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 20);
        $ground_res = lvl2Res($lvl, 20);
        $water_res = lvl2Res($lvl, 20);
        $wind_res = lvl2Res($lvl, 100);
        $light_res = lvl2Res($lvl, 20);
        $dark_res = lvl2Res($lvl, 20);
    }
    else if ($mon == "MagneMon") {
        $lvl = 30;
        $hp = lvl2Hp($lvl, 140);
        $mp = lvl2Mp($lvl, 120);
        $atk = lvl2Atk($lvl, 90);
        $def = lvl2Def($lvl, 150);
        $spd = lvl2Spd($lvl, 140);
        $evd = lvl2Evd($lvl, 80);
        $int = lvl2Int($lvl, 110);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 20);
        $ground_res = lvl2Res($lvl, 100);
        $water_res = lvl2Res($lvl, 20);
        $wind_res = lvl2Res($lvl, 20);
        $light_res = lvl2Res($lvl, 20);
        $dark_res = lvl2Res($lvl, 20);
    }
    else if ($mon == "TitanWiz") {
        $lvl = 34;
        $hp = lvl2Hp($lvl, 600);
        $mp = lvl2Mp($lvl, 200);
        $atk = lvl2Atk($lvl, 140);
        $def = lvl2Def($lvl, 150);
        $spd = lvl2Spd($lvl, 150);
        $evd = lvl2Evd($lvl, 140);
        $int = lvl2Int($lvl, 180);
        $exp = lvl2Exp($lvl, 400);
        $gold = lvl2Gold($lvl, 400);
        $fire_res = lvl2Res($lvl, 50);
        $ground_res = lvl2Res($lvl, 50);
        $water_res = lvl2Res($lvl, 50);
        $wind_res = lvl2Res($lvl, 50);
        $light_res = lvl2Res($lvl, 50);
        $dark_res = lvl2Res($lvl, 50);
    } else if ($mon == "Carglaerbs") {
        $lvl = 24;
        $hp = lvl2Hp($lvl, 120);
        $mp = lvl2Mp($lvl, 110);
        $atk = lvl2Atk($lvl, 90);
        $def = lvl2Def($lvl, 90);
        $spd = lvl2Spd($lvl, 100);
        $evd = lvl2Evd($lvl, 110);
        $int = lvl2Int($lvl, 80);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 20);
        $ground_res = lvl2Res($lvl, 20);
        $water_res = lvl2Res($lvl, 20);
        $wind_res = lvl2Res($lvl, 20);
        $light_res = lvl2Res($lvl, 20);
        $dark_res = lvl2Res($lvl, 30);
    } else if ($mon == "Ekneineh") {
        $lvl = 25;
        $hp = lvl2Hp($lvl, 110);
        $mp = lvl2Mp($lvl, 90);
        $atk = lvl2Atk($lvl, 90);
        $def = lvl2Def($lvl, 200);
        $spd = lvl2Spd($lvl, 200);
        $evd = lvl2Evd($lvl, 80);
        $int = lvl2Int($lvl, 70);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 30);
        $ground_res = lvl2Res($lvl, 40);
        $water_res = lvl2Res($lvl, 20);
        $wind_res = lvl2Res($lvl, 40);
        $light_res = lvl2Res($lvl, 30);
        $dark_res = lvl2Res($lvl, 40);
    } else if ($mon == "Insgues") {
        $lvl = 26;
        $hp = lvl2Hp($lvl, 200);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 200);
        $def = lvl2Def($lvl, 200);
        $spd = lvl2Spd($lvl, 80);
        $evd = lvl2Evd($lvl, 90);
        $int = lvl2Int($lvl, 70);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 30);
        $ground_res = lvl2Res($lvl, 50);
        $water_res = lvl2Res($lvl, 40);
        $wind_res = lvl2Res($lvl, 30);
        $light_res = lvl2Res($lvl, 40);
        $dark_res = lvl2Res($lvl, 50);
    } else if ($mon == "Ranoco") {
        $lvl = 27;
        $hp = lvl2Hp($lvl, 80);
        $mp = lvl2Mp($lvl, 100);
        $atk = lvl2Atk($lvl, 90);
        $def = lvl2Def($lvl, 80);
        $spd = lvl2Spd($lvl, 200);
        $evd = lvl2Evd($lvl, 200);
        $int = lvl2Int($lvl, 70);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 50);
        $ground_res = lvl2Res($lvl, 20);
        $water_res = lvl2Res($lvl, 30);
        $wind_res = lvl2Res($lvl, 20);
        $light_res = lvl2Res($lvl, 50);
        $dark_res = lvl2Res($lvl, 30);
    } else if ($mon == "Weltencasw") {
        $lvl = 28;
        $hp = lvl2Hp($lvl, 110);
        $mp = lvl2Mp($lvl, 120);
        $atk = lvl2Atk($lvl, 80);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 80);
        $evd = lvl2Evd($lvl, 90);
        $int = lvl2Int($lvl, 120);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 80);
        $ground_res = lvl2Res($lvl, 40);
        $water_res = lvl2Res($lvl, 40);
        $wind_res = lvl2Res($lvl, 40);
        $light_res = lvl2Res($lvl, 40);
        $dark_res = lvl2Res($lvl, 40);
    } else if ($mon == "Biswuered") {
        $lvl = 29;
        $hp = lvl2Hp($lvl, 110);
        $mp = lvl2Mp($lvl, 120);
        $atk = lvl2Atk($lvl, 80);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 80);
        $evd = lvl2Evd($lvl, 90);
        $int = lvl2Int($lvl, 120);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 40);
        $ground_res = lvl2Res($lvl, 80);
        $water_res = lvl2Res($lvl, 40);
        $wind_res = lvl2Res($lvl, 40);
        $light_res = lvl2Res($lvl, 40);
        $dark_res = lvl2Res($lvl, 40);
    } else if ($mon == "Jaritmegrese") {
        $lvl = 30;
        $hp = lvl2Hp($lvl, 110);
        $mp = lvl2Mp($lvl, 120);
        $atk = lvl2Atk($lvl, 80);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 80);
        $evd = lvl2Evd($lvl, 90);
        $int = lvl2Int($lvl, 120);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 40);
        $ground_res = lvl2Res($lvl, 40);
        $water_res = lvl2Res($lvl, 80);
        $wind_res = lvl2Res($lvl, 40);
        $light_res = lvl2Res($lvl, 40);
        $dark_res = lvl2Res($lvl, 40);
    } else if ($mon == "Jealknaidsc") {
        $lvl = 31;
        $hp = lvl2Hp($lvl, 110);
        $mp = lvl2Mp($lvl, 120);
        $atk = lvl2Atk($lvl, 80);
        $def = lvl2Def($lvl, 100);
        $spd = lvl2Spd($lvl, 80);
        $evd = lvl2Evd($lvl, 90);
        $int = lvl2Int($lvl, 120);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 40);
        $ground_res = lvl2Res($lvl, 40);
        $water_res = lvl2Res($lvl, 40);
        $wind_res = lvl2Res($lvl, 80);
        $light_res = lvl2Res($lvl, 40);
        $dark_res = lvl2Res($lvl, 40);
    } else if ($mon == "Spyritis") {
        $lvl = 33;
        $hp = lvl2Hp($lvl, 600);
        $mp = lvl2Mp($lvl, 140);
        $atk = lvl2Atk($lvl, 80);
        $def = lvl2Def($lvl, 90);
        $spd = lvl2Spd($lvl, 70);
        $evd = lvl2Evd($lvl, 70);
        $int = lvl2Int($lvl, 130);
        $exp = lvl2Exp($lvl, 400);
        $gold = lvl2Gold($lvl, 400);
        $fire_res = lvl2Res($lvl, 40);
        $ground_res = lvl2Res($lvl, 40);
        $water_res = lvl2Res($lvl, 40);
        $wind_res = lvl2Res($lvl, 40);
        $light_res = lvl2Res($lvl, 120);
        $dark_res = lvl2Res($lvl, 0);
    } else if ($mon == "Basilisk") {
        $lvl = 32;
        $hp = lvl2Hp($lvl, 140);
        $mp = lvl2Mp($lvl, 130);
        $atk = lvl2Atk($lvl, 130);
        $def = lvl2Def($lvl, 140);
        $spd = lvl2Spd($lvl, 20);
        $evd = lvl2Evd($lvl, 130);
        $int = lvl2Int($lvl, 130);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 20);
        $ground_res = lvl2Res($lvl, 100);
        $water_res = lvl2Res($lvl, 20);
        $wind_res = lvl2Res($lvl, 20);
        $light_res = lvl2Res($lvl, 20);
        $dark_res = lvl2Res($lvl, 20);
    } else if ($mon == "Behir") {
        $lvl = 33;
        $hp = lvl2Hp($lvl, 130);
        $mp = lvl2Mp($lvl, 140);
        $atk = lvl2Atk($lvl, 140);
        $def = lvl2Def($lvl, 130);
        $spd = lvl2Spd($lvl, 110);
        $evd = lvl2Evd($lvl, 20);
        $int = lvl2Int($lvl, 140);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 20);
        $ground_res = lvl2Res($lvl, 100);
        $water_res = lvl2Res($lvl, 20);
        $wind_res = lvl2Res($lvl, 20);
        $light_res = lvl2Res($lvl, 20);
        $dark_res = lvl2Res($lvl, 20);
    } else if ($mon == "Drider") {
        $lvl = 34;
        $hp = lvl2Hp($lvl, 110);
        $mp = lvl2Mp($lvl, 90);
        $atk = lvl2Atk($lvl, 110);
        $def = lvl2Def($lvl, 90);
        $spd = lvl2Spd($lvl, 110);
        $evd = lvl2Evd($lvl, 90);
        $int = lvl2Int($lvl, 110);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 80);
        $ground_res = lvl2Res($lvl, 20);
        $water_res = lvl2Res($lvl, 20);
        $wind_res = lvl2Res($lvl, 40);
        $light_res = lvl2Res($lvl, 20);
        $dark_res = lvl2Res($lvl, 20);
    } else if ($mon == "Cloaker") {
        $lvl = 35;
        $hp = lvl2Hp($lvl, 80);
        $mp = lvl2Mp($lvl, 120);
        $atk = lvl2Atk($lvl, 80);
        $def = lvl2Def($lvl, 90);
        $spd = lvl2Spd($lvl, 120);
        $evd = lvl2Evd($lvl, 110);
        $int = lvl2Int($lvl, 120);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 60);
        $ground_res = lvl2Res($lvl, 30);
        $water_res = lvl2Res($lvl, 100);
        $wind_res = lvl2Res($lvl, 40);
        $light_res = lvl2Res($lvl, 60);
        $dark_res = lvl2Res($lvl, 50);
    } else if ($mon == "Minotaur") {
        $lvl = 36;
        $hp = lvl2Hp($lvl, 190);
        $mp = lvl2Mp($lvl, 90);
        $atk = lvl2Atk($lvl, 150);
        $def = lvl2Def($lvl, 140);
        $spd = lvl2Spd($lvl, 50);
        $evd = lvl2Evd($lvl, 40);
        $int = lvl2Int($lvl, 80);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 10);
        $ground_res = lvl2Res($lvl, 60);
        $water_res = lvl2Res($lvl, 60);
        $wind_res = lvl2Res($lvl, 30);
        $light_res = lvl2Res($lvl, 20);
        $dark_res = lvl2Res($lvl, 30);
    } else if ($mon == "Troglodyte") {
        $lvl = 37;
        $hp = lvl2Hp($lvl, 80);
        $mp = lvl2Mp($lvl, 70);
        $atk = lvl2Atk($lvl, 80);
        $def = lvl2Def($lvl, 90);
        $spd = lvl2Spd($lvl, 190);
        $evd = lvl2Evd($lvl, 220);
        $int = lvl2Int($lvl, 80);
        $exp = lvl2Exp($lvl, 100);
        $gold = lvl2Gold($lvl, 100);
        $fire_res = lvl2Res($lvl, 40);
        $ground_res = lvl2Res($lvl, 20);
        $water_res = lvl2Res($lvl, 30);
        $wind_res = lvl2Res($lvl, 100);
        $light_res = lvl2Res($lvl, 30);
        $dark_res = lvl2Res($lvl, 20);
    } else if ($mon == "MindFlayer") {
        $lvl = 40;
        $hp = lvl2Hp($lvl, 400);
        $mp = lvl2Mp($lvl, 200);
        $atk = lvl2Atk($lvl, 110);
        $def = lvl2Def($lvl, 140);
        $spd = lvl2Spd($lvl, 130);
        $evd = lvl2Evd($lvl, 130);
        $int = lvl2Int($lvl, 140);
        $exp = lvl2Exp($lvl, 400);
        $gold = lvl2Gold($lvl, 400);
        $fire_res = lvl2Res($lvl, 60);
        $ground_res = lvl2Res($lvl, 40);
        $water_res = lvl2Res($lvl, 50);
        $wind_res = lvl2Res($lvl, 30);
        $light_res = lvl2Res($lvl, 70);
        $dark_res = lvl2Res($lvl, 50);
    } else {
        return false;
    }

    $isplayer = 0;
    $stmtMon = $db->prepare("INSERT INTO rpg_chars( name, isplayer, maxhp, hp, maxmp, mp, atk, def, spd, evd, current_room, exp, lvl, gold, hp_v1, mp_v1, int_stat, fire_res, water_res, ground_res, wind_res, light_res, dark_res ) VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0, ?, ?, ?, ?, ?, ?, ?)");
    $stmtMon->bind_param("siiiiiiiiiiiiiiiiiiii", $name, $isplayer, $hp, $hp, $mp, $mp, $atk, $def, $spd, $evd, $room, $exp, $lvl, $gold, $int, $fire_res, $water_res, $ground_res, $wind_res, $light_res, $dark_res);
    $stmtMon->execute();
    $monid = $stmtMon->insert_id;
    $stmtMon->close();

    return $monid;

}

?>
