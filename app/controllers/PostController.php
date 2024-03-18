<?php

namespace App\Controllers;

use App\Entities\Post;
use App\Repositories\PostMapper;
use App\Repositories\PostRepository;
use Doctrine\DBAL\Exception;
use Funbox\Framework\Http\Response;
use Funbox\Framework\MVC\AbstractController;

class PostController extends AbstractController
{

    public function __construct(
        private readonly PostMapper $postMapper,
        private readonly PostRepository $postRepository
    )
    {
    }

    function show(int $id): Response
    {
        $post = $this->postRepository->findById($id);

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
    function store(): void
    {
        $title = $this->request->postParams['title'];
        $body = $this->request->postParams['body'];

        $post = Post::create($title, $body);

        $this->postMapper->save($post);
    }
}
