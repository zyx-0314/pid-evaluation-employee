<?php

namespace app\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use app\models\Employee;

/**
 * Employee API Controller
 * 
 * RESTful API for employee management
 * Clean code: Clear separation of API logic
 */
class EmployeeController extends Controller
{
    /**
     * Configure response format as JSON
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
     * List all employees
     * 
     * GET /api/employees
     * 
     * @return array
     */
    public function actionIndex()
    {
        $employees = Employee::find()
            ->select(['id', 'employee_id', 'first_name', 'last_name', 'email', 'position', 'department'])
            ->orderBy(['id' => SORT_ASC])
            ->asArray()
            ->all();

        return [
            'success' => true,
            'data' => $employees,
            'count' => count($employees),
        ];
    }

    /**
     * Get single employee
     * 
     * GET /api/employees/:id
     * 
     * @param int $id
     * @return array
     */
    public function actionView($id)
    {
        $employee = Employee::findOne($id);
        
        if (!$employee) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Employee not found',
            ];
        }

        return [
            'success' => true,
            'data' => [
                'id' => $employee->id,
                'employee_id' => $employee->employee_id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'full_name' => $employee->getFullName(),
                'email' => $employee->email,
                'position' => $employee->position,
                'department' => $employee->department,
                'hire_date' => $employee->hire_date,
            ],
        ];
    }

    /**
     * Create new employee
     * 
     * POST /api/employees
     * 
     * @return array
     */
    public function actionCreate()
    {
        $employee = new Employee();
        $employee->attributes = Yii::$app->request->post();

        if ($employee->save()) {
            Yii::$app->response->statusCode = 201;
            return [
                'success' => true,
                'message' => 'Employee created successfully',
                'data' => ['id' => $employee->id],
            ];
        }

        Yii::$app->response->statusCode = 422;
        return [
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $employee->errors,
        ];
    }
}
