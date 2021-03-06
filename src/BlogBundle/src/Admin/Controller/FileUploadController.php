<?php

namespace Harentius\BlogBundle\Admin\Controller;

use Harentius\BlogBundle\FileManagement\FileManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FileUploadController
{
    /**
     * @var FileManager
     */
    private $assetsManager;

    /**
     * @param FileManager $assetsManager
     */
    public function __construct(FileManager $assetsManager)
    {
        $this->assetsManager = $assetsManager;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $assetFile = $this->assetsManager->handleUpload($request->files->get('upload'));

        return new JsonResponse([
            'url' => $assetFile->getUri(),
            'uploaded' => true,
        ]);
    }
}
