<?php

namespace App\ValueResolver;

use App\DTO\Request\MenuRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DtoRequestResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface  $validator,
    )
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return str_starts_with($argument->getType(), 'App\\DTO\\');
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
