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

var spinnerOpts = {
  lines: 15, // The number of lines to draw
  length: 0, // The length of each line
  width: 10, // The line thickness
  radius: 24, // The radius of the inner circle
  corners: 1, // Corner roundness (0..1)
  rotate: 0, // The rotation offset
  direction: 1, // 1: clockwise, -1: counterclockwise
  color: '#000', // #rgb or #rrggbb or array of colors
  speed: 1, // Rounds per second
  trail: 30, // Afterglow percentage
  shadow: false, // Whether to render a shadow
  hwaccel: false, // Whether to use hardware acceleration
  className: 'spinner', // The CSS class to assign to the spinner
  zIndex: 2e9, // The z-index (defaults to 2000000000)
  top: '50%', // Top position relative to parent
  left: '50%' // Left position relative to parent
};

$(function(){

	var spinnerTarget = document.getElementById('spinner');
	var spinner = new Spinner(spinnerOpts);
	var gameFinishedHandler = new GameFinishedHandler();
	var isLoadingChapters = false;
	var isLoadingQuestions = false;
	var content = $('.content');
	var courseID;
    var chapterID;
	var chapters;
	var questions;
	var ciscorizr;


	/*ClickListener for course select buttons*/
	$(document).on("click", ".select-buttons .btn-course", function(event){
	    if(!isLoadingChapters){
			isLoadingChapters = true;
			courseID = $(this).attr('data-id');
			loadChapters(courseID);
		}
	});


	/*ClickListener for chapter select buttons*/
	$(document).on("click", ".select-buttons .btn-chapter", function(event){
	    if(!isLoadingQuestions){
			isLoadingQuestions = true;
			chapterID = $(this).attr('data-id');
			loadQuestions(chapterID);
		}
	});

	/*ClickListener for answer buttons*/
	$(document).on("click", ".select-buttons .btn-answer", function(event){
	    ciscorizr.clickAnswer($(this).attr('data-id'));
	});


	function loadChapters(cId){
		spinner.spin(spinnerTarget);
		$.ajax({
			url: '/api/course/'+ cId + '/chapters',
			type: 'GET',
			dataType: 'json'
		})
		.done(function(response) {
			console.log("success");
			chapters = response.data;
			showChapters(chapters);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
			isLoadingChapters = false;
			spinner.stop();
		});
		
	}

	function loadQuestions(chId){
		spinner.spin(spinnerTarget);
		$.ajax({
			url: '/api/chapter/'+ chId + '/questions',
			type: 'GET',
			dataType: 'json'
		})
		.done(function(response) {
			console.log("success");
			questions = response.data;
			showQuestions();
			initCiscorizr();
			ciscorizr.start();
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
			isLoadingQuestions = false;
			spinner.stop();
		});
		
	}

	function showChapters(chapters){
		var markup = $('#layouts #chapterscreen').html();
		var item = '<div class="col-md-4 col-sm-6 col-xs-12"><div class="btn color_hover btn-chapter color_hover-1" data-id="#ID#">#TITLE#</div></div>';
		var itemsString = "";
		chapters.forEach(function(entry) {
			itemString = item.replace('#ID#', entry.id);
			itemString = itemString.replace('#TITLE#', entry.title);
			itemsString += itemString;
		});
		markup = markup.replace('#ENTRIES#', itemsString);
		content.addClass('animated fadeOutLeft');
		setTimeout(function(){
			content.html(markup);
			content.removeClass('fadeOutLeft').addClass('fadeInRight');
		}, 500)
		//content.html(markup);
		//alert(markup);
	}

	function showQuestions(){
		var markup = $('#layouts #questionandanswers').html();
		content.html(markup);
	}


	function initCiscorizr(){
		gameFinishedHandler.gameData['courseID'] = courseID;
		gameFinishedHandler.gameData['chapterID'] = chapterID;
		gameFinishedHandler.spinner = spinner;
		gameFinishedHandler.spinnerTarget = spinnerTarget;
		gameFinishedHandler.content = content;
		gameFinishedHandler.gameFinishedHTML = $('#layouts #gamefinished').html();
		gameFinishedHandler.colorswitcher = cs;

		ciscorizr = new Ciscorizr();
		ciscorizr.questions = questions;
		ciscorizr.countdown = $('.countdown');
		ciscorizr.seconds = 60;
		ciscorizr.content = content;
		ciscorizr.questionParent = $('.question div');
		ciscorizr.answerParent = $('.answers div');
		ciscorizr.answerMarkup = '<div class="col-md-6 col-sm-6 col-xs-12"><div class="btn color_hover btn-answer color_hover-1" data-id="#ID#">#TITLE#</div></div>';
		ciscorizr.gameFinishedHandler = gameFinishedHandler;
		ciscorizr.colorswitcher = cs;
		ciscorizr.init();
	}


	function GameFinishedHandler(){
		this.gameData = {};
		this.spinner;
		this.spinnerTarget;
		this.content;
		this.gameFinishedHTML;
		this.colorswitcher;

		this.handle = function(data){
			$.extend(this.gameData, data);
			
			this.content.html("");
			this.spinner.spin(this.spinnerTarget);
			

			$.ajax({
				context: this,
				url: '/api/player/new',
				type: 'POST',
				data: this.gameData,
				beforeSend: function(request) {
			        return request.setRequestHeader('X-CSRF-Token', csrf);
			    }
			})
			.done(function(response) {
				console.log("success");
				if(response.status == 'success'){
					this.showGameFinished(response);
				}
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
				spinner.stop();
			});
			
		}

		this.showGameFinished = function(response){
			var markup = this.gameFinishedHTML.replace('#ANSWERED_QUESTIONS#', this.gameData['answeredQuestions']).replace('#BETTERASPERCENT#', response.betterAsPercent).replace('#HASH#', response.hash);
			content.html(markup);
			this.colorswitcher.nextColor();
		}
	}

});