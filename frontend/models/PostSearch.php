<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post;

/**
 * PostSearch represents the model behind the search form of `common\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * @var array
     */
    public $tags;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['created_at', 'updated_at'], 'string', 'max' => 12],
            [['tags'], 'each', 'rule' => ['integer']],
            [['title', 'text', 'image'], 'safe'],
            [['is_deleted'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find()->joinWith('postTags')->distinct();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $this->updated_at = strtotime($this->updated_at);

        // grid filtering conditions
        $query->andFilterWhere([
            'post.id' => $this->id,
            'post.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['ilike', 'post.title', $this->title])
            ->andFilterWhere(['ilike', 'post.text', $this->text])
            ->andFilterWhere(['ilike', 'post.updated_at', $this->updated_at])
            ->andFilterWhere(['in', 'post_tag.tag_id', $this->tags])
            ->andFilterWhere(['ilike', 'post.image', $this->image]);

        return $dataProvider;
    }
}
