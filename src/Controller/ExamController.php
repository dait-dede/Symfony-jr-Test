<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExamController extends AbstractController
{
    #[Route('/exam/generate', name: 'exam_generate', methods: ['GET'])]
    public function generate(): Response
    {
        // this is a placeholder; real logic should create database records, etc.
        return new JsonResponse(['status' => 'ok', 'message' => 'Exam generator stub running']);
    }
}
