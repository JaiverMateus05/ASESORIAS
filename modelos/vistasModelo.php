<?php 

class vistasModelo{
    protected static function obtener_vistas_modelo($vistas){

        $listaBlanca=["home","user-list","user-new","user-search","user-update","speciality-new","speciality-list"
    ,"speciality-add","advisor-list","advisory-hour","advisor-agenda","user-hour-agenda","my-agenda-E","my-agenda-A"
     , "finished-advisory-list","advisory-history-list","history-update"];
        if(in_array($vistas,$listaBlanca)){

            if(is_file("./vistas/contenidos/".$vistas."-view.php")){

                $contenido="./vistas/contenidos/".$vistas."-view.php";
            }
        }elseif($vistas=="login" || $vistas=="index"){  
            $contenido="login";
        }else{
            $contenido="404";
        }
        return $contenido;
    }
}