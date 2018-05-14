<?php

namespace App\Security;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * https://symfony.com/doc/current/security/guard_authentication.html
 * Class LoginFormAuthenticator
 * @package App\Security
 */
class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var RouterInterface
     */
    private $router;

    use TargetPathTrait;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $em, RouterInterface $router)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
    }

    /**
     * Get the authentication credentials from the request and return them
     * as any type (e.g. an associate array).
     *
     * Whatever value you return here will be passed to getUser() and checkCredentials()
     *
     * For example, for a form login, you might:
     *
     *      return array(
     *          'username' => $request->request->get('_username'),
     *          'password' => $request->request->get('_password'),
     *      );
     *
     * Or for an API token that's on a header, you might use:
     *
     *      return array('api_key' => $request->headers->get('X-API-TOKEN'));
     *
     * @param Request $request
     *
     * @return mixed Any non-null value
     *
     * @throws \UnexpectedValueException If null is returned
     */
    public function getCredentials(Request $request)
    {
//        $isLoginSubmit = $request->getPathInfo() == '/login' && $request->isMethod('POST');
//        if ($request->attributes->get('_route') === 'security_login' && $request->isMethod('POST'))
        if (!$this->supports($request)) {
            // skip authentication
            return;
        }

        $form = $this->formFactory->create(UserType::class);
        $form->handleRequest($request);
//        $form->isValid()
        $data = $form->getData();
        return $data;

    }


    /**
     * Executed if getCredentials() return is different of null
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return null|UserInterface|void If null, guard authentication will fail and the user will see an error.
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];

        // See Entity/User::getUsername()
        $user = $this->em->getRepository(User::class)
            ->findOneBy(['name' => $username]);

        return $user;

    }

    /**
     * Executed if getUser() return is different of null
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool|void
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
//        dump($this);die;
//        $password = $credentials['_password'];
//        if ($password == 'password') {
//            return true;
//        }
//        return false;
        return true;
    }



    /**
     * Return the URL to the login page.
     *
     * @return string
     */
    protected function getLoginUrl()
    {
        return $this->router->generate('security_login');
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey The provider (i.e. firewall) key
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // if the user hits a secure page and start() was called, this was
        // the URL they were on, and probably where you want to redirect to
        $targetPath = $this->getTargetPath($request->getSession(), $providerKey);

        if (!$targetPath) {
            $targetPath = $this->router->generate('homepage');
        }

        return new RedirectResponse($targetPath);
    }

    /**
     * Override to control what happens when the user hits a secure page
     * but isn't logged in yet.
     *
     * @return RedirectResponse
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return parent::start($request, $authException); // TODO: Change the autogenerated stub
    }

    /**
     * Override to change what happens after a bad username/password is submitted.
     *
     * @return RedirectResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return parent::onAuthenticationFailure($request, $exception); // TODO: Change the autogenerated stub
    }


    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        return ($request->getPathInfo() == '/login' && $request->isMethod('POST'));
//        return $request->headers->has('X-AUTH-TOKEN');
//        return false;
    }


}
