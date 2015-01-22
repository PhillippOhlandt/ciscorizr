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

function Ciscorizr(){

	this.questions; //questions from api
	this.countdown; //html countdown element
	this.seconds; //start seconds (int)
	this.secondsLeft; //seconds left (int)
	this.questionIndex;
	this.answeredQuestions; //answered questions (int)
	this.content; //html content element
	this.questionParent; //html question parent element
	this.answerParent; //html answer parent element
	this.answerMarkup; //markup for generating answer html string
	this.playerQuestions; //array for api with user answered questions
	this.gameFinishedHandler; //for callback when game finished
	this.colorswitcher; //colorswitcher object for color control
	this.removedTimeTimer; //for red countdown on time remove

	this.gameRunning; //for logic (boolean)

	this.cinterval; //interval object for timer

	this.init = function(){
		this.questionIndex = 0;
		this.answeredQuestions = 0;
		this.playerQuestions = [];
		this.countdown.removeClass('invisible').show();
		this.secondsLeft = this.seconds;
		this.removedTimeTimer = 0;
		this.updateSeconds();
	}


	this.start = function(){
		this.gameRunning = true;
		this.showQuestion();
		this.cinterval = setInterval((function(self){
			return function(){
				self.timer();
			}
		})(this), 1000);
	}


	this.showQuestion = function(){
		var question = this.questions[this.questionIndex];
		this.questionParent.html(question.title);
		var answersHTML = "";
		var answerMarkup = this.answerMarkup;
		var answerCounter = 0;
		this.questions[this.questionIndex].answers.forEach(function(entry) {
			if(answerCounter == 0 || answerCounter == 2){
				answersHTML += '<div class="row">';
			}
			var answer = answerMarkup.replace('#ID#', answerCounter).replace('#TITLE#', entry.title);
			answersHTML += answer;
			if(answerCounter == 1 || answerCounter == 3){
				answersHTML += '</div>';
			}
			answerCounter++;
		});

		this.answerParent.html(answersHTML);
		this.colorswitcher.nextColor();
	}



	this.updateSeconds = function(){
		this.countdown.html(this.secondsLeft.toString().toMMSS());
	}


	this.clickAnswer = function(id){
		if(this.gameRunning){
			var question = this.questions[this.questionIndex];
			var answer = question.answers[id];
			if(answer.is_correct == "1"){
				this.answeredQuestions++;
				this.secondsLeft += parseInt(question.granted_time);
				this.updateSeconds();
				this.questionIndex++;
				if(!this.isGameFinished()){
					this.showQuestion();
				}
				question['answered'] = true;
				this.playerQuestions[this.playerQuestions.length] = question;

				if(this.isGameFinished()){
			    	this.gameFinished();
			    }
			}else{
				this.secondsLeft -= parseInt(question.granted_time);
				this.removedTimeTimer = 1;
				this.countdown.addClass('animated flash').attr('style', 'color:#ff0000!important');
				this.checkGameOver();
				this.updateSeconds();
			}
		}
	}

	this.isGameFinished = function(){
		if(this.questionIndex < this.questions.length){
			return false;
		}
		return true;
	}

	this.gameFinished = function(){
		this.gameRunning = false;
		window.clearInterval(this.cinterval);
		this.completePlayerQuestions();
		this.countdown.removeClass('animated wobble infinite');

		var data = [];
		data['playerQuestions'] = this.playerQuestions;
		data['secondsLeft'] = this.secondsLeft;
		data['answeredQuestions'] = this.answeredQuestions;
		this.countdown.removeAttr('style').addClass('animated fadeOutRight');
		this.gameFinishedHandler.handle(data);
	}

	this.timer = function(){
		this.secondsLeft--;

		if(this.removedTimeTimer > 0){
			this.removedTimeTimer--;
		}else{
			this.countdown.removeClass('flash').removeAttr('style');
		}

		this.updateSeconds();

		this.checkGameOver();

		if(this.secondsLeft <= 10 && this.secondsLeft > 0){
			this.countdown.addClass('animated wobble infinite');
		}else if(this.secondsLeft <= 0){
			this.countdown.removeClass('wobble infinite');
		}else{
			this.countdown.removeClass('wobble infinite');
		}
	}

	this.checkGameOver = function(){
		if(this.secondsLeft <= 0){
			this.secondsLeft = 0;
			window.clearInterval(this.cinterval);
			this.gameFinished();
		}
	}

	this.completePlayerQuestions = function(){
		var startIndex = this.playerQuestions.length;
		for(var i = startIndex; i < this.questions.length; i++){
			var question = this.questions[i];
			question['answered'] = false;
			this.playerQuestions[this.playerQuestions.length] = question;
		}
	}



















	String.prototype.toMMSS = function () {
	    var sec_num = parseInt(this, 10); // don't forget the second param
	    var hours   = Math.floor(sec_num / 3600);
	    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
	    var seconds = sec_num - (hours * 3600) - (minutes * 60);

	    if (hours   < 10) {hours   = "0"+hours;}
	    if (minutes < 10) {minutes = "0"+minutes;}
	    if (seconds < 10) {seconds = "0"+seconds;}
	    var time    = minutes+':'+seconds;
	    return time;
	}
}