<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Area */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Áreas'), 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute' => 'claseArea'],
            'nombre',
            'parentName',
            'childrenNames',
            'alertasNames:text:Alertas Relacionadas'
        ],
    ]) ?>

<?php

    $lugar = $model->nombre;
    $mi_key = 'AIzaSyAuMzoOe4_RpKaEnoLvzcg2kV6h9fDJzII';
    $url = "https://www.google.com/maps/embed/v1/place?key=".$mi_key."&q=".$lugar;

?>

<iframe
  width="100%"
  height="550"
  frameborder="0" style="border:0"
  src=<?php echo $url; ?> allowfullscreen>
</iframe>

</div>
