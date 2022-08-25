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
            \Yii::$app->session->set($model->use_module,$model->params);
            return $this->redirect($model->url);
        }

        throw new NotFoundHttpException();
    }
}
