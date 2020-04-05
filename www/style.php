<?php
$background = 'FFFFFF';
$text = '6D6D6D';
$highlight = '2183D9';

//https://css-tricks.com/perfect-full-page-background-image/
?>
body {
    background-color: #<?php echo $background; ?>;
     background: url(image_bg.png) no-repeat center center fixed; 
   -webkit-background-size: cover;
   -moz-background-size: cover;
   -o-background-size: cover;
   background-size: cover;
    }

h1 {
    font-family: Futura, Arial, "sans-serif";
    color: #<?php echo $text; ?>;
    font-size: 3em;
    width: 50%;
    line-height: 2;
}

p {
    font-family: Futura, Arial, "sans-serif";
    color: #<?php echo $text; ?>;
    width: 80%;
    font-size: 1.2em;
    margin: 0 auto;
}

a {

    color: #<?php echo $highlight; ?>;
    font-style: none;
    text-decoration: none;
}

a:visited {

    color: #<?php echo $highlight; ?>;
    font-style: none;
    text-decoration: none;
}

a:hover {

     color: #<?php echo $highlight; ?>;
     text-decoration: underline;
}

a:active {

     color: #<?php echo $highlight; ?>;
     text-decoration: none;
}

.margin{
		margin: 20px;
}

.btn-primary,
.btn-primary:active,
.btn-primary:visited {
    padding: 5px;   
    font-size:20px;
    background-color: #<?php echo $background; ?>;
    border-color: #<?php echo $text; ?>;
    font-family: Futura, Arial, "sans-serif";
    color: #<?php echo $text; ?>;
    border-radius: 0px;
    outline: 0;
    border-style: solid;
}

.btn-primary:focus,
.btn-primary:hover,
.btn-primary:active {
    background-color: #<?php echo $background; ?>;
    border-color: #<?php echo $highlight; ?>;
    color: #<?php echo $text; ?>;
    border-radius: 0px;
/*    https://stackoverflow.com/questions/28712267/how-to-change-the-button-color-when-it-is-active-using-bootstrap */
}

.disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.text_input {
/*        border: 0;*/
        padding: 5px;
        box-shadow: none;
        font-size:20px;
        background-color: #<?php echo $background; ?>;
        font-family: Futura, Arial, "sans-serif";
        color: #<?php echo $text; ?>;
        outline: 0;
        border-style: solid;
        border-width: 0px;
/*        border-bottom: 2px #<?php echo $text; ?>;*/
        border-color: #<?php echo $text; ?>;
        border-radius: 0px;
/*    https://stackoverflow.com/questions/37465458/input-text-field-with-only-bottom-border/37465540*/
}

.text_input:focus {
  border-color: #<?php echo $highlight; ?>;
}

.text_input:disabled {
        background-color: #<?php echo $background; ?>;
}

select {
    box-shadow: none;
    padding: 5px;
        background-color: #<?php echo $background; ?>;
        font-family: Futura, Arial, "sans-serif";
        font-size:20px;
        color: #<?php echo $text; ?>;
        outline: 0;
        border-style: solid;
        border-width: 2px;
/*        border-bottom: 2px #<?php echo $highlight; ?>;*/
        border-color: #<?php echo $text; ?>;
        border-radius: 0px;
        content: '\f078';
}