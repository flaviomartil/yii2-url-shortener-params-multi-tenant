<?php
/**
 *
 * Developed by Waizabú <code@waizabu.com>
 *
 *
 */

namespace eseperio\shortener;


use eseperio\shortener\models\Shortener;
use yii\base\Module;
use yii\db\Expression;
use yii\helpers\Url;


/**
 * Class ShortenerModule
 * @package eseperio\shortener
 */
class ShortenerModule extends Module
{

    /**
     *
     * Must have a lenght of 61
     * Default is ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789 in random order
     * @var string
     */
    public $options = "NkAXITYvw3iObfKEaoeCUxqm2Dnrugl9PthVSM8yc7GQdBJHW6Lz4ZsjR15pF";


    /**
     * @var array
     */
    public $urlConfig = [
        '<id:[\d\w]{16}>' => "/shortener/default/parse",
    ];

    /**
     * @param $id
     * @return mixed|string the url
     */
    public function expand($params,$searchId = false, $module = null)
    {
        if (isset($params['_csrf'])) {
            unset($params['_csrf']);
        }

        $query = $searchId ? ['shortened' => $params] : ['params' => json_encode($params)];
        $model = Shortener::find()
            ->where($query)
            ->one();
        return $model;
    }

    /**
     * @param $url      string|array It accepts any url format allowed by Yii2
     * @param $lifetime integer Time in seconds that the links must be available
     */
    public function short($url = null, $params = null, $module = null)
    {
        if (isset($params['_csrf'])) {
            unset($params['_csrf']);
        }

        $params = json_encode($params);
        $model = Shortener::find()
            ->where(['params' => $params])
            ->one();
        if (empty($model)) {
            $model = new Shortener();

            if (!empty ($params)) {
                $model->params = $params;
            }

            $model->use_module = !empty($module) ? $module : null;
            $model->url = $url;
            if ($model->save())
                return $model;

            return false;
        }

    }


    /**
     * @return string
     */
    public function getShortId()
    {
        return $this->generateShortId();
    }

    /**
     * Method to generate short id of url
     */
    private function generateShortId()
    {
        $uuid = \thamtech\uuid\helpers\UuidHelper::uuid();
         return $uuid;

    }
}
