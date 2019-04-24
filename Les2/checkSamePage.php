<?php

function currentUrl( $trim_query_string = false ) {
    $pageURL = (isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
    $pageURL .= $_SERVER["SERVER_NAME"] .':' .$_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    if( ! $trim_query_string ) {
        return $pageURL;
    } else {
        $url = explode( '?', $pageURL );
        return $url[0];
    }
}

function requestIsFromSamePage()
{
    $current_url = currentUrl(true);
    $request_page = explode('?',$_SERVER['HTTP_REFERER'] ?? "")[0];
    return $current_url === $request_page;
}


if(requestIsFromSamePage()) {
    echo "Same page";
} else {
    echo "Different page";
}
?>
<form>
    <button type="submit"></button>
</form>

