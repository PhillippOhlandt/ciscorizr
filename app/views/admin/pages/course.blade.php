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

@extends('admin.layout')

@section('rightToLogo')
	@include('admin.components.adminarea')
@stop

@section('content')
	@include('admin.components.navigation')
	
	<div class="row">
		<div class="col-md-12">{{ $course->title }}</div>
	</div>
	<div class="row">
		<div class="col-md-12">Chapters:</div>
	</div>
	<div class="chapter">
		@if(count($course->chapters))
			<div class="row list-head color color_font">
				<div class="col-md-1 col-sm-12">
					#
				</div>
				<div class="col-md-7 col-sm-12">
					Title
				</div>
				<div class="col-md-1 col-sm-12">
					Questions
				</div>
				<div class="col-md-3 col-sm-12">
					<div class="pull-right">
						Controls
					</div>
				</div>
			</div>
			@foreach($course->chapters as $chapter)
			<div class="row color color_font {{ $course->is_visible == 1 ? 'bla' : 'not-visible'  }}">
				<div class="col-md-1 col-sm-12">
					{{ $chapter->id }}
				</div>
				<div class="col-md-4 col-sm-12">
					{{ $chapter->title }}
				</div>
				<div class="col-md-4 col-sm-12">
					{{ count($chapter->questions) }}
					
				</div>
				<div class="col-md-3 col-sm-12">
					<div class="pull-right">
						Controls
					</div>
				</div>
			</div>
			@endforeach
		@else
			<div class="row">
			<div class="col-md-12 no-content">You have no courses, shame on you!</div>
			<a href="" class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3 btn color color_hover color_hover-1">Create first Chapter</a>
		</div>
		@endif
	</div>
@stop