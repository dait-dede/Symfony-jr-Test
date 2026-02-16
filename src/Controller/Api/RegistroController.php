<?php

namespace App\Controller\Api;

use App\Entity\Registro;
use App\Repository\RegistroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistroController extends AbstractController
{
    #[Route('/api/registros', name: 'api_registro_create', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $em,
        RegistroRepository $repo
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $usuarioId = $data['usuario_id'] ?? null;
        $descripcion = $data['descripcion'] ?? null;
        $origen = $data['origen'] ?? null;

        // Validaciones básicas
        if (!is_int($usuarioId) || $usuarioId <= 0 || empty($descripcion)) {
            return $this->json([
                'ok' => false,
                'error' => 'Datos inválidos'
            ], 400);
        }

        // Validar duplicado
        $existe = $repo->findOneBy([
            'usuarioId' => $usuarioId,
            'descripcion' => $descripcion
        ]);

        if ($existe) {
            return $this->json([
                'ok' => false,
                'error' => 'Registro duplicado'
            ], 409);
        }

        // Crear entidad
        $registro = new Registro();
        $registro->setUsuarioId($usuarioId);
        $registro->setDescripcion($descripcion);
        $registro->setOrigen($origen);
        $registro->setEstatus('ACTIVO');
        $registro->setFechaRegistro(new \DateTimeImmutable());

        $em->persist($registro);
        $em->flush();

        return $this->json([
            'ok' => true,
            'id' => $registro->getId()
        ], 201);
    }
}
