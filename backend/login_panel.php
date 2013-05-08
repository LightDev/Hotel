<html>
    <head>
        <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8">

        <link rel="stylesheet" href="../css/main_css.css" />
        <style>
            #welcomePanel{
                font-size:14px;
                text-align:center;
                padding-top:0px;
                width: 300px;
                margin: 18% auto 1em auto;
                /*margin-top:18px auto;*/
                /*height: 200px;*/
                -webkit-border-radius: 10px;
                -moz-border-radius: 10px;
                border-radius: 10px;
                border:1px solid #ccc;
                box-shadow: 2px 2px 2px #bbb;
                -webkit-box-shadow: 2px 2px 2px #bbb;
                -moz-box-shadow: 2px 2px 2px #bbb;
                background-color: #ffffff;


                -webkit-box-shadow: rgb(128, 125, 125) 1px 1px 4px;
                box-shadow: rgb(128, 125, 125) 1px 1px 4px;
                /*z-index: 20;*/
            }
            #welcomePanel:focus {
                outline:none}

            #container {
                /*float: left;*/
                background-color:#cccccc;
                background-image:url('../img/login_bg.jpg');
                background-size: 30px 20px;

                padding:-15px;
                margin:-10px;
            }
            .wrap {
                margin:0 auto;
                width:900px;
            }
            table tr td{
                text-align:  right;
            }
        </style>
    </head>
    <body>
        <!--<div class="wrap">-->
        <div id="container" style="background-color: rgb(204, 204, 204);">
            <div id="welcomePanel" >
                <h2 class="underline">PANEL ADMINISTRACYJNY</h2>
                <form action = "index.php" method="POST">
                    <table>
                        <tr>
                            <td>Nazwa użytkownika:</td>
                            <td><input name="login" type="text" /></td>
                        </tr>
                        <tr>
                            <td>Hasło:</td>
                            <td><input name="haslo" type="password" /></td>
                        </tr>
                        <tr>
                            <td>
                                <input type = "submit" class = "button gradient_silver" value = "Zaloguj się" />
                            </td>
                        </tr>
                    </table>
                </form>

            </div>
        </div>
        <!--</div>-->
    </body>


</html>