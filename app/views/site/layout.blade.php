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

<!doctype html>
<html>
    <head>
        <title>Ciscorizr</title>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <style type="text/css" media="screen">
            {{ (new ColoredCss(array("47b3e2", "5977c1", "e34a58", "f98646", "f8be46", "baca5c")))->withFontColor()->withHover(array("a1d7f0", "8397cf", "f2a3a9", "fcc1a2", "faca6a", "dae4ac"))->random()->withImportant()->render();  }}
        </style>
        
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,700|Montserrat:400,700|Hammersmith+One|Play:400,700|Karla:400,700|Questrial' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="{{ asset("/bootstrap/css/bootstrap.min.css") }}">
        <link rel="stylesheet" href="{{ asset("/css/common.css") }}">
        <link rel="stylesheet" href="{{ asset("/css/animate.css") }}">
        <link rel="stylesheet" href="{{ asset("/css/site/main.css") }}">

        <script src="{{ asset("/js/jquery/jquery-2.1.1.min.js") }}"></script>
        <script src="{{ asset("/bootstrap/js/bootstrap.min.js") }}"></script>
        <script src="http://fgnass.github.io/spin.js/spin.min.js"></script>
        <script src="{{ asset("/js/site/Ciscorizr.js") }}"></script>
        <script src="{{ asset("/js/site/ColorSwitcher.js") }}"></script>

        <script type="text/javascript">
            var cs = new ColorSwitcher();

            cs.colorCount = 6;
            
            var csrf = "{{ csrf_token(); }}";

            $(function(){
                    //cs.nextColor();

            });
            
        </script>

        <script src="{{ asset("/js/site/main.js") }}"></script>
    </head>
    <body>
        <div class="container">
        <div class="row head">
            <div class="col-md-6 col-sm-6 col-xs-6 logo color_font color_font-1"><a href="/" class="color_font color_font-1">Ciscorizr</a></div>
            <div class="col-md-6 col-sm-6 col-xs-6 rightToLogo">@yield('rightToLogo')</div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="logoContentDivider"></div>
            </div>
        </div>
        @yield('content')
        </div>

        <div id="layouts" style="display:none;">
            <div id="chapterscreen">
                @include('site.components.selectchapter')
            </div>
            <div id="questionandanswers">
                @include('site.components.questionandanswers')
            </div>
            <div id="gamefinished">
                @include('site.components.gamefinished')
            </div>
        </div>
    </body>
</html>
