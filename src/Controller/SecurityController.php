<?php

namespace Controller;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;

use Form\UserType;
use Entity37\User;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Provider\DaoAuthenticationProvider;
use Symfony\Component\Security\Core\User\UserChecker;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

use Lib\UserProvider;

Class SecurityController implements ControllerProviderInterface
{
    /**
     * Route settings
     *
     */
    public function connect(Application $app) {
        $securityController = $app['controllers_factory'];
        $securityController->match("/login", array($this, 'login'))->bind('login');
        $securityController->match("/signup", array($this, 'signup'))->bind('signup');
        return $securityController;
    }
    /**
     * login route
     *
     * @return string The rendered template
     */
    public function login(Application $app, Request $request)
    {
        $userLogin = new User();
        $form = $app['form.factory']->create(UserType::class, $userLogin);

        $form->handleRequest($request);

        $user = $app['orm.ems']['grupo37']->getRepository('Entity37\User')->findOneByEmail($userLogin->getEmail());
        if ($form->isSubmitted() && $user){

            $token = new UsernamePasswordToken($user, $userLogin->getPlainPassword(), 'authentication');
            $provider = new DaoAuthenticationProvider(new UserProvider($app), new UserChecker(), 'authentication', new EncoderFactory([]));
            $app['security.token_storage']->setToken($provider->authenticate($token));

            $app['session']->getFlashBag()->add('success', 'Login exitoso');
            return $app->redirect($app['url_generator']->generate('root_index'));
        }
        return $app['twig']->render('security/login.html.twig', array(
            'form' => $form->createView(),
            'error' => $app['security.last_error']($request),
            'allowRememberMe' => isset($app['security.remember_me.response_listener']),
        ));
    }

    public function signup(Application $app, Request $request)
    {
        $user = new User();
        $form = $app['form.factory']->create(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user->setEncodedPassword($app);
            $user->eraseCredentials();

            $em = $app['orm.ems']['grupo37'];
            $em->persist($user);
            $em->flush();

            $app['session']->getFlashBag()->add('success', 'Usted fue inscrito exitosamente. Ahora puede conectarse');
            return $app->redirect($app['url_generator']->generate('login'));
        }
        return $app['twig']->render('security/signup.html.twig', array(
            'form' => $form->createView(),
            'error' => $app['security.last_error']($request),
        ));
    }
}
