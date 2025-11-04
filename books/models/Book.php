<?php
declare(strict_types=1);

namespace books\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $year
 * @property string $isbn
 * @property string $image
 * @property integer $created_at
 * @property integer $updated_at
 */
final class Book extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%books}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'year', 'isbn'], 'required'],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['title', 'isbn', 'image'],  'string', 'max' => 255],
        ];
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('book_author', ['book_id' => 'id']);
    }
}
