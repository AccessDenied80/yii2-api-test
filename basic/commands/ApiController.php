<?php
declare(strict_types=1);
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\{
    Controller,
    ExitCode
};
use app\services\ApiService;

class ApiController extends Controller
{
    private ApiService $apiService;

    public function __construct($id, $module, ApiService $apiService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->apiService = $apiService;
    }

    public function actionRun()
    {
        try {
            $this->apiService->run();
        } catch (\Throwable $e) {
            echo PHP_EOL . $e->getMessage() . PHP_EOL;
            return ExitCode::DATAERR;
        }
        return ExitCode::OK;
    }
}
