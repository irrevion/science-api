<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\helpers\Utils;


class SiteController extends Controller {

	public function actionWelcome() {
		$this->layout = false;
		return $this->render('welcome');
	}

	public function actionError() {
		$exception = Yii::$app->errorHandler->exception;
		Yii::$app->response->format = 'json';
		$response = [
			'success' => false,
			'message' => 'Invalid endpoint',
			'code' => 404,
			'errors' => [
				((@YII_ENV=='dev')? (array) $exception: null)
			],
		];

		return $response;
	}
}

?>