<?php 
namespace frontend\controllers;
use Yii;

use common\models\Category;
use common\models\Newsletter;
use common\models\Brand;


class NewsletterController extends \frontend\components\BaseController
{
	public function actionSubscribe($item = FALSE)
	{
		$email = Yii::$app->request->post('email');
		$search = ['email' => $email];
		if($item){
			$brand = Brand::find()->where(['id' => $item])->one();
			if(!$brand){
				throw new \yii\web\NotFoundHttpException();
			}
			$search['brand'] = $item;
		}else{
			$search['brand'] = 0;
		}

		$check = Newsletter::find()->where($search)->one();

		if(!$check){
			$subscriber = new Newsletter();
			$subscriber->email = $email;
			if($item){
				$subscriber->brand = $item;
			}else{
				$subscriber->brand = 0;
			}

			$subscriber->save();
			Yii::$app->session->setFlash('success','Subscription Successfull, please check your mail to confirm the subscribtion');
		}else{
			if($check->status == 0){
				Yii::$app->session->setFlash('error','We already sent newsletter registration on your email, please check your email');
			}else{
				Yii::$app->session->setFlash('error','You already a subsceriber');
			}
			return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
		}

		return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
	}


	private function __send_email($email){
		
	}

}

