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

class ColoredCss{
	protected $data = array();
	protected $dataHover = array();

	protected $className = "color";
	protected $fontSuffix = "_font";
	protected $hoverSuffix = "_hover";
	protected $withHover = false;
	protected $withImportant = false;
	protected $withFontColor = false;
	protected $withBackgroundColor = true;

	function __construct($data){
		$this->data = $data;
	}

	function setClassName($className){
		$this->className = $className;
		return $this;
	}

	function withHover($data){
		$this->withHover = true;
		$this->dataHover = $data;
		$this->data = $this->mergeArray($this->data, $this->dataHover);
		return $this;
	}

	function withImportant(){
		$this->withImportant = true;
		return $this;
	}

	function withFontColor(){
		$this->withFontColor = true;
		return $this;
	}

	function withBackgroundcolor(){
		$this->withBackgroundColor = true;
		return $this;
	}

	function withoutBackgroundcolor(){
		$this->withBackgroundColor = false;
		return $this;
	}

	function mergeArray($array1, $array2){
		$new = array();
		for($i = 0; $i < count($array1); $i++){
			$new[$i] = array($array1[$i] => $array2[$i]);
		}
		return $new;
	}

	function random(){
		shuffle($this->data);
		return $this;
	}

	function showData(){
		print_r($this);
	}

	private function generateEntity($classname, $attribute, $value, $important){

		$important_str = "";
		if($important){
			$important_str = "!important";
		}
		$str = ".".$classname. "{".
				$attribute . ":". $value . $important_str . ";".
				"}";
		return $str;
	}

	private function renderSingleArray($data){
		for ($i = 0; $i < count($data); $i++){
			$index = $i + 1;
			if($this->withBackgroundColor){
				echo $this->generateEntity($this->className . "-". $index, "background-color", "#".$data[$i], $this->withImportant) . "\n";
			}

			if($this->withFontColor){
				echo $this->generateEntity($this->className . $this->fontSuffix . "-". $index , "color", "#".$data[$i], $this->withImportant) . "\n";
			}
			
		}
	}

	private function renderMultidimensionalArray($data){
		for($i = 0; $i < count($data); $i++){
			$index = $i + 1;
			foreach($data[$i] as $key => $value){
				if($this->withBackgroundColor){
					echo $this->generateEntity($this->className . "-". $index, "background-color", "#".$key, $this->withImportant) . "\n";
					echo $this->generateEntity($this->className . $this->hoverSuffix . "-". $index, "background-color", "#".$key, $this->withImportant) . "\n";
					echo $this->generateEntity($this->className . $this->hoverSuffix . "-". $index . ":hover", "background-color", "#".$value, $this->withImportant) . "\n";
				}

				if($this->withFontColor){
					echo $this->generateEntity($this->className . $this->fontSuffix . "-". $index, "color", "#".$key, $this->withImportant) . "\n";
				}
			}
		}
	}

	function render(){
		if($this->withHover){
			$this->renderMultidimensionalArray($this->data);
			return;
		}

		$this->renderSingleArray($this->data);	
		return;	
	}
}