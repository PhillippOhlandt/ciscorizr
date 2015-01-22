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

@extends('site.layout')

@section('rightToLogo')

@stop

@section('content')



<div class="content">

	<div class="row">
		<div class="col-md-12 headline">Player {{ $player->id }}</div>
	</div>

	<div class="row playerPage">
		<div class="configurationText col-md-6 col-sm-6 col-xs-12">
			<h2 class="color_font color_font-1">Configuration</h2>
			<ul>
				<li><span>Course:</span> {{ $player->chapter->course->title }}</li>
				<li><span>Chapter:</span> {{ $player->chapter->title }}</li>
				<li><span>Answered questions:</span> {{ $player->answered_questions }}</li>
				<li><span>Time left:</span> {{ $timeLeftFormatted }} min</li>
			</ul>
		</div>
		<div class="col-xs-12 visible-xs"><div class="divider"></div></div>

		<div class="scoreText col-md-6 col-sm-6 col-xs-12">
			<h2 class="color_font color_font-1">Score</h2>
			<div>Player <span class="color_font color_font-1">{{ $player->id }}</span> was better than <span class="color_font color_font-1 betterAsPercent">[loading...]</span> of the ones who played this chapter</div>
		</div>
	</div>

	<div class="row playerQuestions">
			<div class="col-xs-12"><div class="divider"></div></div>

			<div class="questions col-md-12 col-sm-12 col-xs-12">
				<h2 class="color_font color_font-1">Questions</h2>

				@foreach($questions as $question)
				<div class="row playerQuestion {{ $question->answered == 'true' ? 'color color_font color_font-1' : 'bla'  }}">
					<div class="col-md-11 col-sm-11 col-xs-11">
						{{ $question->title }}
					</div>
					<div class="col-md-1 col-sm-1 col-xs-1">
						@if($question->answered == 'true')
							<span class="glyphicon glyphicon-ok pull-right" aria-hidden="true"></span>
						@else
							<span class="glyphicon glyphicon-remove pull-right" aria-hidden="true"></span>
						@endif
					</div>
					<div class="col-xs-12"><div class="divider"></div></div>
				</div>
				@endforeach
			</div>
	</div>
</div>

<script type="text/javascript">
	
$(function(){
	$.ajax({
		context: this,
		url: '/api/player/rank',
		type: 'POST',
		data: {'hash':'{{ $player->hash }}'},
		beforeSend: function(request) {
	        return request.setRequestHeader('X-CSRF-Token', csrf);
	    }
	})
	.done(function(response) {
		console.log("success");
		$('.betterAsPercent').html(response.betterAsPercent+'%');
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
});

</script>


@stop
