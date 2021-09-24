<?php

namespace App\Api;

use App\Model\Item;
use App\Validator\Item as Validator;
use Framework\Rest\EndpointController;
use Framework\Web\Request;
use Framework\Web\Response;

final class Catalog extends EndpointController
{
    public function actionList(Request $request): Response
    {
        $result = [];
        $count = Item::count();
        $last_id = -1;

        foreach(Item::getAll() as $i) {
            if($i->id > $last_id) {
                $last_id = $i->id;
            }

            $result[] = [
                'id' => $i->id,
                'title' => $i->title ?? 'Без названия',
                'desc' => $i->desc ?? '',
                'price' => $i->price ?? 0,
                'image_url' => $i->image_url ?? ''
            ];
        }

        return $this->apiResponse($request, [
            'count' => $count, 'list' => $result, 'offset' => $last_id
        ]);
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

    public function actionDelete(Request $request): Response
    {
        $id = (int)$request->getPost()->id;
        if($id <= 0) {
            return $this->apiError($request, 400, 'Item id is not passed');
        }

        $item = Item::getById($id);
        if(!$item) {
            return $this->apiError($request, 404, 'Item not found');
        }

        return $this->apiResponse($request, ['result' => $item->remove()]);
    }
}
