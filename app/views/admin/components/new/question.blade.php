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
?>

<div class="row">
	
		{{ Form::open(array('route' => array('question-new', $course->id, $chapter->id))) }}
		    <div class="col-md-4 col-sm-12">
			    <div class="form-group">
				    {{ Form::text('title', null, array('class' => 'form-control', 'placeholder'=>'Questionname')) }}
			    </div>
		    </div>

		    <div class="col-md-4 col-sm-12">
			    <div class="form-group">
				    {{ Form::text('granted_time', null, array('class' => 'form-control', 'placeholder'=>'Granted time')) }}
			    </div>
		    </div>

			<div class="col-md-4 col-sm-12">
				<div class="form-group">
					{{ Form::submit('Add', array('class' => 'btn color_hover btn-course color_hover-1')) }}
				</div>
			</div>
		{{ Form::close() }}
</div>