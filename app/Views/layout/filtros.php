<?php
use App\Core\Basic\Model;
$model = new Model();

if ($_REQUEST['cmbAnoLetivo']) {
    $aCurso = $model->getComposicoesEscola(1373, $_REQUEST['cmbAnoLetivo']);
}
if ($_REQUEST['cmbComposicao']) {
    $aSeries = $model->getSerie($_REQUEST['cmbComposicao'], $_REQUEST['cmbAnoLetivo']);
}
if ($_REQUEST['cmbSerie']) {
    $aTurmas = $model->getTurmas(1373, $_REQUEST['cmbSerie'], $_REQUEST['cmbAnoLetivo']);
}
//dd($aTurmas);
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
            <div class="col-sm-5">
                <div style="font-size:14px;margin-top: 5px; ">Curso:</div>
                <select name="cmbComposicao" id="cmbComposicao" class="caixaTexto bg-white rounded-lg h30"
                        onchange="redirecionarGET()" style="width: 400px">
                    <option value="">- Selecione -</option>
                    <?php foreach($aCurso as $c => $v){ ?>
                        <option value="<?=$v['curso']?>"  <?php echo ($_REQUEST['cmbComposicao'] == $v['curso']) ? 'selected' : ''; ?>><?=utf8_encode($v['comp_ensino'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-2">
                <div style="font-size:12px;margin-top: 5px; ">Ano/Ciclo:</div>
                <select id="cmbSerie" name="cmbSerie" class="caixaTexto bg-white rounded-lg h30"
                        onchange="redirecionarGET()">
                    <option value="" selected>- Selecione -</option>
                    <?php foreach($aSeries as $c => $s){ ?>
                        <option value="<?=$s['codigo']?>" <?php echo ($_REQUEST['cmbSerie'] == $s['codigo']) ? 'selected' : ''; ?>><?=$s['nome']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-2">
                <div style="font-size:12px;margin-top: 5px; ">Turma:</div>
                <select id="cmbTurma" name="cmbTurma" class="caixaTexto bg-white rounded-lg h30"
                        onchange="redirecionarGET()">
                    <option value="" selected>- Selecione -</option>
                    <?php foreach($aTurmas as $c => $t){ ?>
                        <option value="<?=$t['codigo_turma']?>" <?php echo ($_REQUEST['cmbTurma'] == $t['codigo_turma']) ? 'selected' : ''; ?>><?=$t['turma']?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</form>
<hr>
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
        if ($("#cmbTurma").val()) {
            url += (url.includes("?") ? "&" : "?") + "cmbTurma=" + $("#cmbTurma").val();
        }
        window.location.href = url;
    }
</script>