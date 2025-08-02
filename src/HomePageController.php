<?php

declare(strict_types=1);

namespace VillagerBell;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Response;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(RouterInterface $router): Response
    {
        $routes = $router->getRouteCollection()->all();

        $formattedRoutes = [];
        foreach ($routes as $routeName => $route) {
            // remove the _preview_error and other symfony routers
            if (str_starts_with($routeName, '_')) {
                continue;
            }

            $formattedRoutes[] = [
                'name' => $routeName,
                'path' => $route->getPath(),
                'controller' => $route->getDefault('_controller'),
                'methods' => $route->getMethods() ? implode(', ', $route->getMethods()) : 'ANY',
            ];
        }

        return $this->render('home.html.twig', [
            'formatted_routes' => $formattedRoutes,
        ]);
    }
}