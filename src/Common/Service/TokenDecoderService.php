<?php


namespace App\Common\Service;


use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\HttpFoundation\Request;

class TokenDecoderService
{
    private JWTEncoderInterface $encoder;

    /**
     * TokenService constructor.
     * @param JWTEncoderInterface $encoder
     */
    public function __construct(JWTEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function decodeToken(Request $request): array
    {
        $token = $request->headers->get('Authorization');
        $data = explode(' ', $token);
        return $this->encoder->decode($data[1]);
    }
}