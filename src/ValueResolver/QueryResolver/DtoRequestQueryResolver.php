<?php

namespace App\ValueResolver\QueryResolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DtoRequestQueryResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface  $validator,
    )
    {
    }

    public function supports(ArgumentMetadata $argument): bool
    {
        return str_starts_with($argument->getType(), 'App\\DTO\\Request\\Query\\');
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $dto = $this->serializer->deserialize(json_encode($request->query->all()), $argument->getType(), 'json');

        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            throw new BadRequestHttpException(json_encode(['errors' => $errorMessages]));
        }


        yield $dto;
    }
}
