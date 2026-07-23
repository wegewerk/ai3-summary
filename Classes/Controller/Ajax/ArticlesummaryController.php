<?php

declare(strict_types=1);

namespace Wegewerk\Ai3Summary\Controller\Ajax;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Resource\StorageRepository;
use Wegewerk\Ai3Core\Domain\Repository\PagesRepository;
use Wegewerk\Ai3Summary\Domain\Capabilities\ArticlesummaryCapability;
use Wegewerk\Ai3Core\Controller\Ajax\AbstractAjaxController;

#[AsController]
class ArticlesummaryController extends AbstractAjaxController
{
    public function __construct(
        LoggerInterface                  $logger,
        private readonly PagesRepository $pagesRepository,
        private ArticlesummaryCapability $articlesummaryCapability,
        protected StorageRepository      $storageRepository
    ) {
        parent::__construct($logger);
    }


    public function getArticlesummary(ServerRequestInterface $request): ResponseInterface {
        try {
            $parsedBody = $request->getParsedBody();
            $pageId = (int)($parsedBody['page_id'] ?? 0);

            if ($pageId <= 0) {
                return $this->createJsonErrorResponse(new Response(), [ 'error' => 'Invalid page ID' ]);
            }
            $content = $this->pagesRepository->getPageContent($pageId);

            if (empty($content)) {
                return $this->createJsonErrorResponse(new Response(), [ 'error' => 'No content found on page' ]);
            }

            $summary = $this->articlesummaryCapability->endpoint->generate(
                '',
                $content,
                $parsedBody['language'] ?? 'de');
            if ($summary === null) {
                return $this->createJsonErrorResponse(new Response(), [ 'error' => 'Error: Suggestion was empty for Page ' . $pageId ]);
            }

            return $this->createJsonSuccessResponse(new Response(), [
                'summary' => $summary,
                'source' => $content,
                'type' => 'summary'
            ]);
        } catch (\Exception $e) {
            $this->logger->error('Error generating Metadata: ' . $e->getMessage());
            return $this->createJsonErrorResponse(new Response(), [ 'error' => $e->getMessage() ]);
        }
    }

}
