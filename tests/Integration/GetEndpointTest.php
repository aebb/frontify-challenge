<?php

namespace Frontify\Tests\Integration;

use PHPUnit\Framework\TestCase;

class GetEndpointTest extends TestCase
{
    private function request(string $url): array
    {
        $url = 'http://task-frontify' . $url;
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $data = curl_exec($curl);
        curl_close($curl);

        return (array) json_decode($data);
    }

    public function testGetSuccess()
    {
        $result = $this->request('/colors/1');

        $this->assertNotEmpty($result['id']);
        $this->assertNotEmpty($result['name']);
        $this->assertNotEmpty($result['hexCode']);
        $this->assertNotEmpty($result['createdAt']);
        $this->assertNotEmpty($result['updatedAt']);

        $this->assertEquals(5, count($result));
    }

    public function testGetBadRequest()
    {
        $result = $this->request('/colors/xpto');

        $this->assertEmpty($result['errorCode']);
        $this->assertNotEmpty($result['message']);

        $this->assertEquals(0, $result['errorCode']);
        $this->assertEquals('no route found', $result['message']);

        $this->assertEquals(2, count($result));
    }

    public function testGetNotFound()
    {
        $result = $this->request('/colors/12345');

        $this->assertNotEmpty($result['errorCode']);
        $this->assertNotEmpty($result['message']);

        $this->assertEquals(1, $result['errorCode']);
        $this->assertEquals('color not found', $result['message']);

        $this->assertEquals(2, count($result));
    }
}
