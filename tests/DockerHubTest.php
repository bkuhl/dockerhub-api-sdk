<?php

namespace DockerHub;

use Mockery;
use PHPUnit\Framework\TestCase;

class DockerHubTest extends TestCase
{
    /** @var string */
    protected $username;

    /** @var string */
    protected $password;

    /** @var DockerHub */
    protected $dockerHub;

    /** @var Mockery\MockInterface */
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $this->username = uniqid();
        $this->password = uniqid();
        $this->client = Mockery::mock(Client::class);
        $this->dockerHub = new DockerHub($this->username, $this->password);
        $this->dockerHub->setClient($this->client);
    }

    /** @test */
    public function suppliesRepository()
    {
        $name = uniqid();

        $this->assertInstanceOf(Repository::class, $this->dockerHub->repository($name));
    }

    /** @test */
    public function suppliesCurrentUser()
    {
        $currentUser = uniqid();

        $this->client->shouldReceive('get')->with('user')->andReturn($currentUser);

        $this->assertEquals($currentUser, $this->dockerHub->currentUser());
    }
}