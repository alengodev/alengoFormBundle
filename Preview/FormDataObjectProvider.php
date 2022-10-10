<?php

namespace Alengo\Bundle\AlengoFormBundle\Preview;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;
use Sulu\Bundle\PreviewBundle\Preview\Object\PreviewObjectProviderInterface;

class FormDataObjectProvider implements PreviewObjectProviderInterface
{

    /**
     * @var FormDataRepository
     */
    private $formDataRepository;

    public function __construct(FormDataRepository $formDataRepository)
    {
        $this->formDataRepository = $formDataRepository;
    }

    public function getObject($id, $locale): ?FormData
    {
        return $this->formDataRepository->findOneBy(['id' => $id]);
    }

    public function getId($object)
    {
        return $object->getId();
    }

    public function setValues($object, $locale, array $data)
    {
        return;
    }

    public function setContext($object, $locale, array $context)
    {
        return;
    }

    public function serialize($object)
    {
        return serialize($object);
    }

    public function deserialize($serializedObject, $objectClass)
    {
        return unserialize($serializedObject);
    }

    public function getSecurityContext($id, $locale): ?string
    {
        return null; // the security context used in the admin class for this object
    }
}