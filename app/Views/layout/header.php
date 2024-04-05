<?php mostrarBannerBancoAtual();?>
    <div class="row text-center barra-topo " style="margin-top: 16px">

        <div class="col-12">
            <div class="borda d-flex justify-content-between">
                <div class="p-2">
                    <a href="#" onclick="javascript:location.href='../../menuAcademico.php?codigoModulo=16'" class="btn btn-bottomless" style="margin-top: 10px; font-size:14px; font-weight: bold;">
                        M&Oacute;DULO ACAD&Ecirc;MICO
                    </a>
                </div>
                <div class="p-2">
                    <a class="navbar-brand"> <img src="<?=PUBLIC_PATH.'/images/brasao.png';?>" width="80" height="60"> </a>
                </div>
            </div>
        </div>
    </div>

<?php
function mostrarBannerBancoAtual() {

    $aServidoresPermitidos = ['localhost', 'www3'];

    if (in_array($_SERVER['SERVER_NAME'], $aServidoresPermitidos)) {

        if ($_SESSION['banco_atual'] == '192.168.200.42') {
            $color = '#e60000';
            $banco = "Producao (" . $_SESSION['banco_atual'] . ")";
        } else
            if ($_SESSION['banco_atual'] == '192.168.200.52') {
                $color = '#00b33c';
                $banco = "Homologacao (" . $_SESSION['banco_atual'] . ")";
            } else
                if ($_SESSION['banco_atual'] == '192.168.200.41') {
                    $color = '#3399ff';
                    $banco = "Teste (" . $_SESSION['banco_atual'] . ")";
                }

        echo "<div align='center' 
            style='padding: 2px; z-index: 9999;
            color:".$color.";
            position: fixed;
            left: 50%;
            padding: 2px 14px 2px 14px;
            transform: translateX(-50%);
            font-weight: bold;
            font-family: arial !important;
			font-size:12px;
            '>
            " . $banco . "
            </div>";
    }
}
?>