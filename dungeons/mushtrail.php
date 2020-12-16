<?
function mushtrail_monsters(&$db, $rid, $i, $spawnRate) {
	$ret = "";
	if ($rid == 54) { // SP1
		$ret = $ret . createMonster($db, $rid, "FireShroom");
	}
	if ($rid == 55) { // SP2
		$ret = $ret . createMonster($db, $rid, "WaterShroom");
	}
	if ($rid == 56) { // SP3
		$ret = $ret . createMonster($db, $rid, "GroundShroom");
	}
	if ($rid == 57) { // SP4
		$ret = $ret . createMonster($db, $rid, "WindShroom");
	}
	if ($rid == 58) { // SP5
		$ret = $ret . createMonster($db, $rid, "MentalShroom");
	}
	if ($rid == 59) { // SP6
		$ret = $ret . createMonster($db, $rid, "ShroomMom_BOSS");
	}
	return $ret;
}

?>