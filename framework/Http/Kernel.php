<?php

namespace Funbox\Framework\Http;

class Kernel
{

    public function handle(Request $request): Response
    {
        $content =  <<< HTML
            <h1>Hello world!</h1>
            HTML;

        return new Response(content: $content);
    }

}
