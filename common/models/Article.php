<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property integer $user_id
 * @property integer $category_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $source
 * @property integer $rating
 * @property integer $views
 * @property integer $status
 */
class Article extends \yii\db\ActiveRecord
{
    public $image;

    const STATUS_MODERATION = 1;
    const STATUS_PUBLIC = 2;
    const STATUS_DELETED = 0;

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_MODERATION => 'На проверке',
            self::STATUS_PUBLIC => 'Активная',
            self::STATUS_DELETED => 'Удалена',
        ];
    }

    /**
     * @param $status_id
     * @return mixed
     */
    public function getStatusName($status_id)
    {
        return self::getStatuses()[$status_id];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'created_at', 'status', 'category_id', 'body'], 'required'],
            [['user_id', 'category_id', 'rating', 'views', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['body'], 'string', 'max' => 1024],
            [['source'], 'string', 'max' => 512],
            [['status'], 'in', 'range' => array_keys(self::getStatuses())],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg']

        ];
    }

    /**
     * @param $id
     * @return string
     */
    public function getImagePath($id)
    {
        return Yii::getAlias('@upload') . '/article_images/' . $id . '.jpg';
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            $this->image->saveAs('uploads/article_images/' . $this->id . '.' . $this->image->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'body' => 'Body',
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'source' => 'Source',
            'rating' => 'Rating',
            'views' => 'Views',
            'status' => 'Status',
        ];
    }

    /**
     * @return ActiveDataProvider
     */
    public static function getArticles()
    {
        return $dataProvider = new ActiveDataProvider([
            'query' => self::find(),
        ]);
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->created_at = date("Y-m-d H:i:s");
        } else {
            $this->updated_at = date("Y-m-d H:i:s");
        }
        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}