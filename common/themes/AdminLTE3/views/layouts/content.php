<?php /* @var $content string */?>
<?php $this->beginContent("@common/themes/AdminLTE3/views/layouts/main.php") ?>

<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline card-tabs">

            <?php if (isset($this->params['tabs'])): ?>
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <?php echo \yii\bootstrap4\Nav::widget([
                        'items' => $this->params['tabs'] ?? [],
                        'options' => ['class' => 'nav nav-tabs']
                    ]) // */ ?>
                </div>
            <?php endif; ?>

            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="tab-content-wrap">
                            <?= $content ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php $this->endContent() ?>
