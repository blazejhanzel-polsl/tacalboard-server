<?php
namespace services;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

final class UsersTest extends TestCase {
    private Client $client;

    public static function dataEndpoints(): array {
        return [
            'root' => ['/'],
            'authorize' => ['/authorize'],
            'confirm' => ['/*/confirm/*']
        ];
    }

    public function setUp(): void {
        $this->client = new Client([
            'base_uri' => 'http://localhost/users/',
            'http_errors' => false
        ]);
    }

    /**
     * @dataProvider dataEndpoints
     */
    public function testGet(string $method): void {
        switch ($method) {
            case '/':
                $this->testGetRoot();
                break;
            case '/authorize':
                $this->testGetAuthorize();
                break;
            case '/*/confirm/*':
                $this->testGetConfirm();
        }
    }

    private function testGetAuthorize(): void {
        // Return 401
        $response = $this->client->get('');
        $this->assertEquals(401, $response->getStatusCode());
    }

    private function testGetRoot(): void {
        $response = $this->client->get('');
        $this->assertEquals(405, $response->getStatusCode());
    }

    private function testGetConfirm(): void {
        // Return 404
        $response = $this->client->get('-1/confirm/key');
        $this->assertEquals(404, $response->getStatusCode());
    }
}
