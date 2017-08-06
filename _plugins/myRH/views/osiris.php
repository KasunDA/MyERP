<div class="content <?php echo $tailleContent; ?>">
    <?php
        if ($argsPage['titrePage']) { ?>
            <h6><strong><?php echo $argsPage['titrePage']; ?></strong></h6>
        <?php } 
    ?>
    <hr>
    <div id="osiris">
        <div class='optionsAffiche center btmspace-30'>
            Merci de sélectionner les fichiers que vous voulez générer.<br>
            Il n'est pas nécessaire de tous les générer en même temps. Il suffit simplement de sélectionner ceux que vous désirez
            générer.<br>
        </div>
        <div class='one_quarter first'>
            <label>Fichier ETC</label>
        </div>
        <div class='three_quarter'>
            <input type="file" id="fileETC">
        </div>
        <div class='one_quarter first'>
            <label>Fichier ADR_FIS</label>
        </div>
        <div class='three_quarter'>
            <input type="file" id="fileADR">
        </div>
        <div class='one_quarter first'>
            <label>Fichier BQE_SAL</label>
        </div>
        <div class='three_quarter'>
            <input type="file" id="fileBQE">
        </div>
        <div class='one_quarter first'>
            <label>Fichier TRANSV</label>
        </div>
        <div class='three_quarter'>
            <input type="file" id="fileTRANSV">
        </div>
        <div class='one_quarter first'>
            <label>Fichier ENF_POP</label>
        </div>
        <div class='three_quarter'>
            <input type="file" id="fileENF">
        </div>
        <div class='one_quarter first'>
            <label>Fichier DIV</label>
        </div>
        <div class='three_quarter'>
            <input type="file" id="fileDIV">
        </div>
        <div class='one_quarter first  btmspace-15'>
            <label>Fichier CTN_COURANT</label>
        </div>
        <div class='three_quarter'>
            <input type="file" id="fileCTN">
        </div>
        <div class='four_quarter first center'>
            <hr>
            <button id=generation type="button" class="btn btn-success">LANCER LA GENERATION</button>
        </div>
    </div>
</div>
<script src='/_plugins/myRH/scripts/osiris.js'></script>
<script>
    $(function() {
        $(document).ready(function() {
            $('#generation').click(function(e) {
                alert($('#fileETC').val());
                test = $('#fileETC').val()
                messageChargement('osiris','Génération des fichiers à transmettre à ADP');
                $('#osiris').load('_plugins/myRH/fonctions/osiris.php',{
                    etc : $("#fileETC")[0].files[0].name;,
                    adr : $('#fileADR').val(),
                    bqe : $('#fileBQE').val(),
                    enf : $('#fileENF').val(),
                    transv : $('#fileTRANSV').val(),
                    div : $('#fileDIV').val(),
                    ctn: $('#fileCTN').val()
                });
            });
        });
    });
</script>