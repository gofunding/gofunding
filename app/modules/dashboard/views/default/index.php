<div class="dashboard-default-index">
    <h1>Overview</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="panel">
                <div class="panel-body">
                    <h3><?= $campaign ?></h3>
                    <h4>Campaign dimulai</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel">
                <div class="panel-body">
                    <h3><?= $donasi ?></h3>
                    <h4>Donasi</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel">
                <div class="panel-body">
                    <h3><?= Yii::$app->formatter->asCurrency($donasiTersalurkan) ?></h3>
                    <h4>Total Donasi Anda</h4>
                </div>
            </div>
        </div>
    </div>
</div>
