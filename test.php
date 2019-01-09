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

// The algorithm manager with the HS256 algorithm.
$algorithmManager = AlgorithmManager::create([
    new RS512(),
]);

// Our key.
/*$jwk = JWK::create([
    'kty' => 'oct',
    'k' => 'dzI6nbW4OcNF-AtfxGAmuyz7IpHRudBI0WgGjZWgaRJt6prBn3DARXgUR8NVwKhfL43QBIU2Un3AvCGCHRgY4TbEqhOi8-i98xxmCggNjde4oaW6wkJ2NgM3Ss9SOX9zS3lcVzdCMdum-RwVJ301kbin4UtGztuzJBeg5oVN00MGxjC2xWwyI0tgXVs-zJs5WlafCuGfX1HrVkIf5bvpE0MQCSjdJpSeVao6-RSTYDajZf7T88a2eVjeW31mMAg-jzAWfUrii61T_bYPJFOXW8kkRWoa1InLRdG6bKB9wQs9-VdXZP60Q4Yuj_WZ-lO7qV9AEFrUkkjpaDgZT86w2g',
]);*/ 
 
use Jose\Component\KeyManagement\JWKFactory;
$jwk = JWKFactory::createFromKeyFile(
    'boa.key', // The filename
    null,                   // Secret if the key is encrypted
    [
        'use' => 'sig',         // Additional parameters
        'kid' => 'boaws'
    ]
);

// The JSON Converter.
$jsonConverter = new StandardConverter();

// We instantiate our JWS Builder.
$jwsBuilder = new JWSBuilder(
    $jsonConverter,
    $algorithmManager
);

// The payload we want to sign. The payload MUST be a string hence we use our JSON Converter.
$payload = $jsonConverter->encode([
    'gestion' => 2018,
    'idEntidad' => 494,
    'idDa' => 15,
    'nroPreventivo' => 1,
    'nroCompromiso' => 1,
    'nroDevengado' => 1,
    'nroPago' => 0,
    'nroSecuencia' => 0,
    'nroDevengadoSip' => 0,
    
	'tipoFormulario' => "C",
    'tipoDocumento' => "O",
    'tipoEjecucion' => "N",
    'preventivo' => "S",
    'compromiso' => "S",
    'devengado' => "S",
    'pago' => "N",
    'devengadoSip' => "N",
    'pagoSip' => "N",
    "regularizacion"=> "N",
   "fechaElaboracion"=> "20/09/2018",
   "claseGastoCip"=> 4,
   "claseGastoSip"=> "",
   "idCatpry"=> "",
   "sigade"=> "",
   "otfin"=> "",
   "resumenOperacion"=> "PRUEBA SERVICIOS BOA",
   "moneda"=> 69,
   "fechaTipoCambio"=> "20/09/2018",
   "compraVenta"=> "C",
   "totalAutorizadoMo"=> 10,
   "totalRetencionesMo"=> 0,
   "totalMultasMo"=> 0,
   "liquidoPagableMo"=> 10,
   "usuario"=> "CSO313059200"
]);

$jws = $jwsBuilder 
    ->create()                               // We want to create a new JWS
    ->withPayload($payload)                  // We set the payload
    ->addSignature($jwk, ['alg' => 'RS512'],['kid' => 'boaws']) // We add a signature with a simple protected header
    ->build();       
    

use Jose\Component\Signature\Serializer\JSONGeneralSerializer; 
use Jose\Component\Signature\Serializer\JSONFlattenedSerializer; 

$serializer = new JSONFlattenedSerializer($jsonConverter); // The serializer

$token = $serializer->serialize($jws, 0); // We serialize the signature at index 0 (we only have one signature).

echo $token;    