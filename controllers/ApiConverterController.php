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

	public function actionUnitsByCategory($category) {
		Yii::$app->response->format = 'json';

		$categories = array_keys(Categories::list);
		if (in_array($category, $categories)) {
			$units = Categories::list[$category];
			$units = array_values($units);
			$units = array_unique($units);
			sort($units);
			$units = array_map(fn($v) => ltrim(strrchr($v, '\\'), '\\'), $units);
		} else {
			Yii::$app->response->statusCode = 404;
			return [
				'success' => false,
				'message' => 'Invalid category'
			];
		}

		$response = [
			'success' => true,
			'message' => 'Units list retrieved.',
			'data' => [
				'units' => $units
			],
		];

		return $response;
	}
}
