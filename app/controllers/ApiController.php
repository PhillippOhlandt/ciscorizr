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

class ApiController extends BaseController {

	public function getChaptersFromCourse(Course $course){
		$chapters = $course->chapters()->where('is_visible', '=', 1)->get(['id', 'title']);

		$data = array(
			"type" => "chapters",
			"count" => count($chapters),
			"cat" => $this->catstatus->get("SUCCESS"),
			"parent" => array(
						"type" => "course",
						"id" => $course->id,
						"title" => $course->title
						),
			"data" => $chapters

			);
		return $data;
	}


	public function getQuestionsFromChapter(Chapter $chapter){
		$questions = $chapter->questions()->where('is_visible', '=', 1)->with(array('answers' => function($query)
			{
			    $query->addSelect(['id', 'title', 'is_correct', 'question_id']);
			}))->get(['id', 'title', 'granted_time']);

		$getCount = 10;

		if(count($questions) < $getCount){
			$getCount = count($questions);
		}

		$questions = $questions->random($getCount);

		//fixing index issue
		$indexedQuestions = [];
		foreach($questions as $question){
			$indexedQuestions[] = $question;
		}
		$questions = $indexedQuestions;

		/*start randomizing the questions and answers*/
		$questions = $this->shuffle_assoc($questions);

		foreach($questions as $question){
			$tmp = [];
			foreach($question['answers'] as $answer){
				$tmp[] = $answer;
			}
			unset($question['answers']);
			$question['answers'] = $this->shuffle_assoc($tmp);
		}
		/*stop randomizing the questions and answers*/

		$data = array(
			"type" => "questions",
			"count" => count($questions),
			"cat" => $this->catstatus->get("SUCCESS"),
			"parent" => array(
						"type" => "chapter",
						"id" => $chapter->id,
						"title" => $chapter->title
						),
			"data" => $questions

			);
		return $data;
	}

	public function getRankForPlayer(){
		
		$playerhash = Input::get('hash');

		if(!$playerhash){
			return '';
		}

		$player = Player::where('hash', '=', $playerhash)->with('chapter')->first();

		if(!$player){
			return Redirect::route('home');
		}

		$betterAsPercent = round($this->betterAsPercent($player->id, $player->chapter_id));

		$data = array('hash' => $playerhash,
					'betterAsPercent' => $betterAsPercent,
					"cat" => $this->catstatus->get("SUCCESS")
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
	
	public function shuffle_assoc($array){
	   $keys = array_keys($array);
	   shuffle($keys);
	   $data = [];
	   foreach($keys as $key){
	   		$data[] = $array[$key];
	   }
	   return $data;
	}

}