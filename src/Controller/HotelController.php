<?php

namespace Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


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
        $hotelController->match("/", array($this, 'showAll'))->bind('hotel_list');
        $hotelController->get("/{id}", array($this, 'detail'))->bind('hotel_detail');
        /*$indexController->get("/show/{id}", array($this, 'show'))->bind('acme_show');
        $indexController->match("/create", array($this, 'create'))->bind('acme_create');
        $indexController->match("/update/{id}", array($this, 'update'))->bind('acme_update');
        $indexController->get("/delete/{id}", array($this, 'delete'))->bind('acme_delete');*/
        return $hotelController;
    }

    public function showAll(Application $app, Request $request) {
        $em = $app['orm.ems']['grupo40'];
        $form = $app['form.factory']->createBuilder(FormType::class, [])
            ->add("name", TextType::class, [
                'required' => false
            ])
            ->add("city", ChoiceType::class, [
                'choices' => array_map(function($item){ return $item["city"];}, $em->getRepository("Entity40\Address")->getDistinctCities()),
                'placeholder' => "Elige tu ciudad",
                "required" => false
            ])
            ->add("rating", ChoiceType::class, [
                'choices' => [0,1,2,3,4,5],
                'placeholder' => 'Minimum de estrellas',
                "required" => false
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $data = $form->getData();
            $hotels = $em->getRepository('Entity40\Hotel')->getFiltered($data);

        } else {
            $hotels = $em->getRepository('Entity40\Hotel')->findAll();
        }

        return $app['twig']->render('hotel/list.html.twig', [
            'hotels' => $hotels,
            'form' => $form->createView()
        ]);
    }

    public function detail(Application $app, $id){
        $em40 = $app['orm.ems']['grupo40'];
        $em37 = $app['orm.ems']['grupo37'];
        $hotel = $em40->getRepository('Entity40\Hotel')->findOne($id);
        $restaurant = $em37->getRepository('Entity37\Restaurant')->findOneBy([
            'city' => $hotel->getAddress()->getCity(),
            'street' => $hotel->getAddress()->getNumber() . ' ' . $hotel->getAddress()->getStreet()
        ]);
        return $app['twig']->render('hotel/detail.html.twig', [
            'hotel' => $hotel,
            'restaurant' => $restaurant
        ]);
    }
}
