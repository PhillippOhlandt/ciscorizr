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

<div id="loginform">
	@include('admin.components.errormessages', ['errors' => $errors])
{{ Form::open(array('url' => '/admin/login')) }}
    
    <div class="form-group">
	    {{ Form::label('username', 'Username') }}
	    {{ Form::text('username', null, array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
	    {{ Form::label('password', 'Password') }}
	    {{ Form::password('password', array('class' => 'form-control')) }}
    </div>

    <div class="row">

	    <div class="col-md-6 col-sm-6 col-xs-6">
	    	<div class="form-group">
	    		<div class="checkbox">
	    			<label>
		    			{{ Form::checkbox('remember', 'remember') }} Remember
		    		</label>
		    	</div>
	    	</div>
	    </div>

	    <div class="col-md-6 col-sm-6 col-xs-6">
	    	<div class="form-group">
		    	{{ Form::submit('Login', array('class' => 'btn color_hover btn-course color_hover-1 pull-right')) }}
	    	</div>
	    </div>

    </div>
    

{{ Form::close() }}

</div>