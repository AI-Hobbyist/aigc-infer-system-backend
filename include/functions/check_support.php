<?php
function check_support($category, $brands) {
    $support = array(
        "tts" => array(
            "bert-vits2",
            "gpt-sovits",
            "fish-speech"
        ),
        "svc" => array(
            "rvc",
            "sovits",
            "diffusion-svc",
            "ddsp-svc",
            "reflow-vae-svc"
        ),
        "svs" => array(
            "diffsinger"
        )
    );
    if (isset($support[$category]) && in_array($brands,$support[$category])){
        return true;
    }else{
        return false;
    }
}