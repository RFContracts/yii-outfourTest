<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_tag".
 *
 * @property int $id
 * @property int $post_id
 * @property int $tag_id
 *
 * @property Post $post
 * @property Tag $tag
 */
class PostTag extends \yii\db\ActiveRecord
{
    /**
     * @var boolean
     */
    public $isUpdate = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'tag_id'], 'default', 'value' => null],
            [['post_id', 'tag_id'], 'integer'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'tag_id' => 'Tag ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @param bool $isUpdate
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isUpdate){
            $postTag = PostTag::find()->where(['post_id' => $this->post_id, 'tag_id' => $this->tag_id])->one();

            if ($postTag == null){
                return parent::save($runValidation, $attributeNames);
            }
            return false;
        }

        return parent::save($runValidation, $attributeNames);
    }

    /**
     * {@inheritdoc}
     * @return PostTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostTagQuery(get_called_class());
    }
}
