<?php

namespace App\Controller;

use App\Entity\User;
use App\Message\UserRegistered;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private $bus;
    private $validator;

    public function __construct(MessageBusInterface $bus, ValidatorInterface $validator)
    {
        $this->bus = $bus;
        $this->validator = $validator;
    }

    /**
     * @Route("/users", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['email'])) {
            return $this->json(['errors' => 'Email is required'], Response::HTTP_BAD_REQUEST);
        }
        if (empty($data['firstName'])) {
            return $this->json(['errors' => 'First name is required'], Response::HTTP_BAD_REQUEST);
        }
        if (empty($data['lastName'])) {
            return $this->json(['errors' => 'Last name is required'], Response::HTTP_BAD_REQUEST);
        }

        $user = new User();
        $user->email = $data['email'];
        $user->firstName = $data['firstName'];
        $user->lastName = $data['lastName'];

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }

        // Log user data (or save to database)
        file_put_contents('../var/log/users.log', json_encode($data) . PHP_EOL, FILE_APPEND);

        $this->bus->dispatch(new UserRegistered($user->email, $user->firstName, $user->lastName));

        return new Response('', Response::HTTP_CREATED);
    }
}
