<?php

namespace App\Tests\Utilities;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase as ApiPlatformApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use Carbon\Carbon;
use Coduo\PHPMatcher\Backtrace\InMemoryBacktrace;
use Coduo\PHPMatcher\Factory\MatcherFactory;
use Coduo\PHPMatcher\Matcher;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\BrowserKitAssertionsTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ApiTestCase extends ApiPlatformApiTestCase
{
    use BrowserKitAssertionsTrait;
    use RefreshDatabaseTrait;

    protected const CLIENT_OPTIONS = [
        'headers' => [
            'content-type' => 'application/ld+json'
        ],
        'base_uri' => 'http://example.com',
    ];

    protected ?Client $client = null;

    protected function setup(): void
    {
        Carbon::setTestNow();

        $this->setupClient();
    }

    public function setupClient(): void
    {
        $this->client = static::createClient(['debug' => true], self::CLIENT_OPTIONS);
        $this->client->disableReboot(); // This is to save memory
    }

    protected function assertResponse(
        ResponseInterface $response,
        string $fileName,
        int $expectedStatusCode = Response::HTTP_OK
    ): void {
        $this->assertSame($expectedStatusCode, $response->getStatusCode());

        $expectedJson = $this->getJsonContent($fileName);
        $responseContent = trim($this->prettifyJson($response->getContent()));
        $matcher = $this->createMatcher();
        $results = $matcher->match($responseContent, $expectedJson);

        if (!$results) {
            $diff = new \Diff(
                explode(PHP_EOL, $expectedJson),
                explode(PHP_EOL, $responseContent),
                ['ignoreNewLines' => true, 'ignoreWhitespaces' => true]
            );

            self::fail($matcher->getError() . PHP_EOL . $diff->render(new \Diff_Renderer_Text_Unified()));
        }

        $this->assertTrue(true);
    }

    protected function getJsonContent(string $path): string
    {
        $kernel = static::$kernel;
        $projectDir = $kernel->getContainer()->getParameter('kernel.project_dir');

        return file_get_contents(sprintf(
            '%s/tests/Integration/Api/Expected/%s.json',
            $projectDir,
            $path
        ));
    }

    protected function prettifyJson(string $content): string
    {
        $jsonFlags = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

        return json_encode(json_decode($content), $jsonFlags);
    }

    protected function createMatcher(): Matcher
    {
        return (new MatcherFactory())->createMatcher(new InMemoryBacktrace());
    }

    protected function getResponseAsArray(ResponseInterface $response): array
    {
        return json_decode($response->getContent(false), true);
    }
}