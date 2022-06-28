<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Repository\ContractRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MissionController extends AbstractController
{
    
    public function getRatingsByContract(Request $request, string $contractId, ContractRepository $contractRepository): Response
    {
        $allRatings = [];
        $contract = $contractRepository->findOneBy(['id' => $contractId]);
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($contract, 'json');
        // dd($contract);

        // if ($contract) {
        //     foreach ($contract->getMissions() as $mission) {
        //         foreach ($mission->getRatings() as $rating) {
        //             $allRatings[] = $rating;
        //         }
        //     }
        // }

        return new Response($jsonContent);
    }
}
