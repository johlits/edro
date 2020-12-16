<?
header("Access-Control-Allow-Origin: *");
require_once "../crypto.php";

$data = $_REQUEST;

$info = decrypt($data['rpg']);
$info_arr = explode("<T>", $info);

$rpg = explode(" ", $info_arr[2]);
$pcnt = count($rpg);

if ($pcnt < 2 || $pcnt > 4) {
    return;
}

$GLOBALS['z'] = "~";
$GLOBALS['c'] = 1;

$charUpper = preg_replace("/[_~]/", '', $rpg[0]);
$char = strtolower($charUpper);

require_once "../config.php";
require_once 'functions.php';
require_once 'day.php';

if (cntCommands($db, $char) > 28800) {
	echo encrypt("Too many requests, please wait..");
	return;
}

$action = strtolower($rpg[1]);

if ($pcnt > 2) {
    $p1 = strtolower($rpg[2]);
}

if ($pcnt > 3) {
    $p2 = strtolower($rpg[3]);
}

require_once 'char.php';
require_once 'pets.php';
require_once 'battle.php';
require_once 'skills.php';
require_once 'items.php';
require_once 'itemstats.php';
require_once 'monsterstats.php';
require_once 'monsterskills.php';
require_once 'monsterdrops.php';
require_once 'monsters.php';

require_once 'dungeons/forest1.php';
require_once 'dungeons/forest2.php';
require_once 'dungeons/mushtrail.php';
require_once 'dungeons/forest3.php';
require_once 'dungeons/cave1.php';
require_once 'dungeons/cave2.php';
require_once 'dungeons/pubcrawl.php';
require_once 'dungeons/cave3.php';

if ($action == "") {
    $action == "version";
}
else if (!charExists($db, $char, $info_arr[1]) && $action != "create") {
    $ret = "does not exist with given e-mail";
    $action = "";
}

// no char actions
if ($action == "") {
}
else if ($action == "version") {
    $ret = getWelcome($db);
}
else if ($action == "help") {
    $ret = getHelp($db);
} else if ($action == "day") {
    $ret = getDay($db);
} // char actions
else if (($action == "stats" || $action == "char") && isset($p1) && isset($p2)) {
    $ret = setAutoCp($db, $char, $p1, $p2);
} else if (($action == "stats" || $action == "char") && isset($p1)) {
    $ret = placeCp($db, $char, $p1);
} else if (($action == "stats" || $action == "char")) {
    $ret = getStats($db, $char);
} else if ($action == "inventory" && isset($p1)) {
    $ret = getInventory($db, $char, $p1);
} else if ($action == "inventory") {
    $ret = getInventory($db, $char, "");
} else if ($action == "attack" && isset($p1)) {
    $ret = attack($db, $char, $p1, -1);
} else if ($action == "attack") {
    $ret = attack($db, $char, "", -1);
} else if ($action == "create") {
    $ret = "error creating character";
    $checkedEmail = checkEmail($db, $char);
    if ($checkedEmail != "") {
        $ret = create($db, $charUpper, $checkedEmail);
    }
} else if ($action == "untarget") {
    $ret = untargetChar($db, $char);
} else if ($action == "room") {
    $ret = getRoom($db, $char, true);
} else if ($action == "see") {
    $ret = see($db, $char);
} else if ($action == "skills" && isset($p1)) {
    $ret = skillTree($db, $char, $p1);
} else if ($action == "skills") {
    $ret = skillTree($db, $char, "");
} else if ($action == "unfollow") {
    $ret = unfollow($db, $char);
} else if ($action == "class" && isset($p1)) {
    $ret = pickClass($db, $char, $p1);
} else if ($action == "class") {
    $ret = listClass($db, $char);
} // char + 1 param actions
else if ($action == "forge" && isset($p1)) {
    $ret = forge($db, $char, $p1);
} else if ($action == "skill" && isset($p1) && isset($p2)) {
    $ret = useSkill($db, $char, $p1, $p2);
} else if ($action == "skill" && isset($p1)) {
    $ret = useSkill($db, $char, $p1, "");
} else if ($action == "inspect" && isset($p1)) {
    $ret = inspect($db, $char, $p1);
} else if ($action == "target" && isset($p1)) {
    $ret = target($db, $char, $p1);
} else if ($action == "target") {
    $ret = target($db, $char, $char);
} else if ($action == "unequip" && isset($p1)) {
    $ret = unequip($db, $char, $p1);
} else if ($action == "equip" && isset($p1)) {
    $ret = equip($db, $char, $p1);
} else if ($action == "pick" && isset($p1)) {
    $ret = pick($db, $char, $p1);
} else if ($action == "drop" && isset($p1)) {
    $ret = drop($db, $char, $p1);
} else if ($action == "move" && isset($p1) && isset($p2)) {
    $ret = move($db, $char, $p1, $p2);
} else if ($action == "move" && isset($p1)) {
    $ret = move($db, $char, $p1, "");
} else if ($action == "learn" && isset($p1)) {
    $ret = learnSkill($db, $char, $p1);
} else if ($action == "buy" && isset($p1) && isset($p2)) {
    $ret = buy($db, $char, $p1, $p2);
} else if ($action == "buy" && isset($p1)) {
    $ret = buy($db, $char, $p1, "");
} else if ($action == "follow" && isset($p1)) {
    $ret = follow($db, $char, $p1);
} else if ($action == "delete" && isset($p1)) {
    $ret = deleteChar($db, $char, $p1);
} // char + 2 param actions
else if ($action == "sell" && isset($p1) && isset($p2)) {
    $ret = sell($db, $char, $p1, $p2);
} else if ($action == "use" && isset($p1) && isset($p2)) {
    $ret = useItem($db, $char, $p1, $p2);
} else if ($action == "feed" && isset($p1) && isset($p2)) {
    $ret = feedPet($db, $char, $p1, $p2);
} else if ($action == "feed" && isset($p1)) {
    $ret = feedPet($db, $char, $p1, "");
} else if ($action == "rename" && isset($p1) && isset($p2)) {
    if ($p1 == "pet") {
        $ret = renamePet($db, $char, $p2);
    } else {
        $ret = "Cannot rename " . $p1;
    }
} else if ($action == "map" && isset($p1)) {
    $ret = getMap($db, $p1, "group");
} else if ($action == "devmap" && isset($p1) && $GLOBALS['dev'] == true) {
    $ret = getMap($db, $p1, "all");
} // default
else {

    if ($action == "aa") {
        $action = "assassinate";
    }

    if (getSkillId($action) > 0) {
        if (isset($p1)) {
            $p2 = $p1;
        }
        $p1 = $action;
        $action = "skill";
        if ($action == "skill" && isset($p1) && isset($p2)) {
            $ret = useSkill($db, $char, $p1, $p2);
        } else if ($action == "skill" && isset($p1)) {
            $ret = useSkill($db, $char, $p1, "");
        } else {
            $ret = "unknown action (type help)";
        }
    } else {
        $ret = "unknown action (type help)";
    }
}

$cap = 1000;

// log commands
if ($action == "devmap") {
	// no logging
}
else if ($action == "map") {
	if ($GLOBALS['log'] == true) {
		$cmd = mb_strimwidth($ret, 0, $cap, "...");
		$stmt = $db->prepare("INSERT INTO rpg_commands (cdate, name, action, p1, p2, result) VALUES (NOW(), ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $charUpper, $action, $p1, $p2, $cmd);
		$stmt->execute();
		$stmt->close();
	}
}
else {
    $ret = mb_strimwidth($ret, 0, $cap, "...");
	if ($GLOBALS['log'] == true) {
		$stmt = $db->prepare("INSERT INTO rpg_commands (cdate, name, action, p1, p2, result) VALUES (NOW(), ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $charUpper, $action, $p1, $p2, $ret);
		$stmt->execute();
		$stmt->close();
	}
}

echo encrypt($ret);

?>
