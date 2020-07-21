<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\RetrievePasswordForm;
use app\models\Users;

class SiteController extends Controller
{

    public $successUrl = 'success';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
              ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegister()
    {
        
        $model = new SignupForm();

        if(isset($_POST['SignupForm'])) {
            $model->attributes = Yii::$app->request->post('SignupForm');

            if( $model->validate()) {
                if($model->createNewUser()) {
                    Yii::$app->session->setFlash('good', 'Thank you for registration');
                    return $this->goHome();
                } else if($model->createNewUser() == 0) {
                    Yii::$app->session->setFlash('exist', 'User with this nickname already exists.');
                }
            } else {
                    Yii::$app->session->setFlash('bad', 'Error during registration');
            }
        }

        return $this->render('register', compact('model'));
    }

    public function oAuthSuccess($client) {

        $userAttributes = $client->getUserAttributes();
        
        $user = \app\models\User::find()->where(['username'=>$userAttributes['id']])->one();
        if(!empty($user)) {
            Yii::$app->user->login($user);
            
        } else {
            $model = new SignupForm();
            if(array_key_exists('name', $userAttributes)) {
                $model->email = $userAttributes['email'];
                $model->displayname = $userAttributes['name']; 
            } else {
                $model->displayname = $userAttributes['first_name'].' '.$userAttributes['last_name'];
            }
            
            $model->attributes = $userAttributes;
            $model->username = $userAttributes['id'];
            if($model->createNewUser()) {
               
                Yii::$app->user->login(\app\models\User::find()->where(['username'=>$userAttributes['id']])->one());
            }
        }
    }

    public function actionRetrievePassword()
    {

        $model = new RetrievePasswordForm();
        if(isset($_POST['RetrievePasswordForm'])) {
            $model->attributes = Yii::$app->request->post('RetrievePasswordForm');
            if((Users::findOne(['email' => $model->email]))) {
                if($model->sentEmail($model->email)) {
                    Yii::$app->session->setFlash('Good2', 'Recovery email sent successfully');
                    return $this->goHome();
                }
            } else {
                Yii::$app->session->setFlash('Error2', 'Wrong E-mail');
                return $this->refresh();
            }
        }
        return $this->render('retrieve-password', compact('model'));
    }


    public function actionPasswordResetting()
    {

        $model = new RetrievePasswordForm();
        $model->attributes = Yii::$app->request->post('RetrievePasswordForm');
        $model->email = Yii::$app->request->get('email');

        if($model->validate()) {
            $model->setNewPassword();
            return $this->refresh();
        }

        return $this->render('password-resetting', compact('model'));

    }

}
