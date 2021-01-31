<?php

namespace backend\models;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 * @property string|null $parent_id
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'parent_id'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['parent_id'], 'default',  'value' => null],
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
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * @param array $categoriesTitles
     * {@inheritdoc}
     */
    public static function setCategory($categoriesTitles)
    {
        if ($categoriesTitles){
            foreach ($categoriesTitles as $item){
                $checkExistCategory = Category::find()->where(['title' => $item])->one();
                if ($checkExistCategory){
                    continue;
                } else {
                    $category = new Category();
                    $category->title = $item;
                    $category->save();
                }
            }
        } else {
            $checkExistCategory = Category::find()->where(['title' => 'Новинки'])->one();
            if ($checkExistCategory){
                return true;
            } else {
                $category = new Category();
                $category->title = 'Новинки';
                $category->save();
            }
        }
        return true;
    }

}
