<?php
use yii\bootstrap4\Breadcrumbs;
?>
<?php $this->beginContent("@frontend/themes/bootstrap4material/views/layouts/sidebar.php"); ?>
<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom"><?= $this->title ?></h2>
        </div>
    </header>

    <?php if (isset($this->params['breadcrumbs'])): ?>
        <div class="breadcrumb-holder container-fluid">
            <?= Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'],
            ]) ?>
        </div>
    <?php endif; ?>

    <!-- Dashboard Counts Section-->
    <section class="content-main">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Footer-->
    <footer class="main-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <p>
                        <?= \yii\helpers\Html::a(
                            'w',
                            'https://github.com/w1575',
                            [
                                'class' => 'text--white',
                                'target' => '_blank',
                            ]
                        ) ?>
                    </p>
                </div>
                <div class="col-sm-6 text-right">
                    <p>Design by <a href="https://bootstrapious.com/p/admin-template" class="external">Bootstrapious</a></p>
                    <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                </div>
            </div>
        </div>
    </footer>
</div>
<?php $this->endContent() ?>
