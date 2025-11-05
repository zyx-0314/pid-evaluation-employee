<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * EvaluationCriterion model
 * 
 * @property int $id
 * @property int $evaluation_id
 * @property string $criterion_name
 * @property string $criterion_description
 * @property float $score
 * @property float $weight
 * @property string $comments
 */
class EvaluationCriterion extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluation_criteria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['evaluation_id', 'criterion_name'], 'required'],
            ['evaluation_id', 'integer'],
            [['score', 'weight'], 'number', 'min' => 0, 'max' => 5],
            ['criterion_name', 'string', 'max' => 100],
        ];
    }

    /**
     * Get evaluation
     */
    public function getEvaluation()
    {
        return $this->hasOne(Evaluation::class, ['id' => 'evaluation_id']);
    }
}
