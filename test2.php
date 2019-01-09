<?php
ini_set('display_errors','1');
require_once __DIR__ . '/vendor/autoload.php';

use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\Converter\StandardConverter;
use Jose\Component\Core\JWK;
use Jose\Component\Signature\Algorithm\HS256;
use Jose\Component\Signature\Algorithm\RS256;
use Jose\Component\Signature\Algorithm\RS512;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\JWSVerifier;

// The algorithm manager with the HS256 algorithm.
$algorithmManager = AlgorithmManager::create([
    new RS512()
]);

// We instantiate our JWS Verifier.
$jwsVerifier = new JWSVerifier(
    $algorithmManager
);

// Our key.
/*$jwk = JWK::create([
    'kty' => 'oct',
    'k' => 'dzI6nbW4OcNF-AtfxGAmuyz7IpHRudBI0WgGjZWgaRJt6prBn3DARXgUR8NVwKhfL43QBIU2Un3AvCGCHRgY4TbEqhOi8-i98xxmCggNjde4oaW6wkJ2NgM3Ss9SOX9zS3lcVzdCMdum-RwVJ301kbin4UtGztuzJBeg5oVN00MGxjC2xWwyI0tgXVs-zJs5WlafCuGfX1HrVkIf5bvpE0MQCSjdJpSeVao6-RSTYDajZf7T88a2eVjeW31mMAg-jzAWfUrii61T_bYPJFOXW8kkRWoa1InLRdG6bKB9wQs9-VdXZP60Q4Yuj_WZ-lO7qV9AEFrUkkjpaDgZT86w2g',
]);*/

use Jose\Component\KeyManagement\JWKFactory;
$jwk = JWKFactory::createFromKeyFile(
    'boa.key', // The filename
    null
);

// The JSON Converter.
$jsonConverter = new StandardConverter();

$token = '{
    "payload": "eyJkYXRhIjp7ImZlY2hhX2VsYWJvcmFjaW9uIjoxNTE3OTUxMzAwMDAwLCJjbGFzZV9nYXN0b19zaXAiOjAsImVzdGFkbyI6IkZJUk1BRE8iLCJyZXN1bWVuX29wZXJhY2lvbiI6IlBhcmEgcmVnaXN0cmFyIGVsIHBhZ28gYSBcIkVMRkVDXCIsIHBvciBlbCBzZXJ2aWNpbyBkZSBlbmVyZ2lhIGVsZWN0cmljYSBlbiBhbWJpZW50ZXMgZGUgbGEgZW1wcmVzYSwgY29ycmVzcG9uZGllbnRlIGEgRW5lcm8gMjAxOCwgc29saWNpdGFkbyBwb3IgU2VydmljaW9zIEdlbmVyYWxlcywgc2VndW4gZG9jdW1lbnRhY2lvbiBhZGp1bnRhLiIsImZlY2hhX3RpcG9fZGVfY2FtYmlvIjpudWxsLCJzaWdhZGUiOm51bGwsInRvdGFsX2F1dG9yaXphZG9fbW8iOjgwODE3LjcxLCJucm9QcmV2ZW50aXZvIjoxMDg4LCJucm9Db21wcm9taXNvIjoxLCJpZERhIjoxNSwidG90YWxfbXVsdGFzX21vIjowLCJnZXN0aW9uIjoyMDE4LCJpZEVudGlkYWQiOjQ5NCwiY2xhc2VfZ2FzdG9fY2lwIjo1LCJpZF9jYXRwcnkiOm51bGwsIm5yb1BhZ28iOjAsImxpcXVpZG9fcGFnYWJsZV9tbyI6ODA4MTcuNzEsIm90ZmluIjpudWxsLCJjb21wcmFfdmVudGEiOm51bGwsIm5yb0RldmVuZ2FkbyI6MSwibW9uZWRhIjo2OSwidXN1YXJpbyI6IlJCQzUyMzIwODIwMCIsIm5yb1NlY3VlbmNpYSI6MCwidG90YWxfcmV0ZW5jaW9uZXNfbW8iOjB9fQ",
    "header": {
        "kid": "mefp.dgsgif"
    },
    "signature": "k-79f628qTrLVlFhNfT5hN5IjTqFYLbGcWdmqrAXIP-3ld7ykIoPCWwbgOhnusLkQGfD39pNwCXKawDCg17xxwYMwcXpXHAW5DyYO3_FCNcf78ngKM3T2yRgRuzqudG8qoGh3i1L1ZXpjsXY2FUaXWsKIz7FLXNwyA1iziCWWNCGDjZBNuTOy8vwFXnCQrOi2WBvpOIy0OcLDPpCMD7Nly4Nn0si4GOGURQvQnPtkCqpnjVjpomyKUcmhPA3K7ajOz-omSN5WYbR9th1YVVnR2l8PMzbcCrlYDbM9D4ysWWK8MRj8OqDTeCtFRITivYXbGUJt9IL7YzjEHjtDkgRoQ",
    "protected": "eyJnZW4iOiJNRUZQLURHU0dJRiIsImFsZyI6IlJTNTEyIn0"
}';

use Jose\Component\Signature\Serializer\JWSSerializerManager;
use Jose\Component\Signature\Serializer\JSONFlattenedSerializer;

$serializer = new JSONFlattenedSerializer($jsonConverter);

// We try to load the token.
$jws = $serializer->unserialize($token);
echo '<pre>' . var_export($jws->getPayload(), true) . '</pre>';
//var_dump($jws);
$isVerified = $jwsVerifier->verifyWithKey($jws, $jwk, 0);

