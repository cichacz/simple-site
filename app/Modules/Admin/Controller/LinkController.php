<?php

namespace Portal\Modules\Admin\Controller;

use Portal\Common\Model\Link;
use Portal\Common\Model\Page;
use Portal\Core\PortalController;
use Portal\Core\Utils;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

final class LinkController extends PortalController
{
    /**
     * @url-param id
     *
     * @menu Dodaj link
     *
     * @param $request
     * @param $response
     * @param $args
     * @return mixed
     */
    protected function indexGetAction($request, $response, $args)
    {
        $args['formAction'] = self::$_router->pathFor('admin-link-save', $args);

        if(isset($args['id'])) {
            $id = (int)$args['id'];
            $args['page'] = Link::get($id);

            if(empty($args['page'])) {
                $uri = self::$_router->pathFor('admin', $args);
                return $response->withRedirect($uri);
            }
        }

        return $args;
    }

    /**
     * @url-param id
     *
     * @param $request
     * @param $response
     * @param $args
     * @return mixed
     */
    protected function indexDeleteAction($request, $response, $args)
    {
        if(isset($args['id'])) {
            $id = (int)$args['id'];
            Link::delete($id);
        }

        return $this->json(array(
            'success' => true
        ));
    }

    /**
     * @url-param id
     *
     * @param $request
     * @param $response
     * @param $args
     * @return mixed
     */
    protected function savePostAction($request, $response, $args)
    {
        $formVars = $request->getParsedBody();
        if(isset($args['id'])) {
            $id = (int)$args['id'];
            Link::update($id, $formVars);
        } else {
            $id = Link::save($formVars);
        }

        $args['id'] = $id;

        $uri = self::$_router->pathFor('admin-link', $args);
        return $response->withRedirect($uri);
    }
}