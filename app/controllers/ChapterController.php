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

class ChapterController extends BaseController {

	public function show(Course $course, Chapter $chapter){
		return View::make('admin.pages.chapter.show', ['course' => $course, 'chapter' => $chapter]);
		echo "<pre>";
		print_r($course);
		print_r($chapter);
	}

	public function postNew(Course $course){
		$errors = [];

		$credentials = Input::only('title');

        $rules = array(
            'title' => 'required'
        );

        $messages = array(
		     'title.required' => 'Y U NO type chapter name!!! '.$this->catstatus->get('NOT_FOUND')
		 );

        $validator = Validator::make($credentials, $rules, $messages); 

        if ($validator->fails()) { 
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $chapter = new Chapter();
        $chapter->title = Input::get('title');
        $chapter->is_visible = 0;
        $chapter->course_id = $course->id;
        $chapter->save();

        return Redirect::back();
	}


	public function delete(Course $course, Chapter $chapter){
		return View::make('admin.pages.chapter.delete', ['course' => $course, 'chapter' => $chapter]);
	}

	public function destroy(Course $course, Chapter $chapter){
		$errors = [];

		$can_delete = Input::has('can_delete');

		if(!$can_delete){
			$errors[] = 'Check checkbox to delete it';
			return Redirect::back()->withInput()->with(['errors' => $errors]);
		}

		/*sqlite supports no cascade delete,
		 *so we have to delete the item and all child items manually
		 * */
		for($j = 0; $j < count($chapter->questions); $j++){
			$question = $chapter->questions[$j];
			for($k = 0; $k < count($question->answers); $k++){
				$answer = $question->answers[$k];
				$answer->delete();
			}
			$question->delete();
		}
		$chapter->delete();
		

		return Redirect::route('course', $course->id);
	}

	public function edit(Course $course, Chapter $chapter){
		$can_make_visible = 0;

		$visible_questions = 0;
		foreach($chapter->questions as $question){
			if($question->is_visible == 1){
				$visible_questions++;
			}
		}
		if($visible_questions >= 10){
			$can_make_visible = 1;
		}

		return View::make('admin.pages.chapter.edit', ['course' => $course, 'chapter' => $chapter, 'can_make_visible' => $can_make_visible]);
	}

	public function update(Course $course, Chapter $chapter){
		$errors = [];

		$credentials = Input::only('title', 'is_visible');

        $rules = array(
            'title' => 'required|unique:courses,title'.$chapter->id
        );

        $messages = array(
		     'title.required' => 'Y U NO type chapter name!!! '.$this->catstatus->get('NOT_FOUND'),
		     'title.unique' => $credentials['title'] . ' is already taken!'
		 );

        $validator = Validator::make($credentials, $rules, $messages); 

        if ($validator->fails()) { 
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $chapter->title = Input::get('title');
        $chapter->is_visible = Input::has('is_visible');
        $chapter->save();

        return Redirect::route('chapter', [$course->id, $chapter->id]);
	}


}