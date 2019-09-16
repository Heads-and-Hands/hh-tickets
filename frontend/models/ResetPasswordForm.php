<?php
namespace frontend\models;

<<<<<<< HEAD
use yii\base\Model;
use yii\base\InvalidParamException;
=======
use yii\base\InvalidArgumentException;
use yii\base\Model;
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
use common\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
<<<<<<< HEAD
     * @throws \yii\base\InvalidParamException if token is empty or not valid
=======
     * @throws InvalidArgumentException if token is empty or not valid
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
<<<<<<< HEAD
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
=======
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong password reset token.');
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
        }
        parent::__construct($config);
    }

    /**
<<<<<<< HEAD
     * @inheritdoc
=======
     * {@inheritdoc}
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
