<?php

namespace App\Controllers;

use App\Entities\Post;
use App\Repositories\Exceptions\PostNotFoundException;
use App\Repositories\PostMapper;
use App\Repositories\PostRepository;
use Doctrine\DBAL\Exception;
use Funbox\Framework\Http\RedirectResponse;
use Funbox\Framework\Http\Response;
use Funbox\Framework\MVC\AbstractController;
use Funbox\Widgets\FlashMessage\Enums\FlashType;
use Funbox\Widgets\FlashMessage\FlashMessage;
use Funbox\Widgets\FlashMessage\FlashMessageInterface;

class PostController extends AbstractController
{

    public function __construct(
        private readonly PostMapper $postMapper,
        private readonly PostRepository $postRepository,
        private readonly FlashMessageInterface $flashMessage,
    )
    {
    }

    function show(int $id): Response
    {
        try {
            $post = $this->postRepository->findOrFail($id);
        } catch(PostNotFoundException $exception) {
            return $this->render('404.html.twig', [
                'message' => $exception->getMessage()
            ], 404);
        }

        return $this->render('post.html.twig', [
            'post' => $post
        ]);
    }

    function create(): Response
    {
        return $this->render('create.post.html.twig');
    }

    /**
     * @throws Exception
     */
    function store(): Response
    {
        $title = $this->request->postParams['title'];
        $body = $this->request->postParams['body'];

        $post = Post::create($title, $body);

        $this->postMapper->save($post);

        $this->flashMessage->set(
            FlashType::Success,
            sprintf("Post %s successfully created", $title),
        );

        return new RedirectResponse('/posts');
    }
}
