<?php defined('SYSPATH') or die('No direct script access.'); ?>
<html>
    <head>
        <title>Dota Track</title>
        <style type="text/css">
            #testText {
                height: 30em;
                width: 40em;
            }
        </style>
    </head>
    <body>
        <h1>Test Page</h1>
        <h2>Input Page</h2>
        <form action="<?php echo URL::base(); ?>Test/submit" method="POST">
            <div>
                <textarea id="testText" name="testText"></textarea>
            </div>
            <input type="submit" value="Submit"></input>
        </form>
    </body>
</html>
