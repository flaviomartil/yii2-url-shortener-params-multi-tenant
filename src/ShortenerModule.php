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
        '<id:[\d\w]{4}>' => "/shortener/default/parse",
    ];

    /**
     * @param $id
     * @return mixed|string the url
     */
    public function expand($params,$searchId = false, $module = null)
    {
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
    public function short($params = null, $module = null)
    {
        $params = json_encode($params);
        $model = Shortener::find()
            ->where(['params' => $params])
            ->one();
        if (empty($model)) {
            $model = new Shortener();

//            $model->setAttributes([
//                'url' => Url::to($url),
//            ]);

            if (!empty ($params)) {
                $model->params = $params;
            }

            $model->use_module = !empty($module) ? $module : null;

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
        $monthYear = +date('y') + +date('n');
        $dayHour = +date('j') + +date('G');
        $id = [
            $this->options[$monthYear],
            $this->options[$dayHour],
            $this->options[+date('s')],
            $this->options[+date('i')],
        ];

        return join("", $id);


    }
}
