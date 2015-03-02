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

class CourseController extends BaseController {

	public function show(Course $course){
		return View::make('admin.pages.courses.show', ['course' => $course]);
	}

	public function postNew(){
		$errors = [];

		$credentials = Input::only('title');

        $rules = array(
            'title' => 'required|unique:courses,title'
        );

        $messages = array(
		     'title.required' => 'Y U NO type course name!!! '. CatStatus::get('NOT_FOUND'),
		     'title.unique' => $credentials['title'] . ' is already taken!'
		 );

        $validator = Validator::make($credentials, $rules, $messages); 

        if ($validator->fails()) { 
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $course = new Course();
        $course->title = Input::get('title');
        $course->is_visible = 0;
        $course->save();

        return Redirect::back();
	}

	public function delete(Course $course){
		return View::make('admin.pages.courses.delete', ['course' => $course]);
	}

	public function destroy(Course $course){
		$errors = [];

		$can_delete = Input::has('can_delete');

		if(!$can_delete){
			$errors[] = 'Check checkbox to delete it';
			return Redirect::back()->withInput()->with(['errors' => $errors]);
		}

		/*sqlite supports no cascade delete,
		 *so we have to delete the item and all child items manually
		 * */
		for($i = 0; $i < count($course->chapters); $i++){
			$chapter = $course->chapters[$i];
			for($j = 0; $j < count($chapter->questions); $j++){
				$question = $chapter->questions[$j];
				for($k = 0; $k < count($question->answers); $k++){
					$answer = $question->answers[$k];
					$answer->delete();
				}
				$question->delete();
			}
			$chapter->delete();
		}
		$course->delete();

		return Redirect::route('courses-path');
	}

	public function edit(Course $course){
		$can_make_visible = 0;

		foreach($course->chapters as $chapter){
			if($chapter->is_visible == 1){
				$can_make_visible = 1;
			}
		}

		return View::make('admin.pages.courses.edit', ['course' => $course, 'can_make_visible' => $can_make_visible]);
	}

	public function update(Course $course){
		$errors = [];

		$credentials = Input::only('title', 'is_visible');

        $rules = array(
            'title' => 'required|unique:courses,title'.$course->id
        );

        $messages = array(
		     'title.required' => 'Y U NO type course name!!! '. CatStatus::get('NOT_FOUND'),
		     'title.unique' => $credentials['title'] . ' is already taken!'
		 );

        $validator = Validator::make($credentials, $rules, $messages); 

        if ($validator->fails()) { 
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $course->title = Input::get('title');
        $course->is_visible = Input::has('is_visible');
        $course->save();

        return Redirect::route('course', $course->id);
	}


}