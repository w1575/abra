<?php

namespace frontend\controllers\web;

use common\components\behaviors\ViewParamsBehavior;
use frontend\components\controllers\MainController;
use Yii;
use frontend\models\company\web\WebCompany;
use frontend\models\company\web\search\WebCompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyController implements the CRUD actions for WebCompany model.
 */
class CompanyController extends MainController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $list = parent::behaviors();
        $list['viewParams'] = [
            'class' => ViewParamsBehavior::class,
            'tabs' => [
                [
                    'label' => 'Web компании',
                    'url' => \yii\helpers\Url::to(['/web/company']),
                    'active' => true,
                ],
                [
                    'label' => 'Услуги',
                    'url' => \yii\helpers\Url::to(['/web/company-service']),
                    'active' => false,
                ],

            ],
            'sideBar' => [
                'active' => 'webCompanies'
            ],
        ];
        return $list;
    }

    /**
     * Lists all WebCompany models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WebCompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WebCompany model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WebCompany model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WebCompany();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing WebCompany model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing WebCompany model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WebCompany model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WebCompany the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebCompany::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
