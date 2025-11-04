<?php
declare(strict_types=1);

namespace books\forms;

use yii\base\Model;

class FormSubsribe extends Model
{
    public string $phone;
    public ?int $user_id;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['phone'], 'string'],
            ['user_id', 'integer'],
        ];
    }

}