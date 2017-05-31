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
use Symfony\Component\Form\Extension\Core\Type\TextArea*Type;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;

use Entity40\Guest;
use Entity40\Reservation;

use Entity37\Reservation as Reservation37;
use Entity37\ReservationRestaurant;
use Entity37\Client;


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
        $hotelController->match("/{id}/reserve", [$this, "reserve"])->bind('hotel_reserve');
        $hotelController->get("/{id}/reservations", array($this, 'detailReservations'))->bind('hotel_detail_reservations');
        $hotelController->match("{id}/review", [$this, 'review'])->bind('hotel_review')
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
            'choice_label' => function($value, $key, $index) {
                return $value;
            },
            'placeholder' => "Elige tu ciudad",
            "required" => false
        ])
        ->add("rating", ChoiceType::class, [
            'choices' => [0,1,2,3,4,5],
            'placeholder' => 'Minimum de estrellas',
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
      $hotel = $em40->getRepository('Entity40\Hotel')->find($id);
      if(!$hotel){
        $app['session']->getFlashBag()->add('error', 'Hotel no encontrado');
        return $app->redirect($app['url_generator']->generate('hotel_list'));
      }
      $restaurant = $em37->getRepository('Entity37\Restaurant')->findOneBy([
        'city' => $hotel->getAddress()->getCity(),
        'street' => $hotel->getAddress()->getNumber() . ' ' . $hotel->getAddress()->getStreet()
      ]);
      return $app['twig']->render('hotel/detail.html.twig', [
        'hotel' => $hotel,
        'restaurant' => $restaurant
      ]);
    }

    public function reserve(Application $app, Request $request, $id){
      $em = $app['orm.ems']['grupo40'];
      $em37 = $app['orm.ems']['grupo37'];
      $hotel = $em->getRepository('Entity40\Hotel')->find($id);
      if(!$hotel){
        $app['session']->getFlashBag()->add('error', 'Hotel no encontrado');
        return $app->redirect($app['url_generator']->generate('hotel_list'));
      }
      $restaurant = $em37->getRepository('Entity37\Restaurant')->findOneBy([
        'city' => $hotel->getAddress()->getCity(),
        'street' => $hotel->getAddress()->getNumber() . ' ' . $hotel->getAddress()->getStreet()
      ]);

      $formBuilder = $app['form.factory']->createBuilder(FormType::class, [])
        // Guest info
        ->add("name")
        ->add('identityNumber')
        ->add("phoneNumber")
        ->add('birthdate', DateType::class, [
            'widget' => 'single_text'
        ])
        // Reservation info
        ->add("arrival", DateType::class, [
            'widget' => 'single_text'
        ])
        ->add('duration', IntegerType::class)
        ->add('paymentMethod', ChoiceType::class, [
            'choices' => ['Efectivo', 'Tarjeta de credito', 'Tarjeta de debito', 'Transferencia'],
            'choice_label' => function($value, $key, $index) {
                return $value;
            },
            'placeholder' => 'Elige tu metodo de pago'
        ])
        ->add("submit", SubmitType::class);

      if ($restaurant){
        $formBuilder->add('reserve_lunches', CheckBoxType::class, [
            'required' => false
          ])
          ->add('hour_lunches', TimeType::class, [
            'widget' => 'choice',
            'minutes' => ['00'],
            'required' => false
          ])
          ->add('quantity_lunches', IntegerType::class, [
            'attr' => [
              'min' => 0,
              'max' => $restaurant->getCapacity()
            ],
            'required' => false
          ])
          ->add('reserve_dinners', CheckBoxType::class, [
            'required' => false
          ])
          ->add('hour_dinners', TimeType::class, [
            'widget' => 'choice',
            'minutes' => ['00'],
            'required' => false
          ])
          ->add('quantity_dinners', IntegerType::class, [
            'attr' => [
              'min' => 0,
              'max' => $restaurant->getCapacity()
            ],
            'required' => false
          ]);
      }

      $form = $formBuilder->getForm();

      $form->handleRequest($request);

      if ($form->isSubmitted()){
        $data = $form->getData();
        $guest = $em->getRepository('Entity40\Guest')->findOneBy(['identity_number' => $data['identityNumber']]);
        if(!$guest){
          $guest = new Guest();
          $guest->setName($data['name']);
          $guest->setIdentityNumber($data['identityNumber']);
          $guest->setPhoneNumber($data['phoneNumber']);
          $guest->setBirthdate($data['birthdate']);
        }

        $reservation = new Reservation();
        $reservation->setArrival($data['arrival']);
        $reservation->setDuration($data['duration']);
        $reservation->setPaymentMethod($data['paymentMethod']);
        $reservation->setHotel($hotel);
        $reservation->setGuest($guest);

        if ($data['reserve_dinners'] && $data['hour_dinners'] && $data['quantity_dinners']) {
          for ($i = 0; $i < $reservation->getDuration(); $i++){
            $client_dinner = $em37->getRepository('Entity37\Client')->findOneBy(['phone_number' => $data['phoneNumber']]);
            if (!$client_dinner){
              $client_dinner = new Client();
              $client_dinner->setPhoneNumber($data['phoneNumber']);
              $client_dinner->setName($data["name"]);
            }

            $reservation_dinner = new Reservation37();
            $fecha = $data['arrival'];
            date_add($fecha, date_interval_create_from_date_string($i . " days"));
            $reservation_dinner->setDate($fecha);
            $reservation_dinner->setTime($data['hour_dinners']);
            $reservation_dinner->setQuantity($data['quantity_dinners']);

            $reservationRestaurant_dinner = new ReservationRestaurant();
            $reservationRestaurant_dinner->setClient($client_dinner);
            $reservationRestaurant_dinner->setRestaurant($restaurant);
            $reservationRestaurant_dinner->setReservation($reservation_dinner);

            $em37->persist($client_dinner);
            $em37->persist($reservation_dinner);
            $em37->persist($reservationRestaurant_dinner);
            $em37->flush();
          }
        }

        if ($data['reserve_lunches'] && $data['hour_lunches'] && $data['quantity_lunches']) {
          for ($i = 0; $i < $reservation->getDuration(); $i++){
            $client_lunch = $em37->getRepository('Entity37\Client')->findOneBy(['phone_number' => $data['phoneNumber']]);
            if (!$client_lunch){
              $client_lunch = new Client();
              $client_lunch->setPhoneNumber($data['phoneNumber']);
              $client_lunch->setName($data["name"]);
            }

            $reservation_lunch = new Reservation37();
            $fecha = date_create($data['arrival']);
            date_add($fecha, date_interval_create_from_date_string($i . " days"));
            $reservation_lunch->setDate($fecha);
            $reservation_lunch->setTime($data['hour_lunches']);
            $reservation_lunch->setQuantity($data['quantity_lunches']);

            $reservationRestaurant_lunch = new ReservationRestaurant();
            $reservationRestaurant_lunch->setClient($client_lunch);
            $reservationRestaurant_lunch->setRestaurant($restaurant);
            $reservationRestaurant_lunch->setReservation($reservation_lunch);

            $em37->persist($client_lunch);
            $em37->persist($reservation_lunch);
            $em37->persist($reservationRestaurant_lunch);
            $em37->flush();
          }
        }

        $em->persist($guest);
        $em->persist($reservation);
        $em->flush();

        $app['session']->getFlashBag()->add('success', 'Reserva hecha exitosamente');
        return $app->redirect($app['url_generator']->generate('hotel_detail', ['id' => $id]));
      }

      return $app['twig']->render('hotel/reserve.html.twig', [
        'hotel' => $hotel,
        'form' => $form->createView()
      ]);
    }

    public function detailReservations(Application $app, $id){
      $em = $app['orm.ems']['grupo40'];
      $hotel = $em->getRepository('Entity40\Hotel')->find($id);
      if(!$hotel){
        $app['session']->getFlashBag()->add('error', 'Hotel no encontrado');
        return $app->redirect($app['url_generator']->generate('hotel_list'));
      }

      return $app['twig']->render('hotel/detail_reservations.html.twig', [
        'hotel' => $hotel
      ]);
    }

    public function review(Applicacion $app, Request $request, $id) {
      $em = $app['orm.ems']['grupo40'];
      $hotel = $em->getRepository('Entity40\Hotel')->find($id);
      if(!$hotel){
        $app['session']->getFlashBag()->add('error', 'Hotel no encontrado');
        return $app->redirect($app['url_generator']->generate('hotel_list'));
      }

      $form = $app['form.factory']->createBuilder(FormType::class, ['hotel' => $hotel])
        ->add('hotel', EntityType::class, [
            'class' => 'Entity40\Hotel',
            'choice_label' => 'name',
            'disabled' => true,
            'attr' => [
              'class' => 'form-control-static'
            ]
        ])
        ->add('reservation', EntityType::class, [
          'class' => 'Entity40\Reservation',
          'choice_label' => 'displayName',
          'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('r')
                          ->join('r.hotel', 'h')
                          ->where('h.id = :id')
                          ->setParameter('id', $hotel->getId())
                          ->leftJoin('r.review', 'review')
                          ->andWhere('SIZE(r.review) = 0');
                }
        ])
        ->add('rating', IntegerType::class, [
          'attr' => [
            'min' => 0,
            'max' => 7
          ]
        ])
        ->add('description', TextAreaType::class)
        ->getForm();

      $form->handleRequest($request);

      if ($form->isSubmitted()) {
        $data = $form->getData();
        $review = new Review();

        $review->setReservation($data['reservation']);
        $review->setRating($data['rating']);
        $review->setDescription($data['description']);

        $em->persist($review);
        $em->flush();

        $app['session']->getFlashBag()->add('success', 'Critica guardada');
        return $app->redirect($app['url_generator']->generate('hotel_detail', ['id' => $hotel->getId()]));
      }

      return $app['twig']->render('hotel/detail_reservations.html.twig', [
        'hotel' => $hotel,
        'form' => $form->createView()
      ]);
    }
}
