<?php

declare(strict_types=1);

namespace app\services;

use app\models\ApiData;
use Yii;
use GuzzleHttp\Client;

class ApiService
{
    CONST COUNT_ITEMS_TO_STORE = 100;

    private $client;
    private $apiUrl;
    private $apiKey;
    private $countItemsProcessed = 0;
    private $process = true;
    private $dataToStore = [];

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = Yii::$app->params['apiUrl'];
        $this->apiKey = Yii::$app->params['apiKey'];
    }

    public function run()
    {
        $contentJson = $this->getContentJson();

        $page = $contentJson['page-count'];

        while ($this->process) {

            $contentJson = $this->getContentJson(['page' => $page]);

            $this->processItems($contentJson['items']);

            $page--;

            if ($page < 1)
                break;

        }

        $this->storeItems();
    }

    private function storeItems() : void
    {
        if (empty($this->dataToStore))
            throw new \Exception('No data to store');

        $model = new ApiData();
        $model->clearData();
        $model->batchSave($this->dataToStore);
    }

    private function processItems(array $items) : void
    {
        $items = array_reverse($items);

        foreach ($items as $item) {

            array_push($this->dataToStore, [
                'id' => $item['id'],
                'internal_id' => $item['internal_id'],
                'last_modify' => date('Y-m-d H:i:s', strtotime($item['last_modify'])),
                'regulator' => $item['regulator'],
             ]);

            $this->countItemsProcessed ++;

            if ($this->countItemsProcessed == self::COUNT_ITEMS_TO_STORE) {
                $this->process = false;
                break;
            }

        }

    }

    private function getContentJson(array $query = []) : array
    {
        $queryData['apiKey'] = $this->apiKey;

        if (!empty($query))
            $queryData = array_merge($queryData, $query);

        $response = $this->client->request('GET', $this->apiUrl, [
            'query' => $queryData
        ]);

        $code = $response->getStatusCode();

        if ($code != 200)
            throw new \Exception('Response code: ' . $code);

        $body = $response->getBody();
        return \GuzzleHttp\json_decode($body->getContents(), true);
    }

}