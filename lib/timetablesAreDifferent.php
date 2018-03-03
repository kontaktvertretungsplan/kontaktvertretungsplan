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

Stellt unterschiede zwischen zwei eingegebenen Stundenplänen fest

Functions:
timetablesAreDifferent($timetable1, $timetable2)

Example inputs:

$timetable1 = [
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

$timetable2 uses the same scheme like $timetable2

Output:
	true or false

*/

function timetablesAreDifferent($timetable1, $timetable2) {
	
	if(count($timetable1) != count($timetable2)) {
		return false;
	}
	else {
		foreach($timetable1 as $lesson => $classes) {
			if(count($timetable1[$lesson]) != count($timetable2[$lesson])) {
				return false;
			}
			else {
				foreach($classes as $class => $courses) {
					if(count($timetable1[$lesson][$class]) != count($timetable2[$lesson][$class])) {
						return false;
					}
					else {
						foreach($courses as $cours => $info) {
							if(count($timetable1[$lesson][$class][$cours]) != count($timetable2[$lesson][$class][$cours])) {
								return false;
							}
							else {
								foreach($info as $key => $value) {
									if($timetable2[$lesson][$class][$cours][$key] != $value) {
										return false;
									}
								}
							}
						}
					}
				}
			}
		}
	}
	
	
	
	return true;
}
?>