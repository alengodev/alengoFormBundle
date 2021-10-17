<?php

namespace Alengo\Bundle\AlengoFormBundle\Service;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;

interface SaveFormInterface
{

    public function saveFormDataFromRequest(array $data) : FormData;

}