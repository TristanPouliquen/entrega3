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
class HotelController implements ControllerProviderInterface {

    /**
     * Route settings
     *
     */
    public function connect(Application $app) {
        $hotelController = $app['controllers_factory'];
        $hotelController->get("/", array($this, 'showAll'))->bind('hotel_list');
        /*$indexController->get("/show/{id}", array($this, 'show'))->bind('acme_show');
        $indexController->match("/create", array($this, 'create'))->bind('acme_create');
        $indexController->match("/update/{id}", array($this, 'update'))->bind('acme_update');
        $indexController->get("/delete/{id}", array($this, 'delete'))->bind('acme_delete');*/
        return $hotelController;
    }

    public function showAll(Application $app) {
        $em = $app['orm.ems']['grupo40'];
        $hotel = $em->getRepository('Entity40\Hotel')->findAll();
        return $app['twig']->render('Hotel/list.html.twig', [
            'hotels' => $hotel
        ]);
    }
}