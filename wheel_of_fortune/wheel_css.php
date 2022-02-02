<?php
ob_start();
session_start();
header("Content-type: text/css;");
header('Cache-control: must-revalidate');
?>

.column {
  float: left;
}

.left, .right {
  width: 20%;
  height: 95%;
}

.middle {
  width: 55%;
  height: 95%;
}

h1 {
  text-align: center;
  font-size: 35pt;
  color: blanchedalmond;
}

.gameArea {
  border: 4px double blanchedalmond;
  border-radius: 15px 15px;
  background-color: darkred;
  padding: 6px 14px;
  width: 80%;
  height: 35%;
  margin: 0 0 0 10%;
}

.directionsArea {
  border: 4px double blanchedalmond;
  border-radius: 15px 15px;
  background-color: darkred;
  padding: 6px 14px;
  font-family: inherit;
  width: 98%;
  height: 83%;
  margin: 5% 0 0 0;
  float: left;
}

.playArea {
  border: 4px double blanchedalmond;
  border-radius: 15px 15px;
  background-color: darkred;
  padding: 6px 14px;
  font-family: inherit;
  font-size: 12pt;
  width: 98%;
  height: 85%;
  margin: 5% 0 0 0;
  float: left;
}

.disabled {
  text-transform: uppercase;
  border: 4px double blanchedalmond;
  border-radius: 15px 15px;
  margin: 4%;
  background-color: grey;
  padding: 6px 14px;
  color: blanchedalmond;
  font-family: inherit;
  font-size: 12pt;
  float: left;
  width: 11.25%;
}

.menu_buttons {
  text-transform: uppercase;
  border: 4px double blanchedalmond;
  border-radius: 15px 15px;
  margin: 4% -12% 0% 21.5%;
  background-color: green;
  padding: 12px 14px;
  color: blanchedalmond;
  font-family: inherit;
  font-size: 12pt;
  float: left;
  width: 11.25%;
}

.directions {
  text-align: left;
  font-size: 23px;
  float: left;
  word-wrap: break-word;
  color: blanchedalmond;
}

.rightColumn2ndArea {
  text-align: left;
  font-size: 23px;
  float: left;
  word-wrap: break-word;
  color: blanchedalmond;
}

.display_background {
  background-color:green;
  padding: 1em 2em;
  border-radius: 40px;
  height: 95%;
}

body {
  background-color: darkred;
  padding: 29px;
  border-radius: 40px;
  border: 4px double #fff;
  height: 82%;
}

td {
  font-size: 25pt;
  font-family: verdana, serif;
  background-color: blanchedalmond;
  height: 35px;
  width: 40px;
}

table .space {
  display: none;
}

table .showChar  {
  color: black;
  text-align: center;
}

table  {
  border-collapse: separate;
  border-spacing: 20px;
  margin-left:auto;
  margin-right:auto;
}

.scoreArea {
  text-align: center;
  font-size: 25pt;
  float: left;
  padding-top: 5%;
  width: 105%;
  border: blanchedalmond double 4px;
  background-color: darkred;
  border-radius: 15px 15px;
  color: blanchedalmond;
  height: 9%;
}

.userInfo {
  text-align:center;
  font-size: 25pt;
  float: left;
  width: 102%;
  padding: 2%;
  border: blanchedalmond double 4px;
  background-color: darkred;
  border-radius: 15px 15px;
  color: blanchedalmond;
  height: 11%;
}

#headerText {
  margin: 0 0 1% 0;
  font-size: 40pt;
  color:blanchedalmond;
  text-align: center;
}

.wheel {
  width: 40%;
  height: 55%;
  margin-left: 30%;
  margin-top: 1%;
  background-image: url('./wheel.png');
  background-repeat: no-repeat;
  background-color: transparent;
  background-size: contain;
  background-position: center;
  float: left;
}

.ticker {
  position: relative;
  z-index: 1;
  height: 0;
  width: 0;
  left: 68%;
  top: 25%;
  border-width: 6px 40px 6px 0;
  transform: scaleY(2);
  transform-origin: 50% 0;
  border-color: transparent red transparent transparent;
  border-style: solid;
  }

.wheelRadioButton:checked ~ .wheel {
  animation-name: Spin;
  animation-duration: 3s;
  animation-timing-function: ease;
  animation-fill-mode: both;
}

.wheelRadioButton:checked ~ .ticker {
  animation-name: Ticker;
  animation-duration: 3s;
  animation-timing-function: ease-out;
  animation-fill-mode: both;
}

@keyframes Spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transition: all 1s ease-out;
    transform: rotate(<?php echo $_SESSION['spinValue'] + 360 . "deg"; ?>);
  }
}

@keyframes Ticker {
  0%, 100% {
    transform: rotate(0deg) scaleY(2);
  }

  5%, 10%, 16%, 23%, 31%, 40%, 50%, 61%, 73%, 86% {
    transform: rotate(-15deg) scaleY(2);
  }
  7.5%, 13%, 20.5%, 27%, 35.5%, 45%, 55.5%, 67%, 79.5% {
    transform: rotate(-10deg) scaleY(2);
  }
}

.hide {
  opacity: 0;
}

input[type=text].guessInput {
  text-align: center;
  font-size: 40px;
  width: 60px;
  height: 60px;
  background-color: blanchedalmond;
  margin-top: 10%;
  margin-left: 40%;
  margin-bottom: 10%;
  margin-right: auto;
}

.guessButton {
  text-transform: uppercase;
  border: 4px double blanchedalmond;
  border-radius: 15px 15px;
  background-color: green;
  height: 11%;
  width: 25%;
  color: blanchedalmond;
}

#guessResponsetext {
  background: blanchedalmond;
  color: green;
  font-size: 23pt;
  padding: 0%;
  text-align: center;
  height: 36%;
  width: 100%;
  margin-left: auto;
  margin-right: auto;
}

.startSpinButton {
    color: blue;
    margin-left: 42%;
animation:blinkingText 1.2s infinite;
}



@keyframes blinkingText{
0%{     color: red;    }
49%{    color: blanchedalmond; }
60%{    color: transparent; }
99%{    color:red;  }
100%{   color: transparent;    }
}