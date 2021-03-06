<?php

namespace app\controllers;

use Yii;
use app\models\Area;
use app\models\AreaSearch;
use app\models\AlertaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\ControlAcceso;
/**
 * AreaController implements the CRUD actions for Area model.
 */
class AreaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => ControlAcceso::className(),
                'rules' =>[ [
					'allow'=>true,
					'actions'=>['index', 'view'],
					'roles'=>['N'],
				],
				[
					'allow'=>true,
					'actions'=>['index','view','create','update','delete', 'admin', 'moderator'],
					'roles'=>['A','M'],
				],
				],
            ],
        ];
    }

    /**
     * Lists all Area models.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new AreaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'clasesArea' => Area::$clases_area
        ]);
    }

    /**
     * Displays a single Area model.
     * @param string $id
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
     * Creates a new Area model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Area();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Area model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing Area model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Area model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Area the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Area::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionIndex() {
        $searchModel = new AreaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if (Yii::$app->user->identity->rol != 'N')
            $this->redirect(['admin']);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'clasesArea' => Area::$clases_area,
            'rol' => Yii::$app->user->identity->rol
        ]);
    }

    /* Show areas for moderator */
    public function actionModerator() {
        $searchModel = new AlertaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $userAreaID = Yii::$app->user->identity->area_id;
        $dataProvider->query->where(['=','area_id', $userAreaID]);
        $areaName = Yii::$app->user->identity->areaName;

        return $this->render('moderator', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'areaName' => $areaName,
        ]);
    }
}
