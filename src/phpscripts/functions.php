<?php

function getPage(){
    if (isset($_GET['page'])) {
        $page = htmlspecialchars($_GET['page']);
    } else {
        $page = 'home';
    }

    include_once $page . '.php';
}