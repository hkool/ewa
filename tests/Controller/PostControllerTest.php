<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Safe\Exceptions\JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function count;

final class PostControllerTest extends AbstractControllerWebTestCase
{
    /**
     * @throws JsonException
     */
    public function testCreatePost(): void
    {
        // test that sending no article will result to a bad request HTTP code.
        $this->JSONRequest(Request::METHOD_POST, '/api/posts');
        $this->assertJSONResponse($this->client->getResponse(), Response::HTTP_BAD_REQUEST);
        // test that sending a correct article will result to a created HTTP code.
        $this->JSONRequest(Request::METHOD_POST, '/api/posts', ['content' => 'EWA HAAGLANDEN BEGINT!']);
        $this->assertJSONResponse($this->client->getResponse(), Response::HTTP_CREATED);
    }

    /**
     * @throws JsonException
     */
    public function testFindAllPosts(): void
    {
        $this->client->request(Request::METHOD_GET, '/api/posts');
        $response = $this->client->getResponse();
        $content = $this->assertJSONResponse($response, Response::HTTP_OK);
        $this->assertEquals(1, count($content));
    }
}
