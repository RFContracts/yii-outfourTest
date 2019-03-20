<?php
namespace frontend\models;

use common\models\Post;
use common\models\PostTag;
use yii\base\Model;
use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Post form
 */
class PostForm extends Model
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @var integer
     */
    public $user_id;
    /**
     * @var string
     */
    public $text;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $image;
    /**
     * @var array
     */
    public $tags;
    /**
     * @var array
     */
    public $oldTags;
    /**
     * @var string
     */
    public $fileName = null;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text','title'], 'required'],
            [['id','user_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['tags'], 'each', 'rule' => ['string', 'max' => 100], 'skipOnEmpty' => true],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize' => 5 * 1024 * 1024],
        ];
    }

    /**
     * This function for load data from $model
     *
     * @param $model
     */
    public function loadModel($model)
    {
        $this->id = $model->id;
        $this->user_id = $model->user_id;
        $this->text = $model->text;
        $this->title = $model->title;
        $this->tags = $model->tagIds;
        $this->oldTags = $model->tagIds;
        $this->fileName = $model->image;
    }

    /**
     * upload image
     *
     * @return bool
     */
    public function upload()
    {
        if (!$this->validate()) {
            return false;
        }
        $this->fileName = md5($this->image->name) . '.' . $this->image->extension;

        return $this->image->saveAs(\Yii::getAlias('@webroot') . '/img/' . $this->fileName);
    }

    /**
     * Creating post.
     *
     * @return bool|User|null
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        if ($this->image !== null) {
            $this->upload();
        }

        $post = new Post();
        $post->user_id = Yii::$app->user->id;
        $post->text = $this->text;
        $post->title = $this->title;
        $post->image = $this->fileName;

        if ($post->save()){
            $this->id = $post->id;
            if (is_array($this->tags)) {
                foreach ($this->tags as $tag) {
                    $postTag = new PostTag();
                    $postTag->tag_id = $tag;
                    $postTag->post_id = $this->id;
                    $postTag->save();
                }
            }
            return true;
        }

        return false;
    }

    /**
     * Update post.
     *
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function update()
    {
        if (!$this->validate()) {
            return false;
        }

        if ($this->image !== null){
            $this->upload();
        }

        $post = Post::findOne($this->id);
        $post->text = $this->text;
        $post->title = $this->title;
        $post->image = $this->fileName;

        if ($post->save()){
            $this->id = $post->id;
            if (is_array($this->tags)){
                $diff = array_diff ($this->oldTags, $this->tags);
                foreach ($this->tags as $tag){
                    $postTag = new PostTag();
                    $postTag->tag_id = $tag;
                    $postTag->post_id = $this->id;
                    $postTag->isUpdate = true;
                    $postTag->save();
                }
                if (!empty($diff)){
                    foreach ($diff as $oldTag){
                        $oldPostTag = PostTag::findOne(['post_id' => $this->id, 'tag_id' => $oldTag]);
                        $oldPostTag->delete();
                    }
                }
            }


            return true;
        }

        return false;
    }
}
