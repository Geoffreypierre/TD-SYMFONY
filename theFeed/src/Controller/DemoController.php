<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController {

    #[Route('/hello', name: 'hello_get', methods: ["GET"])]
    public function hello(): Response {
        return $this->render("demo/demo1.html.twig");
    }

    #[Route('/hello/{name}', name: 'hello_get2', methods: ["GET"])]
    public function name($name): Response {
        return $this->render("demo/demo2.html.twig", ["name" => $name,]);
    }

    #[Route('/array', name: 'hello_get3', methods: ["GET"])]
    public function list(): Response {
        $array = ["beurre", "lait", "pain"];
        $this->addFlash("danger", "ET LE FROMAGE !");
        return $this->render("demo/demo3.html.twig", ["listeCourses" => $array,]);
    }

}
