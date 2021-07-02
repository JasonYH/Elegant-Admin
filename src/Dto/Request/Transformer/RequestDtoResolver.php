<?php
declare(strict_types=1);

namespace App\Dto\Request\Transformer;

use App\Exceptions\ValidatorInvalidParamsException;
use JMS\Serializer\SerializerBuilder;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDtoResolver implements ArgumentValueResolverInterface
{
    private ValidatorInterface $validator;

    /**
     * RequestDtoResolver constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return bool
     * @throws ReflectionException
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $reflection = new ReflectionClass($argument->getType());
        if ($reflection->implementsInterface(RequestDtoTransformerInterface::class)) {
            return true;
        }
        return false;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $serializer = SerializerBuilder::create()->build();

        $contentType = $request->headers->get('Content-Type');

        $isJson = strpos($contentType, 'json');


        if ($request->getMethod() === 'GET') {
            $data = $serializer->serialize($request->query->all(),'json');
        } elseif ($request->getMethod() === 'POST' && $isJson) {
            $data = $request->getContent();
        }else{
            $data = $serializer->serialize($request->request->all(),'json');
        }


        $dto = $serializer->deserialize($data, $argument->getType(), 'json');
        $this->validate($dto);
        yield $dto;
    }

    public function validate($dto)
    {
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            /** @var ConstraintViolation $error */
            $error = $errors->get(0);
            throw new ValidatorInvalidParamsException($error->getMessage());
        }
    }
}
