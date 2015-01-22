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

<div class="row headline gameFinished">
	<div class="resultText col-md-6 col-sm-6 col-xs-12">
		You have answered #ANSWERED_QUESTIONS# of 10 questions
	</div>
	<div class="col-xs-12 visible-xs"><div class="divider"></div></div>
	<div class="scoreText col-md-6 col-sm-6 col-xs-12">
		You are better than #BETTERASPERCENT#% of the ones who played this chapter
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12 newGame">
		<a class="btn color_hover color_hover-1" href="{{ url('/') }}"><span>New Game</span></a>
		<a class="btn color_hover color_hover-1" href="{{ url('/') }}/#HASH#"><span>Your Playersite</span></a>
	</div>
</div>