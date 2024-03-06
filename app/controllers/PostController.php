<?php

namespace App\Controllers;

use Funbox\Framework\Http\Response;

class PostController
{
    function show(int $id): Response
    {
        return new Response(content: <<< HTML
                    <h1>Posts</h1>
                    <p>
                    This is post {$id} 
                    </p>
                    HTML);
    }
}
