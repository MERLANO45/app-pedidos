<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function limpiarCadena($valor){
        $valor = preg_replace('([^A-Za-z0-9 ])', '', $valor);
        $valor = str_ireplace(" SELECT ","",$valor);
        $valor = str_ireplace("<script>","",$valor);
        $valor = str_ireplace(" DATABASES ","",$valor);
        $valor = str_ireplace(" TRUNCATE ","",$valor);
        $valor = str_ireplace(" DROP TABLE ","",$valor);
        $valor = str_ireplace(" FROM ","",$valor);
        $valor = str_ireplace(" SHOW ","",$valor);
        $valor = str_ireplace(" WHERE ","",$valor);
        $valor = str_ireplace(" HTML ","",$valor);
        $valor = str_ireplace(" COPY ","",$valor);
        $valor = str_ireplace(" DELETE ","",$valor);
        $valor = str_ireplace(" DROP ","",$valor);
        $valor = str_ireplace(" DUMP ","",$valor);
        $valor = str_ireplace(" OR ","",$valor);
        $valor = str_ireplace(" script ","",$valor);
		$valor = str_ireplace(" while ","",$valor);
		$valor = str_ireplace(" for ","",$valor);
		$valor = str_ireplace(" if ","",$valor);
        $valor = str_ireplace(" LIKE ","",$valor);
        $valor = str_ireplace(" echo ","",$valor);
        $valor = str_ireplace(" php ","",$valor);
       /* $valor = str_ireplace("%","",$valor);
        $valor = str_ireplace(" * ","",$valor);
        $valor = str_ireplace("--","",$valor);
        $valor = str_ireplace("^","",$valor);
        $valor = str_ireplace("[","",$valor);
        $valor = str_ireplace("]","",$valor);
        $valor = str_ireplace("!","",$valor);
        $valor = str_ireplace("¡","",$valor);
        $valor = str_ireplace("?","",$valor);
        $valor = str_ireplace("=","",$valor);
        $valor = str_ireplace("&","",$valor);
        $valor = str_ireplace("==","",$valor);
        $valor = str_ireplace("()","",$valor);
        $valor = str_ireplace("'>","",$valor);
        $valor = str_ireplace("$(","",$valor);
        $valor = str_ireplace("').","",$valor);
        $valor = str_ireplace("<","",$valor);
        $valor = str_ireplace(">","",$valor);
        $valor = str_ireplace("{","",$valor);
        $valor = str_ireplace("}","",$valor);
        $valor = str_ireplace("$","",$valor); */

    return $valor;
    }
}
