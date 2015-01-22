<?php

/*
Copyright 2015 Phillipp Ohlandt

This file is part of Ciscorizr.

Ciscorizr is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Ciscorizr is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Ciscorizr.  If not, see <http://www.gnu.org/licenses/>.

Diese Datei ist Teil von Ciscorizr.

Ciscorizr ist Freie Software: Sie können es unter den Bedingungen
der GNU General Public License, wie von der Free Software Foundation,
Version 3 der Lizenz oder (nach Ihrer Wahl) jeder späteren
veröffentlichten Version, weiterverbreiten und/oder modifizieren.

Ciscorizr wird in der Hoffnung, dass es nützlich sein wird, aber
OHNE JEDE GEWÄHRLEISTUNG, bereitgestellt; sogar ohne die implizite
Gewährleistung der MARKTFÄHIGKEIT oder EIGNUNG FÜR EINEN BESTIMMTEN ZWECK.
Siehe die GNU General Public License für weitere Details.

Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*/

class PlayerController extends BaseController {

	public function show($playerhash){

		$player = Player::where('hash', '=', $playerhash)->with('chapter.course')->first();

		if(!$player){
			return Redirect::route('home');
		}

		$timeLeftFormatted = $this->toMMSS($player->seconds_left);

		return View::make('site.pages.player', ['player' => $player,
												'questions' => json_decode($player->questions),
												'timeLeftFormatted' => $timeLeftFormatted]);
	}


	public function store(){
		$input = Input::all();

		if(!$input){
			return;
		}

		$secondsLeft = $input['secondsLeft'];
		$answeredQuestions = $input['answeredQuestions'];
		$chapterID = $input['chapterID'];
		$questions = $input['playerQuestions'];
		$hash = str_random(10);

		$player = new Player();
		$player->hash = $hash;
		$player->seconds_left = $secondsLeft;
		$player->answered_questions = $answeredQuestions;
		$player->questions = json_encode($questions);
		$player->chapter_id = $chapterID;
		$player->save();

		$data = array(
			'status' => 'success',
			'hash' => $hash,
			'betterAsPercent' => round($this->betterAsPercent($player->id, $chapterID)),
			'cat' => $this->catstatus->get("SUCCESS")
			);

		return $data;
	}

	public function betterAsPercent($playerId, $chapterId){
		$players = Player::where('chapter_id', '=', $chapterId)->orderBy('answered_questions', 'ASC')
						    ->orderBy('seconds_left', 'ASC')
						    ->lists('id');
						    //->get(['id', 'answered_questions', 'seconds_left']);

		$playerPosition = 0;
		for($i = 0; $i < count($players); $i++){
			if($players[$i] == $playerId){
				$playerPosition = $i + 1;
			}
		}
		$rank = (($playerPosition - 1) / count($players)) * 100;
		return $rank;
	}


	public function toMMSS($seconds) {
	    $sec_num = $seconds; 
	    $hours   = floor($sec_num / 3600);
	    $minutes = floor(($sec_num - ($hours * 3600)) / 60);
	    $seconds = $sec_num - ($hours * 3600) - ($minutes * 60);

	    if ($hours   < 10) {$hours   = "0".$hours;}
	    if ($minutes < 10) {$minutes = "0".$minutes;}
	    if ($seconds < 10) {$seconds = "0".$seconds;}
	    $time = $minutes.':'.$seconds;
	    return $time;
	}
	

}