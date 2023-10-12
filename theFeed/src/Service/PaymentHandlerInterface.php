<?php

namespace App\Service;

use App\Entity\Utilisateur;

interface PaymentHandlerInterface
{
    public function getPremiumCheckoutUrlFor(Utilisateur $utilisateur)  : string;
    public function checkPaymentStatus($sessionId) : bool;
}