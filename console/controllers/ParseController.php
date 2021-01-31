<?php
namespace console\controllers;

use backend\models\Book;
use backend\models\BookCategoryList;
use backend\models\Category;
use igogo5yo\uploadfromurl\UploadFromUrl;
use yii\console\Controller;

class ParseController extends Controller
{
    /**
     * // yii parse/json https://gitlab.com/prog-positron/test-app-vacancy/-/raw/master/books.json
     * @param $link
     */
    public function actionJson($link)
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
            $checkExistBook = Book::checkExistBook($item["title"], $item["isbn"]);
            if ($checkExistBook) {
                continue;
            } else {
                $authors = str_replace(['"', ',', '[', ']'], ['', ', ', '', ''], json_encode($item["authors"]));

                $book = new Book();
                $book->title = $item["title"];
                $book->isbn = $item["isbn"];
                $book->pageCount = $item["pageCount"];
                $book->publishedDate = date(time(), strtotime($item["publishedDate"]["\$date"]));
//                $book->thumbnailUrl = $item["thumbnailUrl"];
                $book->shortDescription = $item["shortDescription"];
                $book->longDescription = $item["longDescription"];
                $book->status = $item["status"];
                $book->authors = $authors;
                if ($book->save(false)) {
                    //заполнение промежуточной таблицы с категориями
                    BookCategoryList::setBookCategoryList($item["categories"], $book->id);

                    //загрузка изображений
                    if ($item["thumbnailUrl"]){
                        $file = UploadFromUrl::initWithUrl($item["thumbnailUrl"]);
                        $book->uploadLinkImage($book->id, $file);
                    }
                }
            }
        }
    }

}