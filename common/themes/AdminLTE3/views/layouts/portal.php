<?php /* @var $content string */?>
<?php $this->beginContent("@common/themes/AdminLTE3/views/layouts/main.php") ?>

<div class="row">
    <div class="col-12">
        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <?= \yii\bootstrap4\Nav::widget([
                    'items' => [
                        [
                            'label' => 'Аккаунты',
                            'url' => \yii\helpers\Url::to(['/portal/account']),
                            'active' => $this->context->id === 'portal/account',
                        ],
                        [
                            'label' => 'Порталы',
                            'url' => \yii\helpers\Url::to(['/portal/portal/index']),
                            'active' => $this->context->id === 'portal/portal',
                        ],
                    ],
                    'options' => ['class' => 'nav nav-tabs']
                ])?>
            </div>
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
