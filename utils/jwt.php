<?php

const JWT_SECRET = "AKADEMIK_SECRET_KEY_123";

function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64UrlDecode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

function generateJWT($payload) {
    $header = base64UrlEncode(json_encode([
        "alg" => "HS256",
        "typ" => "JWT"
    ]));

    $payload = base64UrlEncode(json_encode($payload));

    $signature = hash_hmac(
        "sha256",
        "$header.$payload",
        JWT_SECRET,
        true
    );

    return "$header.$payload." . base64UrlEncode($signature);
}

function verifyJWT($token) {
    $parts = explode('.', $token);
    if (count($parts) !== 3) return false;

    [$header, $payload, $signature] = $parts;

    $valid = base64UrlEncode(
        hash_hmac("sha256", "$header.$payload", JWT_SECRET, true)
    );

    if ($signature !== $valid) return false;

    return json_decode(base64UrlDecode($payload), true);
}
