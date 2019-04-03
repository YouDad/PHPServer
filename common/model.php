<?php
function model($name)
{
    $className = "\\core\\lib\\model\\" . $name . "Model";
    return $className::getIns();
}