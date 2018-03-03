<?php
/*
*==============================================================*
* |\      /| | |     /---- |    | | |\   | /----\ |---- |      *
* | \    / | | |     |     |    | | | \  | |      |     |      *
* |  \  /  | | |     |     |----| | |  \ | \----\ |---- |      *
* |   \/   | | |     |     |    | | |   \|      | |     |      *
* |        | | |---- \---- |    | | |    | \----/ |---- |----- *
*==============================================================*
*        Written by Clemens Riese (c)miclhinsel.de 2018        *
*==============================================================*

Kontakt:Vertretungsplan Telegram Bot

Gibt den Personalisierten Stundenplan wieder

Funktionen:
getPersonalTimetable($timetable, $search, $show_unlisted = true)

Beispiel inputs:

$timetable = [
	1 => [
		'18/1' => [
			'if1' => [
				'lesson' => 'Informatik',
				'teacher' => 'Möller',
				'room' => '205',
				'changed' => false,
				'note' => ''
			],
			'if2' => [
				'lesson' => 'Informatik',
				'teacher' => 'Möller',
				'room' => '205',
				'changed' => false,
				'note' => ''
			],
		],
	],
	2 => [
		'18/1' => [
			'if1' => [
				'lesson' => 'Informatik',
				'teacher' => 'Möller',
				'room' => '205',
				'changed' => false,
				'note' => ''
			],
			'if2' => [
				'lesson' => 'Informatik',
				'teacher' => 'Möller',
				'room' => '205',
				'changed' => false,
				'note' => ''
			],
		],
	],
	3 => [
		'18/1' => [
			'EnE' => [
				'lesson' => 'Englisch',
				'teacher' => 'Möller',
				'room' => '205',
				'changed' => true,
				'note' => 'Statt bi1'
			],
		],
	],
];

$search = [
	'18/1' => [
		'if1' => 'yes', // select
		'if2' => 'no', // deselect
	],
];

Output uses same scheme like $timetable input, but
 - without the deselected courses - by default [It is not necessary to know all available course names]
 - only the selected courses - if you set $show_unlisted = false

*/

function getPersonalTimetable($timetable, $search, $show_unlisted = true) {
	$out = [];
	foreach($timetable as $lesson => $classes) {
		foreach($search as $class => $coursees) {
			if(!empty($classes[$class])) {
				foreach($classes[$class] as $course => $info) {
					if(!empty($coursees[$course])) {
						if($coursees[$course] == 'yes') {
							$out[$lesson][$class][$course] = $info;
						}
					}
					else {
						if($show_unlisted) {
							$out[$lesson][$class][$course] = $info;
						}
					}
				}
			}
		}
	}
	
	return $out;
}
?>