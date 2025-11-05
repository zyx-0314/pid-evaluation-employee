<?php

namespace app\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use app\models\Evaluation;

/**
 * Evaluation API Controller
 * 
 * RESTful API for evaluation management
 */
class EvaluationController extends Controller
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
     * List all evaluations
     * 
     * GET /api/evaluations
     * 
     * @return array
     */
    public function actionIndex()
    {
        $evaluations = Evaluation::find()
            ->with(['employee', 'evaluator'])
            ->orderBy(['evaluation_date' => SORT_DESC])
            ->all();

        $data = [];
        foreach ($evaluations as $evaluation) {
            $data[] = [
                'id' => $evaluation->id,
                'employee' => $evaluation->employee ? $evaluation->employee->getFullName() : null,
                'evaluator' => $evaluation->evaluator ? $evaluation->evaluator->getFullName() : null,
                'evaluation_date' => $evaluation->evaluation_date,
                'period_start' => $evaluation->period_start,
                'period_end' => $evaluation->period_end,
                'overall_rating' => $evaluation->overall_rating,
                'status' => $evaluation->status,
            ];
        }

        return [
            'success' => true,
            'data' => $data,
            'count' => count($data),
        ];
    }

    /**
     * Get single evaluation
     * 
     * GET /api/evaluations/:id
     * 
     * @param int $id
     * @return array
     */
    public function actionView($id)
    {
        $evaluation = Evaluation::find()
            ->where(['id' => $id])
            ->with(['employee', 'evaluator', 'criteria'])
            ->one();
        
        if (!$evaluation) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Evaluation not found',
            ];
        }

        $criteria = [];
        foreach ($evaluation->criteria as $criterion) {
            $criteria[] = [
                'id' => $criterion->id,
                'criterion_name' => $criterion->criterion_name,
                'criterion_description' => $criterion->criterion_description,
                'score' => $criterion->score,
                'weight' => $criterion->weight,
                'comments' => $criterion->comments,
            ];
        }

        return [
            'success' => true,
            'data' => [
                'id' => $evaluation->id,
                'employee' => [
                    'id' => $evaluation->employee->id,
                    'name' => $evaluation->employee->getFullName(),
                    'employee_id' => $evaluation->employee->employee_id,
                ],
                'evaluator' => [
                    'id' => $evaluation->evaluator->id,
                    'name' => $evaluation->evaluator->getFullName(),
                ],
                'evaluation_date' => $evaluation->evaluation_date,
                'period_start' => $evaluation->period_start,
                'period_end' => $evaluation->period_end,
                'overall_rating' => $evaluation->overall_rating,
                'comments' => $evaluation->comments,
                'status' => $evaluation->status,
                'criteria' => $criteria,
                'can_edit' => $evaluation->canEdit(),
            ],
        ];
    }
}
