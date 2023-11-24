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
}
