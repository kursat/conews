<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Create post form
 */
class CreatePostForm extends Model {

    /**
     * @var UploadedFile
     */
    public $content;
    public $title;
    public $image;
    public $imageFile;

    public function rules() {
        return [
            [['content'], 'string'],
            [['title', 'content'], 'required'],
            [['title', 'image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function save() {
        if ($this->validate()) {
            $this->image = uniqid('image_') . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs('user_images/' . $this->image);

            $post = new Post();
            $post->load(['Post' => $this->toArray()]);
            $post->user_id = Yii::$app->user->id;

            return $post->save();
        } else {
            return false;
        }
    }

}
