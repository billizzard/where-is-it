<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property integer $id
 * @property integer $place_id
 * @property integer $1_from
 * @property integer $1_to
 * @property integer $2_from
 * @property integer $2_to
 * @property integer $3_from
 * @property integer $3_to
 * @property integer $4_from
 * @property integer $4_to
 * @property integer $5_from
 * @property integer $5_to
 * @property integer $6_from
 * @property integer $6_to
 * @property integer $7_from
 * @property integer $7_to
 * @property string $ip
 * @property integer $parent_id
 *
 * @property Place $place
 */
class Schedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_id', '1_from', '1_to', '2_from', '2_to', '3_from', '3_to', '4_from', '4_to', '5_from', '5_to', '6_from', '6_to', '7_from', '7_to', 'parent_id'], 'integer'],
            [['ip'], 'string', 'max' => 50],
            [['place_id'], 'exist', 'skipOnError' => true, 'targetClass' => Place::className(), 'targetAttribute' => ['place_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'place_id' => 'Place ID',
            '1_from' => '1 From',
            '1_to' => '1 To',
            '2_from' => '2 From',
            '2_to' => '2 To',
            '3_from' => '3 From',
            '3_to' => '3 To',
            '4_from' => '4 From',
            '4_to' => '4 To',
            '5_from' => '5 From',
            '5_to' => '5 To',
            '6_from' => '6 From',
            '6_to' => '6 To',
            '7_from' => '7 From',
            '7_to' => '7 To',
            'ip' => 'Ip',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlace()
    {
        return $this->hasOne(Place::className(), ['id' => 'place_id']);
    }

    /**
     * @param $place_id
     * @return $this
     */
    public static function findByPlaceId($place_id)
    {
        return self::find()->andWhere('place_id = :place_id', [':place_id' => $place_id]);
    }

    public function getFormatSchedule()
    {
        $result = [];
        for ($i = 1; $i < 8; $i++) {
            $result[$i] = [];
            $valFrom = $this->{$i . '_from'};
            $valTo = $this->{$i . '_to'};
            if ($valFrom && $valTo) {
                $valF = $valFrom % 10000;
                $valT = $valTo % 10000;
                $hFrom = intval($valF/100);
                $mFrom = $valF % 100;
                $hTo = intval($valT/100);
                $mTo = $valT % 100;
            } else {
                $hFrom = $mFrom = $hTo = $mTo = null;
            }

            $result[$i] = [
                'hFrom' => $hFrom,
                'mFrom' => $mFrom,
                'hTo' => $hTo,
                'mTo' => $mTo
            ];

        }
        return $result;
    }
    
    public function fromPost($post)
    {
        for ($i = 1; $i < 8; $i++) {
            if (isset($post[$i . '_output'])) {
                $fromH = $toH = null;
            } else if (isset($post[$i . '_all'])) {
                $fromH = $i . '0000';
                $toH = ($i + 1) . '0000';
            } else {
                $fromH = $post[$i . '_from_h'] == -1 ? null : $post[$i . '_from_h'];
                $toH = $post[$i . '_to_h'] == -1 ? null : $post[$i . '_to_h'];
                $fromM = $post[$i . '_from_m'] == -1 ? '00' : $post[$i . '_from_m'];
                $toM = $post[$i . '_to_m'] == -1 ? '00' : $post[$i . '_to_m'];
                if ($fromH != null && $toH != null) {

                    if ((int)$fromH >= (int)$toH) {
                        $toH = ($i + 1) . $toH;
                    } else {
                        $toH = $i . $toH;
                    }
                    $fromH = $i . $fromH . $fromM;
                    $toH = $toH . $toM;
                } else {
                    $toH = null;
                    $fromH = null;
                }
            }

            $this->{$i . '_from'} = $fromH;
            $this->{$i . '_to'} = $toH;
        }

    }
    
}
