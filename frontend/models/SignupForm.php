<?php
namespace frontend\models;

<<<<<<< HEAD
use yii\base\Model;
use common\models\User;
=======
use Yii;
use yii\base\Model;
use frontend\models\User;
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;


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
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
<<<<<<< HEAD
     * @return User|null the saved model or null if saving fails
=======
     * @return bool whether the creating new account was successful and email was sent
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
<<<<<<< HEAD
        
        return $user->save() ? $user : null;
=======
        $user->generateEmailVerificationToken();

        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole('user');
        $auth->assign($authorRole, $user->getId());

        return $user->save() && $this->sendEmail($user);

    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
    }
}
