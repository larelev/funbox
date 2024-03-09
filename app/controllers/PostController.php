<?php

namespace App\Controllers;

use Funbox\Framework\Http\Response;
use Funbox\Framework\MVC\AbstractController;

class PostController extends AbstractController
{
    function show(int $id): Response
    {
        return $this->render('post.html.twig', [
            'postId' => $id
        ]);
    }

    function create(): Response
    {
        return $this->render('create.post.html.twig');
    }
}
