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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Entity40\Guest;
use Entity40\Reservation;


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
        $hotel = $em->getRepository('Entity40\Hotel')->find($id);
        if(!$hotel){
            $app['session']->getFlashBag()->add('error', 'Hotel no encontrado');
            return $app->redirect($app['url_generator']->generate('hotel_list'));
        }

        $form = $app['form.factory']->createBuilder(FormType::class, [])
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
            ->add("submit", SubmitType::class)
            ->getForm();

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
}
