<?php

const SITE_URL = 'http://localhost/';

function baseUrl($slug)
{
    return SITE_URL.$slug;
}

function redirectUrl($page)
{
    $redirectTo = SITE_URL.$page;
    header("location: $redirectTo");
    exit(0);
}