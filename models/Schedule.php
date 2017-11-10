<?php

namespace app\models;

use app\constants\AppConstants;
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
 * @property integer $status
 * @property boolean is_deleted
 * @property Place $place
 */
class Schedule extends BaseSubPlacesModel
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
            [['place_id', '1_from', '1_to', '2_from', '2_to', '3_from', '3_to', '4_from', '4_to', '5_from', '5_to', '6_from', '6_to', '7_from', '7_to', 'parent_id', 'status'], 'integer'],
            [['ip'], 'string', 'max' => 50],
            [['is_deleted'], 'boolean'],
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
            'status' => 'Статус',
            'is_deleted' => 'Удалено ли',
        ];
    }

    public function getFormatSchedule()
    {
        $result = [];
        for ($i = 1; $i < 8; $i++) {
            $result[$i] = [];
            $valFrom = $this->{$i . '_from'};
            $valTo = $this->{$i . '_to'};
            if ($valFrom && $valTo) {
                $valF = substr($valFrom, 1);
                $valT = substr($valTo, 1);
                $hFrom = substr_replace($valF, ":", 2, 0);
                $hTo = substr_replace($valT, ":", 2, 0);
            } else {
                $hFrom = $hTo = null;
            }

            $result[$i] = [
                'hFrom' => $hFrom,
                'hTo' => $hTo,
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
                $from = explode(':', $post[$i . '_from_h']);
                $to = explode(':', $post[$i . '_to_h']);
                $fromH = isset($from[0]) ? $from[0] : null;
                $fromM = isset($from[1]) ? $from[1] : null;
                $toH = isset($to[0]) ? $to[0] : null;
                $toM = isset($to[1]) ? $to[1] : null;

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
