<?php

namespace backend\models;

/**
 * This is the model class for table "book_category_list".
 *
 * @property int $id
 * @property string $category_id
 * @property string $book_id
 */
class BookCategoryList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_category_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'book_id'], 'required'],
            [['category_id', 'book_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'book_id' => 'Book ID',
        ];
    }

    /**
     * @param array $title
     * @param $book_id
     * {@inheritdoc}
     */
    public static function setBookCategoryList($categories, $book_id)
    {
        if ($categories) {
            foreach ($categories as $item) {
                if ($item) {
                    $category = Category::find()->where(['title' => $item])->one();
                } else {
                    $category = Category::find()->where(['title' => 'Новинки'])->one();
                }
                BookCategoryList::saveBookCategoryList($category->id, $book_id);
            }
        } else {
            $category = Category::find()->where(['title' => 'Новинки'])->one();
            BookCategoryList::saveBookCategoryList($category->id, $book_id);
        }
    }

    private static function saveBookCategoryList($category_id, $book_id)
    {
        $bookCategoryList = new BookCategoryList();
        $bookCategoryList->book_id = $book_id;
        $bookCategoryList->category_id = $category_id;
        $bookCategoryList->save(false);
    }

}
