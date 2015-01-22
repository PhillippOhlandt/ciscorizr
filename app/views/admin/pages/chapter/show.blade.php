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
		<div class="col-md-12">
			{{ link_to_route('course', $course->title ,$course->id) }}
		</div>
	</div>

	<div class="row">
		<div class="col-md-12"><h2><span class="color color_font color_font-1">Chapter:</span> {{ $chapter->title }}</h2></div>
	</div>

	<div class="new-entry">
		<h4>Add new Question</h4>
		@include('admin.components.errormessages', ['errors' => $errors])
		@include('admin.components.new.question', ['course' => $course, 'chapter' => $chapter])
	</div>

	<div class="row">
		<div class="col-md-12"><h3>Questions:</h3></div>
	</div>


	<div class="questionlist content-table">
		@if(count($chapter->questions))
			<div class="row list-head color color_bg color-1">
				<div class="col-md-1 col-sm-12">
					<div>#</div>
				</div>
				<div class="col-md-8 col-sm-12">
					<div>Title</div>
				</div>
				<div class="col-md-1 col-sm-12">
					<div>Seconds</div>
				</div>
				<div class="col-md-2 col-sm-12">
					<div class="pull-right">
						Controls
					</div>
				</div>
			</div>
			@foreach($chapter->questions as $question)
			<div class="row list-entry color {{ $question->is_visible == 1 ? 'visible' : 'not-visible'  }}">
				<div class="col-md-1 col-sm-12">
					<div class="text-id">{{ $question->id }}</div>
				</div>
				<div class="col-md-8 col-sm-12">
					<div class="text-title">{{ link_to_route('question', $question->title ,[$course->id, $chapter->id, $question->id]) }}</div>
				</div>
				<div class="col-md-1 col-sm-12">
					<div class="text-seconds">{{ $question->granted_time }}</div>			
				</div>
				<div class="col-md-2 col-sm-12">
					<div class="pull-right">
						{{ link_to_route('question-delete', 'Delete' ,[$course->id, $chapter->id, $question->id]) }} |
						{{ link_to_route('question-edit', 'Edit' ,[$course->id, $chapter->id, $question->id]) }}
					</div>
				</div>
			</div>
			@endforeach
		@else
			<div class="row">
			<div class="col-md-12 no-content">You have no questions, shame on you!</div>
		</div>
		@endif
	</div>
@stop