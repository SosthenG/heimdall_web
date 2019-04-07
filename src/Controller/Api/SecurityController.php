<?php

namespace App\Controller\Api;

use Doctrine\Common\Collections\Collection;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken;

/**
 * Class SecurityController
 * @package App\Controller\Api
 */
class SecurityController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/", name="ping")
     */
    public function ping()
    {
        return [
            'result' => 'heimdall',
            'message' => 'This is a functional Heimdall server.',
            'version' => $this->getParameter('heimdall_version')
        ];
    }

    /**
     * @Rest\Get("/test", name="test")
     */
    public function test() // TEMP
    {
        return ['Logged in as ' . $this->getUser()->getUsername() . ' : ' . implode(', ', $this->getUser()->getRoles())];
    }

    /**
     * @Rest\Delete("/token/refresh", name="delete_refresh")
     */
    public function deleteRefreshToken() {
        $em = $this->getDoctrine()->getManager();
        /** @var Collection|RefreshToken[] $refreshTokens */
        $refreshTokens = $em->getRepository(RefreshToken::class)->findBy(['username' => $this->getUser()->getUsername()]);
        foreach ($refreshTokens as $refreshToken) {
            $em->remove($refreshToken);
        }

        try {
            $em->flush();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}