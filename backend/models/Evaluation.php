<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Evaluation model
 * 
 * @property int $id
 * @property int $employee_id
 * @property int $evaluator_id
 * @property string $evaluation_date
 * @property string $period_start
 * @property string $period_end
 * @property float $overall_rating
 * @property string $comments
 * @property string $status
 */
class Evaluation extends ActiveRecord
{
    const STATUS_DRAFT = 'draft';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'evaluator_id', 'evaluation_date', 'period_start', 'period_end'], 'required'],
            [['employee_id', 'evaluator_id'], 'integer'],
            [['overall_rating'], 'number', 'min' => 0, 'max' => 5],
            ['status', 'in', 'range' => [self::STATUS_DRAFT, self::STATUS_SUBMITTED, self::STATUS_APPROVED, self::STATUS_REJECTED]],
            [['evaluation_date', 'period_start', 'period_end'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * Get employee
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    /**
     * Get evaluator
     */
    public function getEvaluator()
    {
        return $this->hasOne(Employee::class, ['id' => 'evaluator_id']);
    }

    /**
     * Get criteria
     */
    public function getCriteria()
    {
        return $this->hasMany(EvaluationCriterion::class, ['evaluation_id' => 'id']);
    }

    /**
     * Check if evaluation can be edited
     * 
     * @return bool
     */
    public function canEdit()
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_REJECTED]);
    }
}
