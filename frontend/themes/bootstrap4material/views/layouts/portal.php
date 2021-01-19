<?php $this->beginContent("@frontend/themes/bootstrap4material/views/layouts/main.php") ?>
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
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="tab-content-wrap">
            <?= $content ?>
        </div>
    </div>
</div>

<?php $this->endContent() ?>
