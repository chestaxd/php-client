<?php

class BuildRegistrationEventTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $validator = new \Covery\Client\Envelopes\ValidatorV1();

        // Full data
        $result = \Covery\Client\Envelopes\Builder::registrationEvent(
            'someLongString',
            'thisisuser',
            320746,
            'user@site.net',
            'thisisusername',
            'alex',
            'porohov',
            32,
            'female',
            '+34235522',
            'New zealand',
            'facebook'
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame('registration', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('someLongString', $result->getSequenceId());
        self::assertCount(11, $result);
        self::assertSame('thisisuser', $result['user_merchant_id']);
        self::assertSame(320746, $result['registration_timestamp']);
        self::assertSame('user@site.net', $result['email']);
        self::assertSame('thisisusername', $result['user_name']);
        self::assertSame('alex', $result['firstname']);
        self::assertSame('porohov', $result['lastname']);
        self::assertSame(32, $result['age']);
        self::assertSame('female', $result['gender']);
        self::assertSame('+34235522', $result['phone']);
        self::assertSame('New zealand', $result['country']);
        self::assertSame('facebook', $result['social_type']);
        $validator->validate($result);

        // Minimal data
        $current = time();
        $result = \Covery\Client\Envelopes\Builder::registrationEvent(
            'someLongStringX',
            'thisisuser15'
        )->addIdentity(new \Covery\Client\Identities\Stub())->build();

        self::assertSame('registration', $result->getType());
        self::assertCount(1, $result->getIdentities());
        self::assertSame('someLongStringX', $result->getSequenceId());
        self::assertCount(2, $result);
        self::assertSame('thisisuser15', $result['user_merchant_id']);
        self::assertTrue($result['registration_timestamp'] >= $current);
        self::assertArrayNotHasKey('email', $result);
        self::assertArrayNotHasKey('user_name', $result);
        self::assertArrayNotHasKey('firstname', $result);
        self::assertArrayNotHasKey('lastname', $result);
        self::assertArrayNotHasKey('age', $result);
        self::assertArrayNotHasKey('gender', $result);
        self::assertArrayNotHasKey('phone', $result);
        self::assertArrayNotHasKey('country', $result);
        $validator->validate($result);
    }
}