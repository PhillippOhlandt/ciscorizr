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

class AuthController extends BaseController {

	public function getLogin(){
		return View::make('admin.pages.login');
	}

	public function postLogin(){
		$errors = [];

		$credentials = Input::only('username', 'password');

        $rules = array(
            'username' => 'required',
            'password' => 'required'
        );

        $validator = Validator::make($credentials, $rules); 

        if ($validator->fails()) { 
            return Redirect::back()->withInput()->withErrors($validator);
        }

	    $remember = Input::has('remember');
	    if(Auth::attempt($credentials, $remember)){
	        return Redirect::intended('/admin');
	    }
	    $errors[] = 'Wrong username or password';
	    return Redirect::back()->withInput()->with(['errors' => $errors]);
		
	}

	public function getLogout(){
		Auth::logout();
		return Redirect::back();
	}

}