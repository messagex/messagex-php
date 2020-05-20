<?php


namespace PhpApiClient\RestClient;


class MockClient
{
    private $mockPath = __DIR__ .'/../../tests/Factories/';

    public function request(string $method, string $path, array $payload=[])
    {
        return file_get_contents($this->mockPath . $path . '.json');
    }
}