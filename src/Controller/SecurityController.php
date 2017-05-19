<?php

namespace Controller;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;

use Silex\Application;

Class SecurityController
{
    /**
     * Route settings
     *
     */
    public function connect(Application $app) {
        $securityController = $app['controllers_factory'];
        $securityController->get("/login", array($this, 'login'))->bind('login');
        return $securityController;
    }
    /**
     * login route
     *
     * @return string The rendered template
     */
    public function login(Application $app, Request $request)
    {
        $form = $this->app['form.factory']->createNamedBuilder(null, 'form',
            ['_username' => '', '_password' => ''])
            ->add('_username', 'text', [
                'label' => 'Email',
                'attr' =>[
                    'name' => '_username',
                    'placeholder' => 'test@test.com'
                ],
                'constraints' => new Assert\Email()
            ])
            ->add('_password', 'password', [
                'label' => 'Password',
                'attr' => [
                    'name' => '_password',
                    'placeholder' => 'test'
                ],
                'constraints' => [new Assert\NotBlank()
            ]])
            ->getForm();
        return $this->app['twig']->render('security/login.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Form',
            'error' => $this->app['security.last_error']($request),
            'last_username' => $this->app['session']->get('_security.last_username'),
            'allowRememberMe' => isset($this->app['security.remember_me.response_listener']),
        ));
    }
}
