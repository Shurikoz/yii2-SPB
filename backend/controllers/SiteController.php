<?php

namespace backend\controllers;

use backend\models\Book;
use backend\models\BookCategoryList;
use backend\models\Category;
use backend\models\Feedback;
use common\models\LoginForm;
use igogo5yo\uploadfromurl\UploadFromUrl;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
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
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'feedback', 'parser'],
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
     * @param $link
     * @return string
     */
    public function actionParser($link)
    {
//        $link = 'https://gitlab.com/prog-positron/test-app-vacancy/-/raw/master/books.json';
//        $link = getcwd() . '\backend\web\books.json';
        $json = file_get_contents($link);
        $data = json_decode($json, true);

        //Создание категорий
        foreach ($data as $item) {
            Category::setCategory($item["categories"]);
        }

        //Запись книг в базу и создание категорий
        foreach ($data as $item) {
            //проверим существование книги по артикулу и заголовку
            //если запись существует, пропустим итерацию
            $title = isset($item["title"]) ? $item["title"] : '';
            $isbn = isset($item["isbn"]) ? $item["isbn"] : '';
            $checkExistBook = Book::checkExistBook($title, $isbn);
            if ($checkExistBook) {
                continue;
            } else {
                isset($item["authors"]) ? $authors = str_replace(['"', ',', '[', ']'], ['', ', ', '', ''], json_encode($item["authors"])) : $authors = '';

                $book = new Book();
                $book->title = isset($item["title"]) ? $item["title"] : '';
                $book->isbn = isset($item["isbn"]) ? $item["isbn"] : '';
                $book->pageCount = isset($item["pageCount"]) ? $item["pageCount"] : '';
                $book->publishedDate = isset($item["publishedDate"]) ? date(time(), strtotime($item["publishedDate"]["\$date"])) : '';
//                $book->thumbnailUrl = $item["thumbnailUrl"];
                $book->shortDescription = isset($item["shortDescription"]) ? $item["shortDescription"] : '';
                $book->longDescription = isset($item["longDescription"]) ? $item["longDescription"] : '';
                $book->status = isset($item["status"]) ? $item["status"] : '';
                $book->authors = $authors;
                if ($book->save(false)) {
                    //заполнение промежуточной таблицы с категориями
                    BookCategoryList::setBookCategoryList($item["categories"], $book->id);

                    //загрузка изображений
                    if (isset($item["thumbnailUrl"])){
                        $file = UploadFromUrl::initWithUrl($item["thumbnailUrl"]);
                        $book->uploadLinkImage($book->id, $file);
                    }
                }
            }
        }
        return $this->render('parser');
    }

    /**
     * Displays feedback page.
     *
     * @return string
     */
    public function actionFeedback()
    {
        $query = Feedback::find();
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('feedback', [
            'model' => $model,
            'pages' => $pages
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

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
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
