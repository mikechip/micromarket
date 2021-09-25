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

        $post = $request->getPost();
        $order = ((int)$post->order) === 2 ? 'price' : 'id';
        $order_dir = (bool)$post->order_dir;

        foreach(Item::getAll(0, 100, $order, $order_dir) as $i) {
            if($i->id > $last_id) {
                $last_id = $i->id;
            }

            $result[] = [
                'id' => $i->id,
                'name' => $i->name ?? 'Без названия',
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
        $data = (new Validator())->sanitize(
            (array)$request->getPost()
        );

        if(!$data || !isset($data['name'])) {
            return $this->apiError($request, 400, 'Укажите имя товара');
        }

        try {
            $insert_id = Item::insert($data);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return $this->apiError($request, 500, 'Ошибка создания товара');
        }

        return $this->apiResponse($request, [
            'result' => $insert_id > 0, 'item_id' => $insert_id
        ]);
    }

    public function actionDelete(Request $request): Response
    {
        $id = (int)$request->getPost()->id;
        if($id <= 0) {
            return $this->apiError($request, 400, 'Не передан ID');
        }

        $item = Item::getById($id);
        if(!$item) {
            return $this->apiError($request, 404, 'Товар не найден');
        }

        return $this->apiResponse($request, ['result' => $item->remove()]);
    }
}
