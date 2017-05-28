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
class RestaurantController implements ControllerProviderInterface {

    /**
     * Route settings
     *
     */
    public function connect(Application $app) {
        $restaurantController = $app['controllers_factory'];
        $restaurantController->match("/", array($this, 'showAll'))->bind('restaurant_list');
        $restaurantController->get("/{name}", array($this, 'detail'))->bind('restaurant_detail');
        /*$indexController->get("/show/{id}", array($this, 'show'))->bind('acme_show');
        $indexController->match("/create", array($this, 'create'))->bind('acme_create');
        $indexController->match("/update/{id}", array($this, 'update'))->bind('acme_update');
        $indexController->get("/delete/{id}", array($this, 'delete'))->bind('acme_delete');*/
        return $restaurantController;
    }

    public function showAll(Application $app, Request $request) {
        $em = $app['orm.ems']['grupo37'];
        $form = $app['form.factory']->createBuilder(FormType::class, [])
            ->add("name", TextType::class, [
                'required' => false,
            ])
            ->add("city", ChoiceType::class, [
                'choices' => array_map(function($item){ return $item["city"];}, $em->getRepository("Entity37\Restaurant")->getDistinctCities()),
                'choice_label' => function($value, $key, $index) {
                    return $value;
                },
                "placeholder" => "Elige tu ciudad",
                "required" => false
            ])
            ->add("rating", ChoiceType::class, [
                'choices' => [0,1,2,3],
                "placeholder" => "Minimum de estrellas",
                "required" => false
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $data = $form->getData();
            $restaurants = $em->getRepository('Entity37\Restaurant')->getFiltered($data);

        } else {
            $restaurants = $em->getRepository('Entity37\Restaurant')->findAll();
        }

        return $app['twig']->render('restaurant/list.html.twig', [
            'restaurants' => $restaurants,
            'form' => $form->createView()
        ]);
    }

    public function detail(Application $app, $name){
        $em = $app['orm.ems']['grupo37'];
        $restaurant = $em->getRepository('Entity37\Restaurant')->findOneByName($name);
        $orderedReviews = $em->getRepository('Entity37\ReviewRestaurant')->getLatestReviewsFirst($restaurant);
        var_dump($orderedReviews);die;
	return $app['twig']->render('restaurant/detail.html.twig', [
            'restaurant' => $restaurant,
            'reviews' => $orderedReviews
        ]);
    }
}







