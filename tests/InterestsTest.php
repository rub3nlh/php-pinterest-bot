<?php

namespace seregazhuk\tests;

use seregazhuk\PinterestBot\Api\Providers\Interests;

/**
 * Class InterestsTest
 * @package seregazhuk\tests
 */
class InterestsTest extends ProviderTest
{
    /**
     * @var Interests
     */
    protected $provider;
    protected $providerClass = Interests::class;

    public function testFollow()
    {
        $request = $this->createSuccessApiResponse();
        $error = $this->createErrorApiResponse();

        $this->mock->expects($this->at(1))->method('exec')->willReturn($request);
        $this->mock->expects($this->at(3))->method('exec')->willReturn($error);

        $this->assertTrue($this->provider->follow(1111));
        $this->assertFalse($this->provider->follow(1111));
    }

    public function testUnFollow()
    {
        $request = $this->createSuccessApiResponse();
        $error = $this->createErrorApiResponse();

        $this->mock->expects($this->at(1))->method('exec')->willReturn($request);
        $this->mock->expects($this->at(3))->method('exec')->willReturn($error);

        $this->assertTrue($this->provider->unFollow(1111));
        $this->assertFalse($this->provider->unFollow(1111));
    }
}