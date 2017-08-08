<?php

namespace backend\modules\movie\controllers;

use backend\modules\movie\models\Movie;
use Yii;
use backend\modules\movie\models\FilmProperty;
use backend\modules\movie\models\search\FilmPropertySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FilmPropertyController implements the CRUD actions for FilmProperty model.
 */
class FilmPropertyController extends Controller
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
        ];
    }

    /**
     * Lists all FilmProperty models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FilmPropertySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FilmProperty model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FilmProperty model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FilmProperty();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FilmProperty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FilmProperty model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FilmProperty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FilmProperty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FilmProperty::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * add or delete properties for movie,single movie can have single or multiple properties
     * @param integer $movie_id from table `movie`
     *        integer $property_id from model FilmProperty's constant
     * @throws
     * */
    public function actionSetProperty()
    {

        $movie_id = Yii::$app->request->post('movie_id');
        $property_id = Yii::$app->request->post('property_id');
        $motion = Yii::$app->request->post('motion');
        FilmProperty::validateProperty($property_id);
        Movie::findOneOrException(['id' => $movie_id]);

        $res = FilmProperty::findOne(['movie_id' => $movie_id, 'property' => $property_id]);

        if ($motion == 'add') {

            if ($res) {
                $res->status = FilmProperty::STATUS_NORMAL;
                $res->sequence = 0;
                $res->save();
                return '添加成功';
            } else {
                $filmProperty = new FilmProperty();
                $filmProperty->movie_id = $movie_id;
                $filmProperty->property = $property_id;
                $filmProperty->sequence = 0;
                $filmProperty->save();
                return '添加成功';
            }
        }else{
            if($motion == 'delete'){
                if($res){
                    if($res->sequence != 0) {
                        $frontRows = FilmProperty::find()->where(['>', 'sequence', $res->sequence])->andWhere(['property' => $res->property])->all();

                        foreach ($frontRows ? $frontRows : [] as $eachRow) {
                            $eachRow->sequence -= 1;
                            $eachRow->save();
                        }
                    }
                    $res->delete();
//                    $res->sequence = 0;
//                    $res->save();
                    return '删除成功';
                }else{
                    return '此电影无此属性';
                }
            }
            return '移动失败';
        }
    }

    /*
     * adjust the order of movie's property
     * @params string motion (up/down) moving direction
     *         int property_id from table film_property's id
     * @throws 404 NOT FOUND(if property_id is not exists in film_property)
     * @return json
     * */
    public function actionSetSequence(){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $motion = Yii::$app->request->post('motion');
        $property_id = Yii::$app->request->post('property_id');

        $property = FilmProperty::findOneOrException(['id' => $property_id]);
        if($motion == 'up'){
            if($property->sequence) {
                $upProperty = FilmProperty::getGtSequenceItems($property->property,$property->sequence)[0];
                $tempSequence = $upProperty->sequence;
                $upProperty->sequence = $property->sequence;
                $property->sequence = $tempSequence;
                $property->save();
                $upProperty->save();
            }else{
                $res = FilmProperty::getHaveSequenceItems($property->property);
                foreach($res?$res:[] as $eachProperty){
                    $eachProperty->sequence = $eachProperty->sequence + 1;
                    $eachProperty->save();
                }
                $property->sequence = 1;
                $property->save();
            }
            return true;
        }else{
            if($motion == 'down'){
                if($property->sequence > 1) {
                    $upProperty = FilmProperty::getLtSequenceItems($property->property,$property->sequence)[0];
                    $tempSequence = $upProperty->sequence;
                    $upProperty->sequence = $property->sequence;
                    $property->sequence = $tempSequence;
                    $property->save();
                    $upProperty->save();
                    return true;
                }else{
                    return false;   // return ['text' => '此电影序列为1,无法下移'];
                }
            }
            return false;   //return ['text' => '无此运动轨迹'];
        }
    }

    /*
    * 快速修改电影顺序
    * */
    public function actionQuickChangeSequence($propertyId){

        if(\Yii::$app->request->isPost){
            $sequence = Yii::$app->request->post('sequence');
            $model = FilmProperty::findOne(['id' => $propertyId]);
            //如果设置的位置有重复,新元素顺延一位,前面的元素不变,后面的元素位置顺延
            $properties = FilmProperty::getHaveSequenceItems($model->property);
            $maxSequence = FilmProperty::getSequenceMax($model->property);
            $i = 0;

            if(!$model->sequence) {
                foreach ($properties as $eachProperty) {
                    $eachPropertySequence = $maxSequence - $eachProperty->sequence + 1;
                    if ($eachPropertySequence < $sequence) {
                        $eachProperty->sequence++;
                        $eachProperty->save();
                    }
                }
                $maxSequence = FilmProperty::getSequenceMax($model->property);
                $model->sequence = $maxSequence - $sequence + 1;
                $model->save();
            }else{
                //从下往上升
                if($sequence < ($maxSequence - $model->sequence + 1)){
                    foreach ($properties as $eachProperty) {
                        $eachPropertySequence = $maxSequence - $eachProperty->sequence + 1;
                        if ($eachPropertySequence >= $sequence && $eachPropertySequence < ($maxSequence - $model->sequence + 1)) {
                            $eachProperty->sequence --;
                            $eachProperty->save();
                        }
                    }
                }else{

                    foreach ($properties as $eachProperty) {
                        $eachPropertySequence = $maxSequence - $eachProperty->sequence + 1;
                        if ($eachPropertySequence <= $sequence && $eachPropertySequence > ($maxSequence - $model->sequence  + 1)) {
                            $eachProperty->sequence ++;
                            $eachProperty->save();
                        }
                    }
                }
                $model->sequence = ($maxSequence - $sequence + 1)?($maxSequence - $sequence + 1):1;
                $model->save();
            }

        return true;
            //如果设置的位置没有,比最大值大,重新排序,最大值为新设置的属性,剩下的不变
            //如果设置的位置没有,比最小值小,其他元素加1,新设置的元素垫底
        }else {
            $model = FilmProperty::findOne($propertyId);
            return $this->renderAjax('quick_change_sequence', [
                'sequence' => $model->sequence,
                'propertyId' => $propertyId,
            ]);
        };
    }
}
