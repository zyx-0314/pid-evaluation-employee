<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Employee model
 * 
 * Clean code: Clear naming and single responsibility
 * 
 * @property int $id
 * @property string $employee_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $position
 * @property string $department
 * @property string $hire_date
 */
class Employee extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employees';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'first_name', 'last_name', 'email'], 'required'],
            ['email', 'email'],
            ['employee_id', 'unique'],
            [['position', 'department'], 'string', 'max' => 100],
            ['hire_date', 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * Get full name
     * 
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get evaluations for this employee
     */
    public function getEvaluations()
    {
        return $this->hasMany(Evaluation::class, ['employee_id' => 'id']);
    }

    /**
     * Get user account
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['employee_id' => 'id']);
    }
}
