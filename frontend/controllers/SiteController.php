<?php

namespace frontend\controllers;

use common\models\Items;
use common\models\LoginForm;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

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
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
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
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * @return string
     */
    public function actionIndex()
    {

        $jsonResultByQuery = $this->getItemsByQuery();

        $jsonResultBySqlQuery = $this->getItemsBySqlQuery();

        return $this->render('index',[
            'jsonResultByQuery' => $jsonResultByQuery,
            'jsonResultBySqlQuery' => $jsonResultBySqlQuery
        ]);
    }

    /**
     * @return array
     */
    public function getItemsBySqlQuery()
    {
        $startTime = microtime(true);

        $query = (new \yii\db\Query())
            ->select([
                'i.name',
                'i.category',
                'i.price',
                'i.currency',
                'ROUND(i.price * c.value, 2) AS priceRUB',
                'c.date AS dateCurrency',
            ])
            ->from(['i' => 'items'])
            ->join('JOIN', ['c' => 'currency'], 'i.currency = c.currency')
            ->where(['i.category' => 3])
            ->orderBy(['i.name' => SORT_ASC])
            ->limit(10);

        $query->cache(3600);

        $results = $query->all();

        $executionTime = microtime(true) - $startTime;

        $formattedResults = [
            'time' => $executionTime,
            'result' => $results,
        ];

        return $formattedResults;
    }

    /**
     * @return array
     */
    public function getItemsByQuery()
    {
        $startTime = microtime(true);

        $itemsQuery = (new Query())
            ->select(['name', 'category', 'price', 'currency'])
            ->from('items')
            ->where(['category' => 3])
            ->limit(10);

        $items = $itemsQuery->all();

        $currencyQuery = (new Query())
            ->select(['currency', 'value', 'date'])
            ->from('currency')
            ->orderBy(['date' => SORT_DESC])
            ->limit(1);

        $currency = $currencyQuery->one();

        $results = [];
        foreach ($items as $item) {
            $priceRUB = $item['price'] * $currency['value'];

            $results[] = [
                'name' => $item['name'],
                'category' => $item['category'],
                'price' => $item['price'],
                'currency' => $item['currency'],
                'priceRUB' => $priceRUB,
                'dateCurrency' => $currency['date'],
            ];
        }

        $executionTime = microtime(true) - $startTime;

        $formattedResults = [
            'time' => $executionTime,
            'result' => $results,
        ];

        return $formattedResults;
    }
}
