<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title
 * @property string $isbn
 * @property string|null $pageCount
 * @property string|null $publishedDate
 * @property string|null $thumbnailUrl
 * @property string|null $shortDescription
 * @property string|null $longDescription
 * @property int $status
 * @property string $authors
 * @property $fileImage
 *
 */
class Book extends \yii\db\ActiveRecord
{

    public $fileImage;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'isbn', 'status', 'authors'], 'required'],
            [['shortDescription', 'longDescription'], 'string'],
            [['status', 'isbn', 'pageCount'], 'integer'],
            [['title', 'isbn', 'pageCount', 'publishedDate', 'thumbnailUrl', 'authors'], 'string', 'max' => 255],
            [['fileImage'], 'image',
                'extensions' => ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'PNG'],
                'checkExtensionByMimeType' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'isbn' => 'Isbn',
            'pageCount' => 'Page Count',
            'publishedDate' => 'Published Date',
            'thumbnailUrl' => 'Thumbnail Url',
            'shortDescription' => 'Short Description',
            'longDescription' => 'Long Description',
            'status' => 'Status',
            'authors' => 'Authors',
        ];
    }

    /**
     * {@inheritdoc}
     * Загрузка изображения из формы
     */
    public function uploadImage($book_id)
    {
        if ($this->validate()) {
            $dir = 'uploads/book/' . $book_id;
            $this->checkDir($dir);
            $path = $dir . '/' . $this->fileImage->baseName . '.' . $this->fileImage->extension;
            $this->fileImage->saveAs($path);
            $this->thumbnailUrl = $path;
            $this->save(false);
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     * Загрузка изображения по ссылке
     */
    public function uploadLinkImage($book_id, $file)
    {
        $dir = getcwd() . '/backend/web/uploads/book/' . $book_id;
        $this->checkDir($dir);
        $filePath = $dir . '/' . $file->baseName . '.' . $file->extension;
        $path = 'uploads/book/' . $book_id . '/' . $file->baseName . '.' . $file->extension;
//        echo $filePath . PHP_EOL;
        $file->saveAs($filePath);
        $this->thumbnailUrl = $path;
        $this->save(false);
        return true;
    }

    /**
     * @param $visitId
     * @param $dir
     */
    private function checkDir($dir){
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    /**
     * функция для удаления фотографии
     * @param $id
     */
    public static function delPhoto($id)
    {
        $dir = Yii::getAlias('@webroot/uploads/book/') . $id;
        if (file_exists($dir)) {
            foreach (glob($dir . '/*') as $file) {
                unlink($file);
            }
        }
        rmdir($dir);
    }

    /**
     * функция проверки существования книги по артикулу и заголовку
     * @param $title
     * @param $isbn
     * @return bool
     */
    public static function checkExistBook($title, $isbn)
    {
        $checkExistBook = Book::find()->where(['title' => $title])->andWhere(['isbn' => $isbn])->one();
        if ($checkExistBook) {
            return true;
        } else {
            return false;
        }
    }



}
