<?php

function createHead($title, $relativePath = "") { ?>
    <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="<?php echo $relativePath; ?>img/icon_032.png">
    <script src = "http://code.jquery.com/jquery-1.9.1.js"></script>
    <!--<link rel = "stylesheet" href = "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js" />-->
    <link rel = "stylesheet" href = "http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />

    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script src="<?php echo $relativePath; ?>js/jsHelper.js"></script>
    <!--<link rel="stylesheet" href="css/StyleSheet1.css" </tr>-->
    <script>
        //                function logout() {
        //                    $.get("logout.php");
        //                    return false;
        //                }
    </script>
    <style type="text/css">
        @import url('<?php echo $relativePath; ?>css/main_css.css');
    </style>
    <?php
}
