<?php
namespace frontend\tests\unit\models;

<<<<<<< HEAD
use Yii;
use frontend\models\ContactForm;
=======
use frontend\models\ContactForm;
use yii\mail\MessageInterface;
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89

class ContactFormTest extends \Codeception\Test\Unit
{
    public function testSendEmail()
    {
        $model = new ContactForm();

        $model->attributes = [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'subject' => 'very important letter subject',
            'body' => 'body of current message',
        ];

        expect_that($model->sendEmail('admin@example.com'));

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

<<<<<<< HEAD
        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('admin@example.com');
        expect($emailMessage->getFrom())->hasKey('tester@example.com');
=======
        /** @var MessageInterface  $emailMessage */
        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('admin@example.com');
        expect($emailMessage->getFrom())->hasKey('noreply@example.com');
        expect($emailMessage->getReplyTo())->hasKey('tester@example.com');
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
        expect($emailMessage->getSubject())->equals('very important letter subject');
        expect($emailMessage->toString())->contains('body of current message');
    }
}
