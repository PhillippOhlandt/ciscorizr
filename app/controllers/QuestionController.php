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

class QuestionController extends BaseController {

	public function show(Course $course, Chapter $chapter, Question $question){
		return View::make('admin.pages.question.show', ['course' => $course, 'chapter' => $chapter, 'question' => $question]);
		echo "<pre>";
		print_r($question->answers);
		//print_r($course);
		//print_r($chapter);
	}

	public function postNew(Course $course, Chapter $chapter){
		$errors = [];

		$credentials = Input::only('title', 'granted_time');

        $rules = array(
            'title' => 'required',
            'granted_time' => 'required|numeric'
        );

        $messages = array(
		     'title.required' => 'Y U NO type question name!!! '.$this->catstatus->get('NOT_FOUND'),
		     'granted_time.required' => 'Y U NO type granted time?!',
		     'granted_time.numeric' => 'Y U NO type seconds in the field for SECONDS!!! '.$this->catstatus->get('NOT_FOUND')
		 );

        $validator = Validator::make($credentials, $rules, $messages); 

        if ($validator->fails()) { 
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $question = new Question();
        $question->title = Input::get('title');
        $question->granted_time = Input::get('granted_time');
        $question->is_visible = 0;
        $question->chapter_id = $chapter->id;
        $question->save();

        return Redirect::back();
	}

	public function delete(Course $course, Chapter $chapter, Question $question){
		return View::make('admin.pages.question.delete', ['course' => $course, 'chapter' => $chapter, 'question' => $question]);
	}

	public function destroy(Course $course, Chapter $chapter, Question $question){
		$errors = [];

		$can_delete = Input::has('can_delete');

		if(!$can_delete){
			$errors[] = 'Check checkbox to delete it';
			return Redirect::back()->withInput()->with(['errors' => $errors]);
		}

		/*sqlite supports no cascade delete,
		 *so we have to delete the item and all child items manually
		 * */
		for($k = 0; $k < count($question->answers); $k++){
			$answer = $question->answers[$k];
			$answer->delete();
		}
		$question->delete();

		

		return Redirect::route('chapter', [$course->id, $chapter->id]);
	}

	public function edit(Course $course, Chapter $chapter, Question $question){
		$can_make_visible = 0;

		if(count($question->answers) == 4){
			$can_make_visible = 1;
		}

		return View::make('admin.pages.question.edit', ['course' => $course, 'chapter' => $chapter, 'question' => $question, 'can_make_visible' => $can_make_visible]);
	}

	public function update(Course $course, Chapter $chapter, Question $question){
		$errors = [];

		$credentials = Input::only('title', 'granted_time','is_visible');

        $rules = array(
            'title' => 'required',
            'granted_time' => 'required|numeric'
        );

        $messages = array(
		     'title.required' => 'Y U NO type question name!!! '.$this->catstatus->get('NOT_FOUND'),
		     'granted_time.required' => 'Y U NO type granted time?!',
		     'granted_time.numeric' => 'Y U NO type seconds in the field for SECONDS!!! '.$this->catstatus->get('NOT_FOUND')
		 );

        $validator = Validator::make($credentials, $rules, $messages); 

        if ($validator->fails()) { 
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $question->title = Input::get('title');
        $question->granted_time = Input::get('granted_time');
        $question->is_visible = Input::has('is_visible');
        $question->save();

        return Redirect::route('question', [$course->id, $chapter->id, $question->id]);
	}


}