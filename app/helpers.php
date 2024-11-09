<?php

function containsForm($htmlContent): bool
{
    $dom = new DOMDocument();
    @$dom->loadHTML($htmlContent);
    $forms = $dom->getElementsByTagName('form');
    return $forms->length > 0;
}
