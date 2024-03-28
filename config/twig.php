<?php

return [
    APP_VIEWS_PATH,
    ...\Funbox\Plugins\Authentication\Authentication::viewsPaths(),
    ...\Funbox\Plugins\Dashboard\Dashboard::viewsPaths(),
];
