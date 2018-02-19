<?php
function breadcrumbs($sep = '', $home = 'Dashboard')
{
$site = 'http://'.$_SERVER['HTTP_HOST'];
$crumbs = explode('/', strrev($_SERVER["REQUEST_URI"]), 2);
$homeurl = $site.strrev($crumbs[1]);
$page = strrev($crumbs[0]);
$link = ucfirst(str_replace( array(".php","-","_","docprofile","id","?","="), array(""," "," ","Doctor Profile") ,$page));
$bc = '<ol class="breadcrumb">';
$bc .= '<li><a href="'.$homeurl.'/index.php'.'">'.$home.'</a>'.$sep.'</li>';
    if($link == "Index")
    {
        $bc .= '<li class="active">Main</li>';
    }
    else
    {
        $bc .= '<li class="active">'.$link.'</li>'; 
    }
$bc .= '</ol>';
return $bc;
}
?>