<?php

namespace frontend\tests\unit\models;

use common\fixtures\UserFixture;
use frontend\models\ResetPasswordForm;

class ResetPasswordFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ]);
    }

    public function testResetWrongToken()
    {
<<<<<<< HEAD
        $this->tester->expectException('yii\base\InvalidParamException', function() {
            new ResetPasswordForm('');
        });

        $this->tester->expectException('yii\base\InvalidParamException', function() {
=======
        $this->tester->expectException('\yii\base\InvalidArgumentException', function() {
            new ResetPasswordForm('');
        });

        $this->tester->expectException('\yii\base\InvalidArgumentException', function() {
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
            new ResetPasswordForm('notexistingtoken_1391882543');
        });
    }

    public function testResetCorrectToken()
    {
        $user = $this->tester->grabFixture('user', 0);
        $form = new ResetPasswordForm($user['password_reset_token']);
        expect_that($form->resetPassword());
    }

}
