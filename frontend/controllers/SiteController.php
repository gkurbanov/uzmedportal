<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
        ];
    }

    public function debug($arr)
    {
        echo '<pre>' . print_r($arr, true) . '</pre>';
    }

    public function language()
    {
        return Yii::$app->language; //текущий язык
    }

    public function setSeo($title = null, $keywords = null, $description = null, $ogTitle = null, $ogImage = null, $ogUrl = null){
        $this->view->title = $title;
        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'name', 'name'=>'description', 'content'=> $description]);
        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'name', 'name'=>'keywords', 'content'=> $keywords]);
        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'property', 'property'=>'og:type', 'content'=> 'website']);
        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'property', 'property'=>'og:locale', 'content'=> 'ru_RU']);
        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'property', 'property'=>'og:locale', 'content'=> 'ru_RU']);


        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'property', 'property'=>'og:description', 'content'=> $description]);
        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'property', 'property'=>'og:title', 'content'=> $ogTitle]);
        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'property', 'property'=>'og:url', 'content'=> $ogUrl]);
        $this->view->registerMetaTag(['property'=>'og:site_name', 'content'=> 'AydaTuda.uz']);
        $this->view->registerMetaTag(['property'=>'og:image', 'content'=> $ogImage]);
        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'property', 'property'=>'og:image', 'content'=> $ogImage]);
        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'property', 'property'=>'og:image:width', 'content'=> '1200']);
        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'property', 'property'=>'og:image:height', 'content'=> '630']);

        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'name', 'name' => 'twitter:card', 'content'=> 'summary_large_image']);
        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'name', 'name' =>'twitter:image', 'content'=> $ogImage]);
        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'property', 'property' => 'vk:image', 'content'=> $ogImage]);
        $this->view->registerMetaTag(['class' => 'meta-tag', 'data-type' => 'property', 'property' => 'fb:image', 'content'=> $ogImage]);
    }

    public function getArchieve($table_name)
    {

        // месяцы на русском языке
        $months = ['Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];


        $archieve = (new \yii\db\Query())
            ->select(['id', 'year', 'count(month) as mnt_count', 'month'])
            ->from($table_name)
            ->where(['is_active' => '1'])
            ->groupBy(["month", "year"])
            ->all();

        $items = array();
        $year = -1;
        foreach ($archieve as $item) {

            array_push($items, array(
                "year" => $item["year"],
                "months" => $item["month"],
                "month_qty" => $item["mnt_count"],
                "month_name" => $months[$item["month"] - 1]
            ));
        }

        return $this->array_group($items, "year");

    }

    function array_group(array $data, $by_column)
    {
        $result = [];
        foreach ($data as $item) {
            $column = $item[$by_column];
            unset($item[$by_column]);
            $result[$column][] = $item;
        }
        return $result;
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index');
    }


    public function actionTestDiploma(){
        $client = new Client();

        $response = [];
        try{
            $request = $client->post('https://api.tipme.uz/api/get-special-doctor', [
                'json' => [
                    'username' => 'api_doctor_special',
                    'password' => '34rt_td_tipmedf3423',
                    'diplom' => 'B1060103'
                ]
            ]);
            $response = $request->getBody()->getContents();
        }catch (ClientException $exception){
            $response = $exception->getResponse()->getBody();
        }

        $this->debug($response);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionParseInternist(){
        $url = "https://internist.ru/publications/rss/"; // url to parse
        $rss = simplexml_load_file($url); // XML parser

        foreach($rss->channel->item as $item) {
            $this->debug($item);
        }
    }


}
