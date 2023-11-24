<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\helpers\Utils;


class ApiConverterController extends Controller {

	public function actionUnitCategories() {
		Yii::$app->response->format = 'json';

		$response = [
			'success' => true,
			'message' => 'Messages list retrieved.',
			'data' => [
				'messages' => [
					0 => [
						'uid' => 'KS7G7F6G8215C56C07579',
						'department' => 'Çağrı mərkəzi',
						'departmentCode' => 'KS7G7F6',
						'type' => null,
						'subject' => 'Mock message 001',
						'messageText' => "This is test of mock messages import...\n\nThat's it.",
						'sentAt' => '2020-09-27 08:13:54',
						'documents' => ['Sənəd qəbulu şöbəsi.pdf', 'Önəmli hesabatlar №7.png']
					]
				],
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
