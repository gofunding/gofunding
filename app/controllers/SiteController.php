<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\TrsSuratMasuk;
use app\models\TrsSuratKeluar;
use app\modules\rekapitulasi\models\JumlahSurat;
use app\models\UserProfile;

class SiteController extends \app\modules\log\controllers\MainController
{

    public function afterAction($action, $result)
    {
        if ($action->id == 'login') {
            \app\modules\log\models\Login::saveLog($action);
        }

        return $result;
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
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
            //            'lang' => [
            //                'class' => 'app\components\actions\SetLocaleAction',
            //                'locales' => ['en-US', 'id-ID'],
            //            ]
        ];
    }

    public function actionLang()
    {
        if (isset($_GET['locale'])) {
            $language = $_GET['locale'];
            Yii::$app->language = $language;

            $languageCookie = new \yii\web\Cookie([
                'name' => 'locale',
                'value' => $language,
                'expire' => time() + 60 * 60 * 24 * 30, // 30 days
            ]);
            Yii::$app->response->cookies->add($languageCookie);
        }

        return Yii::$app->response->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main-without-container';

        $campaign = Yii::$app->db->createCommand('SELECT c.id, c.cover_image, c.judul_campaign, c.target_donasi, DATEDIFF(c.deadline, CURRENT_DATE()) deadline, up.is_community, up.nama_lengkap, c.terkumpul FROM campaign c LEFT JOIN `user_profile` up ON up.user_id = c.user_id WHERE c.is_active=2 AND c.deadline >= now() + 1 ORDER BY c.id DESC LIMIT 6')->queryAll();
        $reached = Yii::$app->db->createCommand('SELECT count(id) FROM campaign WHERE is_reached=1')->queryScalar();
        $sumDonasi = Yii::$app->db->createCommand('SELECT sum(donasi_bersih) + (SELECT sum(nominal_donasi) FROM donatur_offline) FROM donatur')->queryScalar();
        $sumUsers = Yii::$app->db->createCommand('SELECT count(user_id) FROM `user_profile` WHERE is_community = 1 OR is_community = 2')->queryScalar();

        return $this->render('index', [
                'campaign' => $campaign,
                'reached' => $reached,
                'sumDonasi' => $sumDonasi,
                'sumUsers' => $sumUsers
        ]);
    }

    /**
     * Signup action.
     *
     * @return Response|string
     */
    public function actionSignup()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect(Url::to('/site/signup-complete'));
        }

        return $this->render('signup', [
                'model' => $model,
        ]);
    }

    public function actionSignupComplete()
    {
        return $this->render('signup-complete');
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
//            Yii::$app->session->setFlash('success', 'Anda berhasil login');

            return $this->goBack();
        }

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
//        Yii::$app->session->setFlash('success', 'Anda berhasil logout');

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

    // Bantuan
    public function actionFaq()
    {
        return $this->render('faq');
    }

    public function actionBuatCampaign()
    {
        return $this->redirect('campaign/create');
        // return $this->render('buat-campaign');
    }

    public function actionNotificationPayment()
    {
        
    }
    //    public function actionFlushCache() {
    //        Yii::$app->cache->flush();
    //        Yii::$app->session->setFlash('success', Yii::t('app', 'Cache flushed'));
    //        return $this->redirect(Yii::$app->request->referrer);
    //    }
}
