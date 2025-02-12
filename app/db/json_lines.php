<?php
/*-----------------------------------------------------------------------------
Função: Barras
    função para gerar um JSON para o Gráfico Barras
Entrada:
    $_GET = Parâmetros para consulta EixoUm::getter_barras
Saída:
    Dados formatados para o JSON barras
-----------------------------------------------------------------------------*/

header('charset=utf-8');


function sigla_cadeia($cadeia) {
    switch($cadeia) {
        case "Arquitetura e Design":
            return "Arq e D";
        case "Publicidade":
            return "Publ.";
        case "Patrimônio":
            return $cadeia;
        case "Música":
            return $cadeia;
        case "Entretenimento":
            return "Entret.";
        case "Educação e Criação em Artes":
            return "Edu. Art.";
        case "Editorial":
            return "Edit.";
        case "Cultura Digital":
            return "Cult. Dig.";
        case "Audiovisual":
            return "Audio";
        case "Artes Cênicas e Espetáculos":
            return "Artes";
        case "Outros":
            return $cadeia;
    }
}

if (!empty($_GET["var"])) {

    $var = $_GET["var"];
    $uf = $_GET["uf"];

    $atc = $_GET["atc"];
    $cad = $_GET["cad"];
    $prt = $_GET["prt"];
    $ocp = $_GET["ocp"];
    $sex    =   isset($_GET["sex"])   ?   $_GET["sex"]  :   0;	   /*== sexo ==*/
    $fax    =   isset($_GET["fax"])   ?   $_GET["fax"]  :   0;	   /*== faixa etaria ==*/
    $esc    =   isset($_GET["esc"])   ?   $_GET["esc"]  :   0;	   /*== escolaridade ==*/
    $cor    =   isset($_GET["cor"])   ?   $_GET["cor"]  :   0;	   /*== cor e raça ==*/
    $frm    =   isset($_GET["frm"])   ?   $_GET["frm"]  :   0;	   /*== formalidade ==*/
    $prv    =   isset($_GET["prv"])   ?   $_GET["prv"]  :   0;	   /*== previdencia ==*/
    $snd    =   isset($_GET["snd"])   ?   $_GET["snd"]  :   0;	   /*== sindical ==*/
    $mec    =   isset($_GET["mec"])   ?   $_GET["mec"]  :   0;	   /*== mecanismo ==*/
    $mod    =   isset($_GET["mod"])   ?   $_GET["mod"]  :   0;	   /*== modalidade ==*/
    $pfj    =   isset($_GET["pfj"])   ?   $_GET["pfj"]  :   0;	   /*== pessoa fisica/juridica ==*/
    $uos    =   isset($_GET["uos"])   ?   $_GET["uos"]  :   0;	   /*== UF ou Setores ==*/
    $prc    =   isset($_GET["prc"])   ?   $_GET["prc"]  :   0;	   /*== Parceiro ==*/
    $slc    =   isset($_GET["slc"])   ?   $_GET["slc"]  :   0;	   /*== Parceiro ==*/
    $typ    =   isset($_GET["typ"])   ?   $_GET["typ"]  :   0;	   /*== Tipo de atividade ==*/
    $ano    =   isset($_GET["ano"])   ?   $_GET["ano"]  :NULL;	   /*== Ano ==*/

    $eixo = $_GET['eixo'];
}
else{
    $var = 1;
    $uf = 0;

    $atc = 0;
    $cad = 0;
    $prt = 0;
    $ocp = 0;
    $sex = 0;
    $fax = 0;
    $esc = 0;
    $slc = 0;
    $cor = 0;
    $mec = 0;
    $mod = 0;
    $pjj = 0;
    $frm = 0;
    $prv = 0;
    $uos = 0;
    $typ = 0;
    $prc = 0;
    $ano = NULL;
    $snd = 0;
    $eixo = 0;
}

//Trata o sexo
switch($sex) {
    case "0":
        $sex = NULL;
        break;
    case "1":
        $sex = 1;
        break;
    case "2":
        $sex = 0;
        break;
    default:
        $sex = NULL;
}

//Trata a modalidade
switch($mod) {
    case "0":
        $mod = NULL;
        break;
    case "1":
        $mod = 1;
        break;
    case "2":
        $mod = 0;
        break;
    default:
        $mod = NULL;
}

//Trata a pessoa fisica/juridica
switch($pfj) {
    case "0":
        $pfj = NULL;
        break;
    case "1":
        $pfj = 1;
        break;
    case "2":
        $pfj = 0;
        break;
    default:
        $pfj = NULL;
}

function getName($uos) {
    switch ($uos) {
        case 0:
            return "UF";
        case 1:
            return "Setor";
    }
}

function getName2($mec) {
    switch ($mec) {
        case 0:
            return "Despesa Minc / Receita executivo";
        case 1:
            return "Financiamento Estatal / Receita executivo";
    }
}

function getTyp($type) {
    switch ($type) {
        case 1:
            return "Exportação";
        case 2:
            return "Importação";
        case 3:
            return "SaldoComercial";
        case 4:
            return "ValorTransicionado";
    }
}

function getNameSLC($slc) {
    switch ($slc) {
        case 0:
            return "Relacionadas";
        case 1:
            return "Culturais";
    }
}

$linhas = array();
if($eixo == 0 && $var == 3) {
    require_once("EixoUm.php");
    for ($cad = 1; $cad <= 10; $cad++) {

        foreach (EixoUm::getter_barras($var, $uf, $atc, $cad, $prt, $uos) as $tupla) {

            $id = $tupla->Ano;
            // $barras[$tupla->Ano] = $tupla->Valor;
            $barras[$id]['ano'] = (int)$tupla->Ano;
            $barras[$id][$tupla->CadeiaNome] = (double)$tupla->Valor;


            //$barras[$id]['uf'] = $tupla->UFNome;

        }
    }
}
else if($eixo == 0 && $var > 9) {
    require_once("EixoUm.php");
    for ($uos = 0; $uos <= 1; $uos++) {

        foreach (EixoUm::getter_barras($var, $uf, $atc, $cad, $prt, $uos) as $tupla) {

            $id = $tupla->Ano;
            // $barras[$tupla->Ano] = $tupla->Valor;
            $barras[$id]['ano'] = (int)$tupla->Ano;
            $barras[$id][getName($uos)] = (double)$tupla->Valor;


            //$barras[$id]['uf'] = $tupla->UFNome;

        }
    }
}
else if($eixo == 1 && $var > 11) {
    require_once("EixoDois.php");

    if($ocp == 0){

        for ($uos = 0; $uos <= 1; $uos++) {

            foreach (EixoDois::getter_barras($var, $uf, $cad, $prt, $ocp, $esc, $cor, $fax, $frm, $prv, $snd, $sex, $uos, $slc) as $tupla) {
                if($prt == 0 && $esc == 0 && $cor == 0 && $fax == 0 && $frm == 0 && $prv == 0 && $snd == 0 && $sex == NULL) {
                    $id = $tupla->Ano;

                    $barras[$id]['ano'] = (int)$tupla->Ano;
                    $barras[$id][getName($uos)] = (double)$tupla->Valor;

                    //$barras[$id]['uf'] = $tupla->UFNome;
                }
            }
        }
    }
    else{
        for ($i = 0; $i <= 1; $i++) {

            foreach (EixoDois::getter_barras($var, $uf, $cad, $prt, $ocp, $esc, $cor, $fax, $frm, $prv, $snd, $sex, $uos, $slc) as $tupla) {

                $id = $tupla->Ano;
                if($slc == 1) {
                    if($id == 2011) {
                        $id = 2010;
                    }
                    if($id == 2012) {
                        $id = 2011;
                    }
                    if($id == 2013) {
                        $id = 2012;
                    }
                    if($id == 2014) {
                        $id = 2013;
                    }
                    if($id == 2015) {
                        $id = 2014;
                    }
                }

                $barras[$id]['ano'] = (int)$tupla->Ano;
                $barras[$id][getNameSLC($i)] = (double)$tupla->Valor;

            }
        }
    }

}
else if($eixo == 1 && $var == 5) {
    require_once("EixoDois.php");
    for ($cad = 1; $cad <= 10; $cad++) {

        foreach (EixoDois::getter_barras($var, $uf, $cad, $prt, $ocp, $esc, $cor, $fax, $frm, $prv, $snd, $sex, $uos, $slc) as $tupla) {

            $id = $tupla->Ano;
            // $barras[$tupla->Ano] = $tupla->Valor;
            $barras[$id]['ano'] = (int)$tupla->Ano;
            $barras[$id][$tupla->CadeiaNome] = (double)$tupla->Valor;


            //$barras[$id]['uf'] = $tupla->UFNome;

        }
    }
}
else if($eixo == 1 && ($var == 11 || $var == 10 || $var == 9 || $var == 8) ) {
    require_once("EixoDois.php");
    for ($cad = 1; $cad <= 10; $cad++) {

        foreach (EixoDois::getter_barras($var, $uf, $cad, $prt, $ocp, $esc, $cor, $fax, $frm, $prv, $snd, $sex, $uos, $slc) as $tupla) {
            $id = $tupla->Ano;
            // $barras[$tupla->Ano] = $tupla->Valor;
            $barras[$id]['ano'] = (int)$tupla->Ano;
            $barras[$id][$tupla->CadeiaNome] = (double)$tupla->Valor;


        }
    }
}
else if($eixo == 2 && $var > 14) {
    require_once("EixoTres.php");
    for ($uos = 0; $uos <= 1; $uos++) {

        foreach (EixoTres::getter_barras($var, $uf, $cad, $mec, $pfj, $mod, $ano, $uos) as $tupla) {
            $id = $tupla->Ano;
            // $barras[$tupla->Ano] = $tupla->Valor;
            $barras[$id]['ano'] = (int)$tupla->Ano;
            $barras[$id][getName($uos)] = (double)$tupla->Valor;


            //$barras[$id]['uf'] = $tupla->UFNome;

        }
    }
}
else if($eixo == 2 && $var == 10) {
    require_once("EixoTres.php");
    for ($mec = 0; $mec <= 1; $mec++) {

        foreach (EixoTres::getter_barras($var, $uf, $cad, $mec, $pfj, $mod, $ano, $uos) as $tupla) {
            $id = $tupla->Ano;
            // $barras[$tupla->Ano] = $tupla->Valor;
            $barras[$id]['ano'] = (int)$tupla->Ano;
            $barras[$id][getName2($mec)] = (double)$tupla->Valor;


            //$barras[$id]['uf'] = $tupla->UFNome;

        }
    }
}
else if($eixo == 2 && $var < 14){
        require_once("EixoTres.php");
        for ($cad = 1; $cad <= 10; $cad++) {

            foreach (EixoTres::getter_barras($var, $uf, $cad, $mec, $pfj, $mod, $ano, $uos) as $tupla) {
                
                $id = $tupla->Ano;
                // $barras[$tupla->Ano] = $tupla->Valor;
                $barras[$id]['ano'] = (int)$tupla->Ano;
                $barras[$id][$tupla->CadeiaNome] = (double)$tupla->Valor;


                //$barras[$id]['uf'] = $tupla->UFNome;

            }
        }

}
else if($eixo == 3 && ($var >= 5 && $var <= 10)){
    require_once("EixoQuatro.php");
    for($i = 1; $i <= 4 ; $i++){
        foreach (EixoQuatro::getter_barras($var, 0, 0, $i, 0, 0, $slc) as $tupla) {
            $id = $tupla->Ano;
            $barras[$id]['ano'] = (int)$tupla->Ano;
            $barras[$id][getTyp($i)] = (double)$tupla->Valor;

        }
    }
}


echo json_encode($barras);

?>