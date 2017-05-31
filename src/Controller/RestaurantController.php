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
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use Entity37\Reservation;
use Entity37\ReservationRestaurant;
use Entity37\Client;

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
    $restaurantController->match("/{name}/reserve", [$this, "reserve"])->bind('restaurant_reserve');
    $restaurantController->get("/{name}/reservations", array($this, 'detailReservations'))->bind('restaurant_detail_reservations');
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
      ->add("sort", ChoiceType::class, [
        'choices' => ['Por ciudad' => 'ciudad', 'Alfabetico' => 'alfabetico', 'Por estrellas' => 'estrellas'],
        'placeholder' => 'Ordenar los resultados...',
        'required' => false
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
    if (!$restaurant){
      $app['session']->getFlashBag()->add('error', 'Restaurante no encontrado');
      return $app->redirect($app['url_generator']->generate('restaurant_list'));
    }
    $orderedReviews = $em->getRepository('Entity37\ReviewRestaurant')->getLatestReviewsFirst($restaurant);
    return $app['twig']->render('restaurant/detail.html.twig', [
      'restaurant' => $restaurant,
      'reviews' => $orderedReviews
    ]);
  }

  public function reserve(Application $app, Request $request, $name){
    $em = $app['orm.ems']['grupo37'];
    $restaurant = $em->getRepository('Entity37\Restaurant')->findOneByName($name);
    if (!$restaurant){
      $app['session']->getFlashBag()->add('error', 'Restaurante no encontrado');
      return $app->redirect($app['url_generator']->generate('restaurant_list'));
    }

    $form = $app['form.factory']->createBuilder(FormType::class, [])
      // Client info
      ->add("phoneNumber")
      ->add("clientName")
      // Reservation info
      ->add("date", DateType::class,[
          'widget' => 'single_text'
      ])
      ->add("time", TimeType::class,[
          'widget' => 'choice',
          'minutes' => ['00']
      ])
      ->add("quantity", IntegerType::class, [
        'attr' => [
          'min' => 0,
          'max' => $restaurant->getCapacity()
        ]
      ])
      ->add('submit', SubmitType::class)
      ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted()){
      $data = $form->getData();
      $client = $em->getRepository('Entity37\Client')->findOneBy(['phone_number' => $data['phoneNumber']]);
      if (!$client){
        $client = new Client();
        $client->setPhoneNumber($data['phoneNumber']);
        $client->setName($data["clientName"]);
      }

      $reservation = new Reservation();
      $reservation->setDate($data['date']);
      $reservation->setTime($data['time']);
      $reservation->setQuantity($data['quantity']);

      $reservationRestaurant = new ReservationRestaurant();
      $reservationRestaurant->setClient($client);
      $reservationRestaurant->setRestaurant($restaurant);
      $reservationRestaurant->setReservation($reservation);

      $em->persist($client);
      $em->persist($reservation);
      $em->persist($reservationRestaurant);
      $em->flush();

      $app['session']->getFlashBag()->add('success', 'Reserva hecha exitosamente');
      return $app->redirect($app['url_generator']->generate('restaurant_detail', ['name' => $name]));
    }

    return $app['twig']->render('restaurant/reserve.html.twig', [
      'restaurant' => $restaurant,
      'form' => $form->createView()
    ]);
  }

  public function detailReservations(Application $app, $name){
    $em = $app['orm.ems']['grupo37'];
    $restaurant = $em->getRepository('Entity37\Restaurant')->findOneByName($name);
    if (!$restaurant){
      $app['session']->getFlashBag()->add('error', 'Restaurante no encontrado');
      return $app->redirect($app['url_generator']->generate('restaurant_list'));
    }
    return $app['twig']->render('restaurant/detail_reservations.html.twig', [
      'restaurant' => $restaurant
    ]);
  }
}







