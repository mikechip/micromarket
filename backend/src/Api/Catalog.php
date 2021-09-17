<?php

namespace App\Api;

use Framework\Rest\EndpointController;
use Framework\Web\Request;
use Framework\Web\Response;

final class Catalog extends EndpointController
{
    // @todo
    public function actionList(Request $request): Response
    {
        return $this->apiResponse($request, ['count' => 1, 'list' => [
            [
                'id' => 1,
                'title' => 'Dummy Item',
                'desc' => 'Lorem ipsum dolor sit amet',
                'price' => rand(0, 2500),
                'image_url' => '/favicon.ico',
                'test' => 0,
            ]
        ]]);
    }

    // @todo
    public function actionItem(Request $request): Response
    {
        return $this->apiResponse($request, ['item' => [
            'id' => 1,
            'title' => 'Dummy Item',
            'desc' => 'Lorem ipsum dolor sit amet',
            'price' => rand(0, 2500),
            'image_url' => '/logo512.png'
        ]]);
    }

    // @todo
    public function actionEdit(Request $request): Response
    {
        return $this->apiResponse($request, ['result' => false]);
    }

    // @todo
    public function actionCreate(Request $request): Response
    {
        return $this->apiResponse($request, ['result' => null, 'item_id' => 0]);
    }

    // @todo
    public function actionDelete(Request $request): Response
    {
        return $this->apiResponse($request, ['result' => null]);
    }
}
