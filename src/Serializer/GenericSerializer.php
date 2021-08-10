<?php

declare(strict_types=1);

namespace App\Serializer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class GenericSerializer
{
    private $serializer;

    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function serialize($data): string
    {
        return $this->serializer->serialize(
            $data,
            'json'
        );
    }

    public function deserialize(Request $request, string $type)
    {
        return $this->serializer->deserialize(
            $request->getContent(),
            $type,
            'json'
        );
    }
}
