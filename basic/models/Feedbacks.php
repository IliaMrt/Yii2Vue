<?php

namespace app\models;

use yii\db\Query;


abstract class Feedbacks extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $feedback;
    public $id_cafe;

    private static $feedbacks = [
        '1' => [
            'id' => '1',
            'feedback' => 'отлично',
            'cafe_id' => '1',
        ],
        '2' => [
            'id' => '2',
            'feedback' => 'отлично!',
            'cafe_id' => '1',
        ],
        '3' => [
            'id' => '3',
            'feedback' => 'отлично(((',
            'cafe_id' => '2',
        ],
    ];


    /**
     * {@inheritdoc}
     */


    public static function findByCafeId($cafeId)
    {
        return Comments::find()->select('text')->andWhere(['id_cafe' => $cafeId])->all();
    }

    public static function saveFeedback($feedback)
    {
        $res = new Comments($feedback);
        $res->save();
        return $res;
    }

    public static function feedbacksCount()
    {
        $res = (new Query())
            ->select(['id_cafe', 'count(*)'])
            ->from('comments')
            ->groupBy('id_cafe')
            ->all();
       return $res;
    }


}
