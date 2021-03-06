<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\ListaImagenes;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Alerta */

/*  FICHA PUBLICA DE ALERTA para usuarios sin registrar*/

$this->title = Yii::t('app','Imagenes de la Alerta '. $model->id);
$this->params['breadcrumbs'][] = ['label' => 'Alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
 
    $url = Yii::$app->getRequest()->getQueryParam('url');  
    if(!isset($url))
     $url= ['view', 'id'=>$model->id];    
?>

<div class="alerta-view">

    <h1><?= Html::encode($this->title) ?></h1>
	 <?= Html::a('Volver',  $url, ['class' => 'btn btn-primary']);?>

</div>
<div>
	 <h3>Imagenes:</h3>
   
    <div>
        <!--<textarea  rows="10" name="comment" id="comment" placeholder="Imagenes" ></textarea>-->
            <?= ListaImagenes::widget(['id_alerta' => $model->id, 'view' => $this]) ?>
    </div>
  
</div>