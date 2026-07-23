<?php

return [
    'ai3_articlesummary' => [
        'path' => '/ai3/articlesummary',
        'target' => \Wegewerk\Ai3Summary\Controller\Ajax\ArticlesummaryController::class . '::getArticlesummary'
    ],
];
