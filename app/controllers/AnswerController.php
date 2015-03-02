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

class AnswerController extends BaseController {

	public function postNew(Course $course, Chapter $chapter, Question $question){
		$errors = [];

		$credentials = Input::only('title', 'is_correct');

        $rules = array(
            'title' => 'required'
        );

        $messages = array(
		     'title.required' => 'Y U NO type answer name!!! '. CatStatus::get('NOT_FOUND'),
		 );

        $validator = Validator::make($credentials, $rules, $messages); 

        if ($validator->fails()) { 
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $answer = new Answer();
        $answer->title = Input::get('title');
        $answer->is_correct = Input::has('is_correct');
        $answer->question_id = $question->id;
        $answer->save();

        return Redirect::back();
	}

	public function edit(Course $course, Chapter $chapter, Question $question, Answer $answer){

		return View::make('admin.pages.answer.edit', ['course' => $course, 'chapter' => $chapter, 'question' => $question, 'answer' => $answer]);
	}

	public function update(Course $course, Chapter $chapter, Question $question, Answer $answer){
		$errors = [];

		$credentials = Input::only('title','is_correct');

        $rules = array(
            'title' => 'required'
        );

        $messages = array(
		     'title.required' => 'Y U NO type answer name!!! '. CatStatus::get('NOT_FOUND')
		 );

        $validator = Validator::make($credentials, $rules, $messages); 

        if ($validator->fails()) { 
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $answer->title = Input::get('title');
        $answer->is_correct = Input::has('is_correct');
        $answer->save();

        return Redirect::route('question', [$course->id, $chapter->id, $question->id]);
	}



}