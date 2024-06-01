<?php
function spk_url($server, $brand) {
    $brands = array(
        "bert-vits2" => "spks",
        "gpt-sovits" => "character_list"
    );
    if (array_key_exists($brand, $brands)) {
        $path = $brands[$brand];
        $url = "$server/$path";
    } else {
       $url = "$server/spks";
    }
    return $url;
}