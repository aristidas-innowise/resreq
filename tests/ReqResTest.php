<?php

namespace Innowise\ReqRes\Test;

use Illuminate\Http\Client\Request;
use Innowise\ReqRes\DTO\UserDTO;
use PHPUnit\Framework\TestCase;
use Innowise\ReqRes\ReqRes;


class ReqResTest extends TestCase
{
    public function testGetUser()
    {
        $id = 2;
        $client = new ReqRes();
        $client->fake(
            [
                "https://reqres.in/api/users/$id" => $client->response(json_decode(file_get_contents(__DIR__ . '/data/getUserResponse.json'), true), 200),
            ]
        );
        $user = $client->getUser($id);
        $client->assertSent(function (Request $request) use ($id) {
            return
                $request->hasHeader('Accept', 'application/json') &&
                $request->url() == 'https://reqres.in/api/users/' . $id;
        });

        $this->assertEquals($id, $user->id, 'User ID is valid.');
        $this->assertEquals("Janet", $user->firstName, "User name correct.");
        $this->assertEquals("Weaver", $user->lastName, "User surname correct.");
        $this->assertEquals("janet.weaver@reqres.in", $user->email, "User email correct.");
        $this->assertEquals("https://reqres.in/img/faces/2-image.jpg", $user->avatar, "User avatar correct.");

    }

    public function testGetUsers()
    {
        $page = 2;
        $perPage = 6;
        $client = new ReqRes();
        $client->fake(
            [
                "https://reqres.in/api/users" => $client->response(json_decode(file_get_contents(__DIR__ . '/data/getUsersResponse.json'), true), 200),
            ]
        );
        $users = $client->getUsers($perPage, $page);

        $client->assertSent(function (Request $request) {
            return
                $request->hasHeader('Accept', 'application/json') &&
                $request->url() == 'https://reqres.in/api/users?per_page=6&page=2';
        });

        $this->assertEquals(6, $users->count(), 'Users count of elemnt is correct.');
        $this->assertInstanceOf(UserDTO::class, $users[0], "User is an instance of UserDTO.");
        $this->assertEquals('Michael', $users[0]->firstName, "User name is correct.");
        $this->assertFalse($users->hasNextPage(), "This is the last page.");
        $this->assertEquals(null, $users->getNextPage(), "There is no next page.");
    }

    public function testCreateUser()
    {
        $name = 'morpheus';
        $job = 'leader';
        $client = new ReqRes();
        $client->fake(
            [
                "https://reqres.in/api/users" => $client->response(json_decode(file_get_contents(__DIR__ . '/data/createUserResponse.json'), true), 201),
            ]
        );
        $userId = $client->createUser($name, $job);

        $client->assertSent(function (Request $request) {
            return
                $request->hasHeader('Accept', 'application/json') &&
                $request->url() == 'https://reqres.in/api/users' &&
                $request->method() == 'POST' &&
                $request->body() == '{"name":"morpheus","job":"leader"}';
        });

        $this->assertEquals(682, $userId, 'User id is correct.');
    }

    public function testUserJsonSerializable()
    {
        $user = new UserDTO(10, 'email@test.com', 'Name', 'Surname', 'https://reqres.in/img/faces/7-image.jpg');
        $jsonOutput = json_encode($user, JSON_UNESCAPED_SLASHES);

        $this->assertEquals('{"id":10,"email":"email@test.com","first_name":"Name","last_name":"Surname","avatar":"https://reqres.in/img/faces/7-image.jpg"}', $jsonOutput, "User converts into valid json.");
    }

    public function testGetUsersWithNextPage()
    {
        $page = 1;
        $perPage = 6;
        $client = new ReqRes();
        $client->fake(
            [
                "https://reqres.in/api/users" => $client->response(json_decode(file_get_contents(__DIR__ . '/data/getUsersWIthNextPageResponse.json'), true), 200),
            ]
        );
        $users = $client->getUsers($perPage, $page);

        $client->assertSent(function (Request $request) {
            return
                $request->hasHeader('Accept', 'application/json') &&
                $request->url() == 'https://reqres.in/api/users?per_page=6&page=1';
        });

        $this->assertTrue($users->hasNextPage(), "This is not the last page.");
        $this->assertEquals(2, $users->getNextPage(), "Next page number is 2.");
    }

}