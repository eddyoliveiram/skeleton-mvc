<?php
use App\Core\Basic\Globals;

if ($_REQUEST['cmbAnoLetivo']) {
    $aCurso = $model->getComposicoes($_REQUEST['cmbAnoLetivo']);
}
?>
<form method="GET">
    <div class="container-fluid mt8" style="height:60px">
        <div class="row">
            <div class="col-sm-2">
                <div style="font-size:14px;margin-top: 5px">Ano Letivo:</div>
                <select id="cmbAnoLetivo" name="cmbAnoLetivo" class="caixaTexto bg-white rounded-lg h30"
                        onchange="redirecionarGET()">
                    <option value="">- Selecione -</option>
                    <option value="2023" <?php echo ($_REQUEST['cmbAnoLetivo'] == '2023') ? 'selected' : ''; ?>>2023</option>
                    <option value="2024" <?php echo ($_REQUEST['cmbAnoLetivo'] == '2024') ? 'selected' : ''; ?>>2024</option>
                </select>
            </div>
            <div class="col-sm-4">
                <div style="font-size:14px;margin-top: 5px; ">Curso:</div>
                <select name="cmbComposicao" id="cmbComposicao" class="caixaTexto bg-white rounded-lg h30"
                        onchange="redirecionarGET()" style="width: 300px">
                    <option value="">- Selecione -</option>
                    <?php foreach($aCurso as $c => $v){ ?>
                        <option value="<?=$v['curso']?>"  <?php echo ($_REQUEST['cmbComposicao'] == $v['curso']) ? 'selected' : ''; ?>><?=utf8_encode($v['comp_ensino'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-3">
                <div style="font-size:12px;margin-top: 5px; ">Ano/Ciclo:</div>
                <select id="cmbSerie" name="cmbSerie  bg-white" class="caixaTexto bg-white rounded-lg h30"> <option value="" selected>- Selecione -</option>
                    <?php foreach($aSeries as $c => $s){ ?>
                        <option value="<?=$s['codigo']?>" <?php echo ($_REQUEST['cmbComposicao'] == $s['codigo']) ? 'selected' : ''; ?>><?=$s['nome']?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</form>

<script>
    function redirecionarGET() {
        var url = window.location.pathname;
        if ($("#cmbAnoLetivo").val()) {
            url += "?cmbAnoLetivo=" + $("#cmbAnoLetivo").val();
        }
        if ($("#cmbComposicao").val()) {
            url += (url.includes("?") ? "&" : "?") + "cmbComposicao=" + $("#cmbComposicao").val();
        }
        if ($("#cmbSerie").val()) {
            url += (url.includes("?") ? "&" : "?") + "cmbSerie=" + $("#cmbSerie").val();
        }
        window.location.href = url;
    }
</script>