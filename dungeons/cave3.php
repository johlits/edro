<?
function cave3_monsters(&$db, $rid, $i, $spawnRate) {
	$ret = "";
	if ($rid == 158) { // 3A
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Basilisk", $i++));
        
	}
    if ($rid == 159) { // 3B
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Behir", $i++));
        
    }
    if ($rid == 160) { // 3C
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Drider", $i++));
        
    }
    if ($rid == 161) { // 3D
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Cloaker", $i++));
        
    }
    if ($rid == 162) { // 3E
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Minotaur", $i++));
        
    }
    if ($rid == 163) { // 3F
        if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
        
    }
    if ($rid == 164) { // 3G
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Basilisk", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Behir", $i++));
        
    }
    if ($rid == 165) { // 3H
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Behir", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Drider", $i++));
        
    }
    if ($rid == 166) { // 3I
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Drider", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Cloaker", $i++));
        
    }
    if ($rid == 167) { // 3J
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Cloaker", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Minotaur", $i++));
        
    }
    if ($rid == 168) { // 3K
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Minotaur", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
        
    }
    if ($rid == 169) { // 3L
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
        
    }
    if ($rid == 170) { // 3M
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Basilisk", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Behir", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Drider", $i++));
        
    }
    if ($rid == 171) { // 3N
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Behir", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Drider", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Cloaker", $i++));
        
    }
    if ($rid == 172) { // 3O
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Drider", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Cloaker", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Minotaur", $i++));
        
    }
    if ($rid == 173) { // 3P
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Cloaker", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Minotaur", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
        
    }
    if ($rid == 174) { // 3Q
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Minotaur", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
        
    }
    if ($rid == 175) { // 3R
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
        
    }
    if ($rid == 176) { // 3S
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Behir", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Drider", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Cloaker", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Drider", $i++));
        
    }
    if ($rid == 177) { // 3T
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Drider", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Cloaker", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Minotaur", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
        
    }
    if ($rid == 178) { // 3U
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Cloaker", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Minotaur", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Basilisk", $i++));
        
    }
    if ($rid == 179) { // 3V
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Minotaur", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Basilisk", $i++));
        
    }
    if ($rid == 180) { // 3X
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Minotaur", $i++));
        
    }
    if ($rid == 181) { // 3Y
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
		if (rand(1, 100) < $spawnRate) $ret = $ret . createMonster($db, $rid, appMonName("Troglodyte", $i++));
        
    }
	if ($rid == 182) { // 3Z
		$ret = $ret . createMonster($db, $rid, "MindFlayer_BOSS");
	}
	return $ret;
}

function taxi_rooms_connections(&$db) {
	$stmt = $db->prepare("INSERT INTO rpg_rooms (id, name, type, description) VALUES (183, 'TaxiHub', 0, 'Welcome to the taxi hub! Fast travel to different locations from here.')");
	$stmt->execute();
    $stmt->close();
	
	$stmt = $db->prepare("INSERT INTO rpg_connections (id, from_room, to_room, lvlcap) VALUES
	(366, 183, 1, 0),
	(367, 183, 106, 15),
	(368, 1, 183, 0),
    (369, 106, 183, 0)");
	$ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

function cave_library(&$db) {
	$stmt = $db->prepare("INSERT INTO rpg_rooms (id, name, type, description) VALUES
	(184, 'Library_Cave', 0, 'You enter a cave shaped as a fossil.'),
    (185, 'Library_C1', 0, ''),
    (186, 'Library_C2', 0, ''),
	(187, 'Library_C3', 0, '')");
	$ok1 = $stmt->execute();
    $stmt->close();
	
	$stmt = $db->prepare("INSERT INTO rpg_connections (id, from_room, to_room, lvlcap) VALUES
    (370, 106, 184, 0),
    (371, 184, 106, 0),
	(372, 184, 185, 0),
	(373, 185, 184, 0),
	(374, 184, 186, 0),
	(375, 186, 184, 0),
	(376, 184, 187, 0),
	(377, 187, 184, 0)");
	$ok2 = $stmt->execute();
    $stmt->close();
    return $ok1 && $ok2;
}

function cave3_rooms(&$db) {
	$stmt = $db->prepare("INSERT INTO rpg_rooms (id, name, type, description) VALUES
	(158, 'Cave_3A', 0, 'You enter a cave shaped as a fossil.'),
    (159, 'Cave_3B', 0, 'Horrible sounds echoes from within.'),
    (160, 'Cave_3C', 0, ''),
    (161, 'Cave_3D', 0, ''),
    (162, 'Cave_3E', 0, ''),
    (163, 'Cave_3F', 0, ''),
    (164, 'Cave_3G', 0, ''),
    (165, 'Cave_3H', 0, ''),
    (166, 'Cave_3I', 0, ''),
    (167, 'Cave_3J', 0, ''),
    (168, 'Cave_3K', 0, ''),
    (169, 'Cave_3L', 0, ''),
    (170, 'Cave_3M', 0, ''),
    (171, 'Cave_3N', 0, ''),
    (172, 'Cave_3O', 0, ''),
    (173, 'Cave_3P', 0, ''),
    (174, 'Cave_3Q', 0, ''),
    (175, 'Cave_3R', 0, ''),
    (176, 'Cave_3S', 0, ''),
    (177, 'Cave_3T', 0, ''),
    (178, 'Cave_3U', 0, ''),
    (179, 'Cave_3V', 0, ''),
    (180, 'Cave_3X', 0, ''),
    (181, 'Cave_3Y', 0, ''),
	(182, 'Cave_3Z', 0, 'You enter a dark room when mysterious shapes appear in front of your eyes. The great Mind Flayer has entered your mind!')");
	$ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

function cave3_connections(&$db) {
	$stmt = $db->prepare("INSERT INTO rpg_connections (id, from_room, to_room, lvlcap) VALUES
	(305, 107, 158, 18),
    (306, 158, 107, 0),
    (307, 158, 163, 0),
    (308, 163, 158, 0),
    (309, 163, 168, 0),
    (310, 168, 163, 0),
    (311, 168, 173, 0),
    (312, 173, 168, 0),
    (313, 173, 174, 0),
    (314, 173, 178, 0),
    (315, 178, 173, 0),
    (316, 178, 179, 0),
    (317, 179, 178, 0),
    (318, 179, 180, 0),
    (319, 180, 179, 0),
    (320, 180, 175, 0),
    (321, 180, 181, 0),
    (322, 181, 180, 0),
    (323, 181, 182, 0),
    (324, 182, 181, 0),
    (325, 182, 177, 0),
    (326, 177, 182, 0),
    (327, 177, 176, 0),
    (328, 177, 172, 0),
    (329, 172, 177, 0),
    (330, 172, 167, 0),
    (331, 167, 172, 0),
    (332, 167, 166, 0),
    (333, 167, 162, 0),
    (334, 162, 167, 0),
    (335, 162, 161, 0),
    (336, 161, 162, 0),
    (337, 161, 160, 0),
    (338, 160, 161, 0),
    (339, 160, 165, 0),
    (340, 160, 159, 0),
    (341, 159, 160, 0),
    (342, 159, 164, 0),
    (343, 164, 159, 0),
    (344, 164, 165, 0),
    (345, 164, 169, 0),
    (346, 169, 164, 0),
    (347, 169, 168, 0),
    (348, 169, 174, 0),
    (349, 174, 169, 0),
    (350, 174, 175, 0),
    (351, 174, 179, 0),
    (352, 175, 174, 0),
    (353, 175, 176, 0),
    (354, 176, 175, 0),
    (355, 176, 181, 0),
    (356, 176, 171, 0),
    (357, 171, 176, 0),
    (358, 171, 172, 0),
    (359, 171, 166, 0),
    (360, 166, 161, 0),
    (361, 166, 171, 0),
    (362, 166, 165, 0),
    (363, 165, 166, 0),
    (364, 165, 170, 0),
    (365, 170, 107, 0)");
	$ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

function cave3_rename(&$db) {
    $stmt = $db->prepare("INSERT INTO rpg_rooms (id, name, type, description) VALUES
        (1, 'Hub_Forest', 1, 'People can gather in the Hub.'),
        (3, 'Portal_Forest', 1, 'The portal leads to different dungeons.'),
        (4, 'FOREST_1A', 0, 'Rays of sunlight are bursting through the trees as you step into the sparse forest.'),
        (5, 'FOREST_1B', 0, 'Small critters occupy the the floor of leaves scattered around the forest.'),
        (6, 'FOREST_1C', 0, 'You find giant spider webs woven between the trees. '),
        (7, 'FOREST_1D', 0, 'Spiders are trapping the smaller animals in their webs as you wander on.'),
        (8, 'FOREST_1E', 0, 'As you wander on it gets darker and creepier as sounds of animals crackle in the woodland.'),
        (9, 'FOREST_1F', 0, 'You hear sounds of birds through the trees as you ascend a small hill. '),
        (10, 'FOREST_1G', 0, 'The ground dampens up as you walk through a small swamp. '),
        (11, 'FOREST_1H', 0, 'All sorts of animals ambush you as you come across a large cliff. '),
        (12, 'FOREST_1I', 0, 'You finally see the light coming forth from a glade in the forest.'),
        (13, 'FOREST_1J', 0, 'A giant snake appears from under a huge rock, there is no escape!'),
        (14, 'FOREST_2A', 0, 'Animal skeletons are scattered throughout a rocky area.'),
        (15, 'Market_Forest', 3, 'A marketplace where players buy and sell items.'),
        (16, 'FOREST_2B', 0, 'Dinosaurs dominate this sparse domain of the forest.'),
        (17, 'FOREST_2C', 0, 'A giant Rexosaurus towers before you.'),
        (18, 'FOREST_2D', 0, 'As you venture into a small cavern you find a giant turtle.'),
        (19, 'FOREST_2E', 0, 'Old fossils tell tales of the past.'),
        (20, 'FOREST_2F', 0, 'Wading through a small pond, wild pirayas attack from below.'),
        (21, 'FOREST_2G', 0, 'Wandering through more wet lands, monsters of the habitat attack.'),
        (22, 'FOREST_2H', 0, 'You come across some ruins covered with vegetation.'),
        (23, 'FOREST_2I', 0, 'Two Rexosaurus are feasting on flesh of a dead animal.'),
        (24, 'FOREST_2J', 0, 'You cross a small river as the bridge is broken.'),
        (25, 'FOREST_2K', 0, 'The forest becomes more dense as you travel on.'),
        (26, 'FOREST_2L', 0, 'Wading through muddy waters.'),
        (27, 'FOREST_2M', 0, 'Climbing up a small cliff you encounter more dinosaurs.'),
        (28, 'FOREST_2N', 0, 'You discover a swamp full of mosquitos and various monsters.'),
        (29, 'FOREST_2O', 0, 'You have no option but to swim through a large puddle of water.'),
        (30, 'FOREST_2P', 0, 'The cold air sends shivers up your spine.'),
        (31, 'FOREST_2Q', 0, 'As you light a fire to warm yourself, animals ambush you from all sides.'),
        (32, 'FOREST_2R', 0, 'A giant snake appears out of nowhere! Where have I seen this before?'),
        (33, 'FOREST_2S', 0, 'Animals hungry for flesh move towards you!'),
        (34, 'FOREST_2T', 0, 'As the moonlight reflects off the wet and slippery rocks near a waterfall the great Hippogriff notices your presence!'),
        (35, 'Pet_Garden', 1, 'A green garden where various pets are bred.'),
        (36, 'FOREST_3A', 0, 'Darkness surrounds you as you enter the deep part of the forest.'),
        (37, 'FOREST_3B', 0, 'Only few have dared enter these grounds.'),
        (38, 'FOREST_3C', 0, 'A strange sense of magic is present in the air.'),
        (39, 'FOREST_3D', 0, 'Huge monsters move slowly through the jungle like forest.'),
        (40, 'FOREST_3E', 0, 'You can barely see through the thickness of the trees.'),
        (41, 'FOREST_3F', 0, 'Animals come out from under rocks and deep root systems.'),
        (42, 'FOREST_3G', 0, 'You find skeletons from past travellers as you pass a large tree.'),
        (43, 'FOREST_3H', 0, 'A huge, ancient mammoth towers before you.'),
        (44, 'FOREST_3I', 0, 'The fire worms light up the otherwise dark and mysterious forest.'),
        (45, 'FOREST_3J', 0, 'All hope seems lost.'),
        (46, 'FOREST_3K', 0, 'Sand raptors thrive in the underground mazes and only come up to eat.'),
        (47, 'FOREST_3L', 0, 'You start to feel a chill in the air, something draws nearer.'),
        (48, 'FOREST_3M', 0, 'The dactyls dominate the crowns of the trees, looking down on any preys they find.'),
        (49, 'FOREST_3N', 0, 'Eyes light up in the darkness as you wanter on.'),
        (50, 'FOREST_3O', 0, 'The sun has set and you cannot turn back now.'),
        (51, 'FOREST_3P', 0, 'You enter a huge frosty cave.'),
        (52, 'FOREST_3Q', 0, 'A variety of monsters have taken shelter in the cave.'),
        (53, 'FOREST_3R', 0, 'Entering a room filled with ice yet lit up from blue fire, you have awakened the great Ice Dragon from its deep slumbers!'),
        (54, 'MUSHTRAIL_A', 0, 'Fire shrooms have a short temper but are however not very clever.'),
        (55, 'MUSHTRAIL_B', 0, 'Water shrooms are very chill, putting out your fire they will.'),
        (56, 'MUSHTRAIL_C', 0, 'Ground shrooms are down to earth, making sure new shrooms give birth.'),
        (57, 'MUSHTRAIL_D', 0, 'Wind shrooms are carefree and pure, however kind of immature.'),
        (58, 'MUSHTRAIL_E', 0, 'Mental shrooms are not very sane, if you want to live get out their lane.'),
        (59, 'MUSHTRAIL_F', 0, 'Now you\'ve made Shroom mom very angered after all her children you\'ve battered!'),
        (77, 'FIELD_A', 0, 'You come out on a large field.'),
        (78, 'FIELD_B', 0, 'A long road filled with travellers stretches far into the distance.'),
        (79, 'FIELD_C', 0, 'The sun is rising over the plains.'),
        (80, 'FIELD_D', 0, 'You see a large farming field stretch into the distance on your left hand side.'),
        (81, 'FIELD_E', 0, 'Patches of forest are on your right hand side containing various critters.'),
        (82, 'FIELD_F', 0, 'The heat starts to take its toll on travellers.'),
        (83, 'FIELD_G', 0, 'You pass a train track. Where does it lead?'),
        (84, 'FIELD_H', 0, 'Farmers are working on the fields, some use horses.'),
        (85, 'FIELD_I', 0, 'Large mountains are visible in the distance.'),
        (86, 'FIELD_J', 0, 'Minerals and ores are often gathered in the caves of the mountains and sold to other regions.'),
        (87, 'FIELD_K', 0, 'Rumors say dragons and trolls protect the riches of the mountains.'),
        (88, 'FIELD_L', 0, 'Small red houses with white corners are located throughout the fields.'),
        (89, 'FIELD_M', 0, 'Rumors of a nearby ranch are passed between travellers.'),
        (90, 'FIELD_N', 0, 'The forest patches grow thicker around you.'),
        (91, 'FIELD_O', 0, 'The mountains draw nearer. '),
        (92, 'FIELD_P', 0, 'You pass a small bridge over a small river. '),
        (93, 'FIELD_Q', 0, 'Did you just hear a giggle from underneath the bridge? Is it trolls or are you just tired?'),
        (94, 'FIELD_R', 0, 'You turn around for a moment and take a glance over the large fields you have covered.'),
        (95, 'FIELD_S', 0, 'The sun is setting over the plains.'),
        (96, 'FIELD_T', 0, 'There are fences around the road leading to a large entrance into the mountains. '),
        (97, 'FIELD_U', 0, 'You see people herding sheep on the sides. '),
        (98, 'FIELD_V', 0, '..and are there camels too?'),
        (99, 'FIELD_X', 0, 'Statues of famous mountain characterw are located in front of the entrance.'),
        (100, 'FIELD_Y', 0, 'You seem to remember reading about these characters growing up.'),
        (101, 'FIELD_Z', 0, 'You finally enter the entrance to the city built out of the mountain side.'),
        (102, 'Library_Forest', 1, 'Read about the forest dungeons here.'),
        (103, 'Library_F1', 1, 'Forest 1 is a small beginner friendly area. Head over there if you are new!'),
        (104, 'Library_F2', 1, 'Forest 2 is slightly larger dungeon than Forest 1 suitable around lvl 8.'),
        (105, 'Library_F3', 1, 'Forest 3 contains monsters with magical abilities so make sure you have resistances and have a level around 16 before entering.'),
        (106, 'Hub_Cave', 1, 'The hub of the cave city. '),
        (107, 'Portal_Cave', 1, 'The portal leads to different dungeons.'),
        (108, 'CAVE_1A', 0, 'A sign on the entrance says RobberÂ´s Den.'),
        (109, 'CAVE_1B', 0, 'Fire torches are lit throughout the cave.'),
        (110, 'CAVE_1C', 0, 'Monsters emerge from the dark.'),
        (111, 'CAVE_1D', 0, 'Boxes of dynamite is scattered throughout.'),
        (122, 'CAVE_2A', 0, 'Water is trickling down the cracks in the limestone.'),
        (123, 'CAVE_2B', 0, 'Stalagmites are formed from the ceiling. '),
        (124, 'CAVE_2C', 0, 'You pass an underwater passage.'),
        (125, 'CAVE_2D', 0, 'Ores and minerals are shimmering in the walls.'),
        (126, 'CAVE_2E', 0, 'You spot abandoned carts used for transporting valuables goods.'),
        (127, 'CAVE_2F', 0, 'Some of the minerals seem to be infused with magic.'),
        (128, 'CAVE_2G', 0, 'The temperature is lowering in the humid cave.'),
        (138, 'Market_Cave', 3, 'Buy and sell items in the marketplace.'),
        (139, 'Gotelands', 0, 'Sheepishly fun.'),
        (140, 'GH', 0, 'A nice garden with special brews.'),
        (141, 'Goteburg', 0, 'You start feeling the buzz.'),
        (142, 'Kalmari', 0, 'Pub crawls are among the best activities for pals.'),
        (143, 'Smalands', 0, 'Lost in the haze you start seeing stars everywhere.'),
        (144, 'Stocken', 0, 'Brats like to frat here. '),
        (145, 'Snerkan', 0, 'Some like to twerk at the snerk.'),
        (146, 'Uplands', 0, 'Seven beers in, most give up. But not you.'),
        (147, 'Varmland', 0, 'Always a good place for a super friday!'),
        (148, 'VG', 0, 'Cozy and small place.'),
        (149, 'VDala', 0, 'The sun sets as you arrive at the roof.'),
        (150, 'OEG', 0, 'Is there a better place to finish the pub crawl than OEG?'),
        (151, 'DomeChurch', 0, 'After 13 beers you arrive before the Dome Church. An immense power strikes you from above!'),
        (152, 'Switch_A1', 4, 'You are on switch A1, another player must stand on switch B1'),
        (153, 'Switch_B1', 4, 'You are on switch B1, another player must stand on switch A1'),
        (154, 'Switch_A2', 4, 'You are on switch A2, another player must stand on switch B2'),
        (155, 'Switch_B2', 4, 'You are on switch B2, another player must stand on switch A2'),
        (156, 'Switch_A', 4, 'You are on switch A, another player must stand on switch B'),
        (157, 'Switch_B', 4, 'You are on switch B, another player must stand on switch A'),
        (158, 'Cave_3A', 0, 'You enter a cave shaped as a fossil.'),
        (159, 'Cave_3B', 0, 'Horrible sounds echoes from within.'),
        (160, 'Cave_3C', 0, 'Some say this whole cave is formed from the fossil of an ancient creature. '),
        (182, 'Cave_3Z', 0, 'You enter a dark room when mysterious shapes appear in front of your eyes. The great Mind Flayer has entered your mind!'),
        (183, 'TaxiHub', 0, 'Welcome to the taxi hub! Fast travel to different locations from here.'),
        (184, 'Library_Cave', 0, 'You enter a cave shaped as a fossil.'),
        (185, 'Library_C1', 0, ''),
        (186, 'Library_C2', 0, ''),
        (187, 'Library_C3', 0, '')
        ON DUPLICATE KEY UPDATE id=VALUES(id),
        name=VALUES(name),
        type=VALUES(type),
        description=VALUES(description);");
	$ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

?>
