<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SaludoController extends AbstractController;
{
    #[Route('/api/saludo', name: 'api_saludo', methods: ['POST'])]
    public function saludo(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $nombre = $data['nombre'] ?? null;

        if (empty($nombre)) {
            return $this->json(['error' => 'nombre requerido'], 400);
        }

        return $this->json(['mensaje' => sprintf('Hola %s', $nombre)]);
    }
}
