<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use irrevion\science\Physics\Unit\Categories;
use app\helpers\Utils;


class ApiConverterController extends Controller {

	public function actionUnitCategories() {
		Yii::$app->response->format = 'json';

		$categories = array_keys(Categories::list);

		$response = [
			'success' => true,
			'message' => 'Categories list retrieved.',
			'data' => [
				'categories' => $categories
			],
		];

		return $response;
	}

	public function actionGetDocument() {
		$message_uid = Yii::$app->request->get('message_uid');
		$document_name = Yii::$app->request->get('document_name');
		$filepath = 'documents/originals/test/'.$message_uid.'_'.$document_name;

		Yii::$app->response->format = 'raw';

		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.rawurlencode($document_name).'"');
		header('Content-Length: '.filesize($filepath));
		header('Content-Transfer-Encoding: binary');

		readfile($filepath);

		return '';
	}
}
