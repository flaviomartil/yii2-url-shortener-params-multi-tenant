<?php
/**
 *
 * Developed by Waizabú <code@waizabu.com>
 *
 *
 */

namespace eseperio\shortener\models;

use eseperio\shortener\ShortenerModule;
use yii\behaviors\SluggableBehavior;
use Yii;

/**
 * This is the model class for table "yii2_shortener".
 *
 * @property int $id
 * @property string $url
 * @property string $shortened
 */
class Shortener extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Yii::$app->params['databaseSchema']. '.encurtador_link';
    }

    /**
     * @param $event
     * @return string
     */
    public static function getSlugValue($event)
    {
        $module = \Yii::$app->getModule('shortener');

        /* @var $module ShortenerModule */
        return $module->getShortId();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_on'], 'integer'],
            [['url'], 'string'],
            [['shortened'], 'string', 'max' => 16],
            [['use_module'], 'string'],
            [['shortened'], 'unique'],
            [['params'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'shortened' => 'Shortened',
            'params' => "Parameters"
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::class,
                'slugAttribute' => 'shortened',
                'ensureUnique' => true,
                'value' => [$this, 'getSlugValue']
            ]
        ];
    }
}
