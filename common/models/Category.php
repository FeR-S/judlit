<?php

namespace common\models;

use yii\db\ActiveRecord;


use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property string $title
 * @property integer $parent_category_id
 * @property integer $label_class
 */
class Category extends ActiveRecord
{

    const LABEL_INVERSE = 'label-inverse';
    const LABEL_DEFAULT = 'label-default';
    const LABEL_PRIMARY = 'label-primary';
    const LABEL_SUCCESS = 'label-success';
    const LABEL_WARNING = 'label-warning';
    const LABEL_DANGER = 'label-danger';
    const LABEL_INFO = 'label-info';

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'Zelenin\yii\behaviors\Slug',
                'slugAttribute' => 'slug',
                'attribute' => 'title',
                // optional params
                'ensureUnique' => true,
                'replacement' => '-',
                'lowercase' => true,
                'immutable' => false,
                // If intl extension is enabled, see http://userguide.icu-project.org/transforms/general.
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @return array
     */
    public function getLabelsArray()
    {
        return [
            self::LABEL_DEFAULT => 'LABEL_DEFAULT',
            self::LABEL_INVERSE => 'LABEL_INVERSE',
            self::LABEL_PRIMARY => 'LABEL_PRIMARY',
            self::LABEL_SUCCESS => 'LABEL_SUCCESS',
            self::LABEL_WARNING => 'LABEL_WARNING',
            self::LABEL_DANGER => 'LABEL_DANGER',
            self::LABEL_INFO => 'LABEL_INFO',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug'], 'required'],
            [['parent_category_id'], 'integer'],
            [['label_class'], 'safe'],
            ['parent_category_id', 'default', 'value' => 0],
            [['title', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'parent_category_id' => 'Parent Category ID',
            'label_class' => 'Label Class',
        ];
    }

    /**
     * @return array
     */
    public static function getCategories()
    {
        $categories = Category::find()->all();
        return $categories;
    }

    public function getUrl()
    {
        return '/articles/' . $this->slug;
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->label_class = array_rand(Category::getLabelsArray());
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
