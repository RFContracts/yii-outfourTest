<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 * @property string $title
 * @property string $text
 * @property string $image
 * @property bool $is_deleted
 *
 * @property User $user
 * @property PostTag[] $postTags
 * @property Tag[] $tags
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['is_deleted'], 'boolean'],
            [['title'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'title' => 'Title',
            'text' => 'Text',
            'image' => 'Image',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTag::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->via('postTags');
    }

    /**
     * @return string
     */
    public function getImageSrc()
    {
        if ($this->image == null){
            return '/img/no-image.png';
        }
        return '/img/' . $this->image;
    }

    /**
     * Gets tags for post
     *
     * @return array
     */
    public function getTagIds()
    {
        $arr = [];
        foreach ($this->tags as $tag) {
            $arr[] = $tag->id;
        }
        return $arr;
    }

    /**
     * function for safe delete
     *
     * @return bool|false|int
     */
    public function delete()
    {
        $this->is_deleted = true;
        return $this->save();
    }

    /**
     * This function check is user owner of the post or not
     *
     * @return bool
     */
    public function isMyPost()
    {
        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->id == $this->user_id) {
                return true;
            }
        }
        return false;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($insert){
                $this->created_at = strtotime(date('Y-m-d'));
                $this->updated_at = strtotime(date('Y-m-d'));
            }else{
                $this->updated_at = strtotime(date('Y-m-d'));
            }

            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }
}
