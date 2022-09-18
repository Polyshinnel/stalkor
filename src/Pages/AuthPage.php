<?php


namespace App\Pages;


use App\Repository\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class AuthPage
{
    private $twig;
    private $userRepository;

    public function __construct(Twig $twig,UserRepository $userRepository)
    {
        $this->twig = $twig;
        $this->userRepository = $userRepository;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->twig->fetch('auth.twig', [
            'title' => 'Авторизация',
        ]);
        return new Response(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data)
        );
    }

    public function authorize(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getParsedBody();

        $login = $params['username'];
        $pass = md5($params['password']);

        $selectRequest = [
            'login' => $login,
            'password' => $pass
        ];

        $authResult = 'Не правильный логин и/или пароль';

        $userData = $this->userRepository->getFilteredUsers($selectRequest);
        if(!empty($userData))
        {
            setcookie("user", $login, time() + 3600*8);
            $authResult = 'AuthSuccess';
        }



        return new Response(
            200,
            new Headers(['Content-type' => 'text/html']),
            (new StreamFactory())->createStream($authResult)
        );
    }

}