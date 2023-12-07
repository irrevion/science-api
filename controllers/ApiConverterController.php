<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use irrevion\science\Physics\Unit\Categories;
use irrevion\science\Physics\Entities\Quantity;
use app\helpers\Utils;


class ApiConverterController extends Controller {

	public function beforeAction($action='') {
		Yii::$app->controller->enableCsrfValidation = false;
		Yii::$app->response->headers->set('Access-Control-Allow-Origin', '*');
		Yii::$app->response->headers->set('Access-Control-Max-Age', '86400');
		return parent::beforeAction($action);
	}

	public function actionUnitCategories() {
		Yii::$app->response->format = 'json';

		$categories = array_keys(Categories::list);
		// $categories = array_map(fn($v) => Categories::camelCase($v), $categories);
		$categories = array_filter($categories, fn($v) => (count(array_unique(Categories::list[$v]))>1));
		sort($categories);

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

	public function actionConvert() {
		if (Yii::$app->request->isOptions) {
			Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
			Yii::$app->response->headers->set('Access-Control-Allow-Credentials', 'true');
			Yii::$app->response->headers->set('Access-Control-Allow-Headers', '*');
			Yii::$app->response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
			// Yii::$app->response->headers->set('Access-Control-Request-Method', 'POST');
			return '';
		}

		Yii::$app->response->format = 'json';

		if (!Yii::$app->request->isPost) {
			Yii::$app->response->statusCode = 404;
			return [
				'success' => false,
				'message' => 'Invalid method'
			];
		}

		$post = Utils::parseJsonRequest();
		$v = $post['value'];
		$from = $post['from'];
		$to = $post['to'];

		list($from_category, $from_unit) = explode('.', $from);
		$from = Categories::find($from_unit, $from_category);
		if (empty($from)) {
			Yii::$app->response->statusCode = 404;
			return [
				'success' => false,
				'message' => 'Invalid "from" unit'
			];
		}
		$x = new Quantity($v, $from);

		list($to_category, $to_unit) = explode('.', $to);
		$to = Categories::find($to_unit, $to_category);
		if (empty($to)) {
			Yii::$app->response->statusCode = 404;
			return [
				'success' => false,
				'message' => 'Invalid "to" unit'
			];
		}
		$y = $x->convert($to);

		return [
			'success' => true,
			'message' => 'Value successfully converted',
			'data' => [
				'result' => [
					'value' => $y->value,
					'measure' => $y->unit['measure'],
					'unit_system' => $y->unit['unit_system'],
					'descr' => $y->unit['descr'],
					'as_string' => "$y",
					'from_as_string' => "$x",
				]
			]
		];
	}
}
