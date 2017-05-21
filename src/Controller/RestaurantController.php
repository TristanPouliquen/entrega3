<?php

namespace Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Sample controller
 *
 */
class RestaurantController implements ControllerProviderInterface {

    /**
     * Route settings
     *
     */
    public function connect(Application $app) {
        $restaurantController = $app['controllers_factory'];
        $restaurantController->get("/", array($this, 'showAll'))->bind('restaurant_list');
        /*$indexController->get("/show/{id}", array($this, 'show'))->bind('acme_show');
        $indexController->match("/create", array($this, 'create'))->bind('acme_create');
        $indexController->match("/update/{id}", array($this, 'update'))->bind('acme_update');
        $indexController->get("/delete/{id}", array($this, 'delete'))->bind('acme_delete');*/
        return $restaurantController;
    }

    public function showAll(Application $app) {
        $em = $app['orm.ems']['grupo37'];
        $restaurants = $em->getRepository('Entity37\Restaurant')->findAll();
        return $app['twig']->render('restaurant/list.html.twig', [
            'restaurants' => $restaurants
        ]);
    }
}







