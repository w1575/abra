<?php

/* @var $this \yii\web\View */
/* @var $this \yii\web\View */
/* @var $content string */

?>
<?php $this->beginContent('@common/themes/AdminLTE3/views/layouts/main.php') ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <?= $content ?>
            </div>
        </div>
    </div>
<!-- /.content-wrapper -->
<?php $this->endContent() ?>