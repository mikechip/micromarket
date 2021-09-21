<?php

namespace App\Api;

use App\Model\Item;
use Framework\Rest\EndpointController;
use Framework\Web\Request;
use Framework\Web\Response;

final class Catalog extends EndpointController
{
    public function actionList(Request $request): Response
    {
        $result = [];
        $count = 0;

        foreach(Item::getAll() as $i) {
            $count++;

            $result[] = [
                'id' => $i->id,
                'title' => $i->title ?? 'Без названия',
                'desc' => $i->desc ?? '',
                'price' => $i->price ?? 0,
                'image_url' => $i->image_url ?? ''
            ];
        }

        return $this->apiResponse($request, ['count' => $count, 'list' => $result]);
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
