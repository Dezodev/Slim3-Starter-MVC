<?php

namespace App\Controllers\Admin;
use App\Models\Media;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class MediaController extends Controller {
    public function index($request, $response, $args) {
        $allMedias = Media::all()->toArray();

        foreach ($allMedias as $key => $media) {
            $allMedias[$key]['thumbpath'] = pathinfo($media['path'], PATHINFO_DIRNAME) . '/' . pathinfo($media['path'], PATHINFO_FILENAME) . '-150-150.' . pathinfo($media['path'], PATHINFO_EXTENSION);
        }

        return $this->view->render($response, 'admin/media/index.twig', ['medias' => $allMedias]);
    }

    public function upload($request, $response, $args) {
        return $this->view->render($response, 'admin/media/upload.twig');
    }

    public function save($request, $response, $args) {
        $dir = $this->upload_dir;

        $files = $request->getUploadedFiles();
        if (empty($files['mediaFile'])) {
            throw new Exception('Expected a file');
        } elseif ($files['mediaFile']->getError() === UPLOAD_ERR_OK) {
            $fileRet = $this->moveUploadedFile($dir, $files['mediaFile']);

            $media = Media::create([
                'name' => $fileRet['basename'],
                'path' => $this->upload_uri . '/' . $fileRet['filename'],
                'mimetype' => $fileRet['mimetype'],
            ]);
        }

        return $response->withJson([
            "status" => "OK",
            "data" => [],
        ]);
    }

    public function delete($request, $response, $args) {
        $media = Media::find($args['id']);
        $dir = $this->upload_dir;

        $bool = unlink($dir.DIRECTORY_SEPARATOR.pathinfo($media['path'], PATHINFO_BASENAME));

        // die(var_dump($dir.DIRECTORY_SEPARATOR.pathinfo($media['path'], PATHINFO_BASENAME)));

        if ($bool) {
            foreach ($this->imageSizes as $imgsize) {
                $bool = unlink( $dir.DIRECTORY_SEPARATOR.sprintf(
                        '%s-%s-%s.%0.8s',
                        pathinfo($media['path'], PATHINFO_FILENAME),
                        $imgsize[0], $imgsize[1],
                        pathinfo($media['path'], PATHINFO_EXTENSION)
                    )
                );

                if(!$bool) break;
            }

            if ($bool) {
                Media::destroy($args['id']);

                $this->flash->addMessage('success', 'Le media a bien été supprimé.');
                return $response->withRedirect($this->router->pathFor('admin_media_list'));
            } else {
                $this->flash->addMessage('danger', 'Le media n\'a pas pu être supprimé. #02');
                return $response->withRedirect($this->router->pathFor('admin_media_list'));
            }

        } else {
            $this->flash->addMessage('danger', 'Le media n\'a pas pu être supprimé. #01');
            return $response->withRedirect($this->router->pathFor('admin_media_list'));
        }


    }

    private function moveUploadedFile($dir, $formFile) {
        $basename = pathinfo($formFile->getClientFilename(), PATHINFO_FILENAME);
        $extension = pathinfo($formFile->getClientFilename(), PATHINFO_EXTENSION);
        $prefix = bin2hex(random_bytes(4));
        $filename = sprintf('%s-%s.%0.8s', $prefix, $basename, $extension);

        $formFile->moveTo($dir . DIRECTORY_SEPARATOR . $filename);

        foreach ($this->imageSizes as $imgsize) {
            $this->imageManager->make($dir . DIRECTORY_SEPARATOR . $filename)
                ->fit($imgsize[0], $imgsize[1])
                ->save($dir.DIRECTORY_SEPARATOR.sprintf('%s-%s-%s-%s.%0.8s', $prefix, $basename, $imgsize[0], $imgsize[1], $extension));
        }

        return [
            'basename' => $basename,
            'filename' => $filename,
            'mimetype' => $formFile->getClientMediaType(),
        ];
    }
}
