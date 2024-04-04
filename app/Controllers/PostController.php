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

class PostController extends AbstractController
{

    public function __construct(
        private readonly PostMapper $postMapper,
        private readonly PostRepository $postRepository,
    ) {
    }

    public function show(int $id): Response
    {
        try {
            $post = $this->postRepository->findOrFail($id);
        } catch (PostNotFoundException $exception) {
            return $this->render('404.html.twig', [
                'message' => $exception->getMessage(),
            ], 404);
        }

        return $this->render('post.html.twig', [
            'post' => $post,
        ]);
    }

    public function create(): Response
    {
        return $this->render('create.post.html.twig');
    }

    /**
     * @throws Exception
     */
    public function store(): Response
    {
        $title = $this->request->getPostParams('title');
        $body = $this->request->getPostParams('body');

        $post = Post::create($title, $body);

        $this->postMapper->save($post);

        $this->request->getFlashMessage()->setSuccess(
            "Post %s successfully created", $title
        );

        return new RedirectResponse('/posts');
    }
}
