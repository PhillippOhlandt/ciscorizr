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

<div class="courselist content-table">
	@if(count($courses))
	<div class="row list-head color color_bg color-1">
			<div class="col-md-1 col-sm-12">
				<div>#</div>
			</div>
			<div class="col-md-7 col-sm-12">
				<div>Title</div>
			</div>
			<div class="col-md-1 col-sm-12">
				<div>Chapters</div>
			</div>
			<div class="col-md-1 col-sm-12">
				<div>Questions</div>
			</div>
			<div class="col-md-2 col-sm-12">
				<div class="pull-right">
					Controls
				</div>
			</div>
	</div>
		@foreach($courses as $course)
		<div class="row list-entry color {{ $course->is_visible == 1 ? 'visible' : 'not-visible'  }}">
			<div class="col-md-1 col-sm-12">
				<div class="text-id">{{ $course->id }}</div>
			</div>
			<div class="col-md-7 col-sm-12">
				<div class="text-title">{{ link_to_route('course', $course->title ,$course->id) }}</div>
			</div>
			<div class="col-md-1 col-sm-12">
				<div class="text-chapters">{{ count($course->chapters) }}</div>			
			</div>
			<div class="col-md-1 col-sm-12">
				<?php $questionscount = 0; ?>
				@foreach($course->chapters as $chapter)
					<?php $questionscount += count($chapter->questions); ?>
				@endforeach
				<div class="text-questions">{{ $questionscount }}</div>
			</div>
			<div class="col-md-2 col-sm-12">
				<div class="pull-right">
					{{ link_to_route('course-delete', 'Delete' ,$course->id) }} | 
					{{ link_to_route('course-edit', 'Edit' ,$course->id) }}
				</div>
			</div>
		</div>
		@endforeach
	@else
		<div class="row">
			<div class="col-md-12 no-content">You have no courses, shame on you!</div>
		</div>
	@endif
</div>