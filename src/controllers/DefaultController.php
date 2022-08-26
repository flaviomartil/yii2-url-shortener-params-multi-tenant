<?php
/**
 *
 * Developed by Waizabú <code@waizabu.com>
 *
 *
 */

namespace eseperio\shortener\controllers;


use eseperio\shortener\ShortenerModule;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
/**
 * Class DefaultController
 * @package eseperio\shortener\controllers
 */
class DefaultController extends \yii\web\Controller
{


    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionParse($id)
    {
        $module = \Yii::$app->getModule('shortener');
        /* @var $module ShortenerModule */

        $model = $module->expand($id,true);

        if(!empty($model)) {
            \Yii::$app->request->setBodyParams(
                $model->params);
            list($first) = \Yii::$app->createController('reports/' . $model->use_module);
            return $first->actionIndex();
        }

        throw new NotFoundHttpException('Esse link não foi encontrado, por favor verifique o endereço digitado e tente novamente.');
    }
}
