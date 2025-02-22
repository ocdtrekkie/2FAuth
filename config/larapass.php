<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Relaying Party
    |--------------------------------------------------------------------------
    |
    | We will use your application information to inform the device who is the
    | relaying party. While only the name is enough, you can further set the
    | a custom domain as ID and even an icon image data encoded as BASE64.
    |
    */

    'relaying_party' => [
        'name' => env('WEBAUTHN_NAME', env('APP_NAME')),
        'id'   => env('WEBAUTHN_ID'),
        'icon' => env('WEBAUTHN_ICON'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Challenge configuration
    |--------------------------------------------------------------------------
    |
    | When making challenges your application needs to push at least 16 bytes
    | of randomness. Since we need to later check them, we'll also store the
    | bytes for a sensible amount of seconds inside your default app cache.
    |
    */

    'bytes' => 16,
    'timeout' => 60,
    'cache' => env('WEBAUTHN_CACHE'),

    /*
    |--------------------------------------------------------------------------
    | Algorithms
    |--------------------------------------------------------------------------
    |
    | Here are default algorithms to use when asking to create sign and encrypt
    | binary objects like a public key and a challenge. These works almost in
    | any device, but you can add or change these depending on your devices.
    |
    | @see https://www.iana.org/assignments/cose/cose.xhtml#algorithms
    |
    */

    'algorithms' => [
        \Cose\Algorithm\Signature\ECDSA\ES256::class,   // ECDSA with SHA-256
        \Cose\Algorithm\Signature\EdDSA\Ed25519::class, // EdDSA
        \Cose\Algorithm\Signature\ECDSA\ES384::class,   // ECDSA with SHA-384
        \Cose\Algorithm\Signature\ECDSA\ES512::class,   // ECDSA with SHA-512
        \Cose\Algorithm\Signature\RSA\RS256::class,     // RSASSA-PKCS1-v1_5 with SHA-256
    ],


    /*
    |--------------------------------------------------------------------------
    | Credentials Attachment.
    |--------------------------------------------------------------------------
    |
    | Authentication can be tied to the current device (like when using Windows
    | Hello or Touch ID) or a cross-platform device (like USB Key). When this
    | is "null" the user will decide where to store his authentication info.
    |
    | By default, the user decides what to use for registration. If you wish
    | to exclusively use a cross-platform authentication (like USB Keys, CA
    | Servers or Certificates) set this to true, or false if you want to
    | enforce device-only authentication.
    |
    | Supported: "null", "cross-platform", "platform".
    |
    */

    'attachment' => null,

    /*
    |--------------------------------------------------------------------------
    | Attestation Conveyance
    |--------------------------------------------------------------------------
    |
    | The attestation is the data about the device and the public key used to
    | sign. Using "none" means the data is meaningless, "indirect" allows to
    | receive anonymized data, and "direct" means to receive the real data.
    | 
    | Attestation Conveyance represents if the device key should be verified
    | by you or not. While most of the time is not needed, you can change this
    | to indirect (you verify it comes from a trustful source) or direct
    | (the device includes validation data).
    |
    | Supported: "none", "indirect", "direct".
    |
    */

    'conveyance' => 'none',

    /*
    |--------------------------------------------------------------------------
    | User presence and verification
    |--------------------------------------------------------------------------
    |
    | Most authenticators and smartphones will ask the user to actively verify
    | themselves for log in. For example, through a touch plus pin code,
    | password entry, or biometric recognition (e.g., presenting a fingerprint).
    | The intent is to distinguish individual users.
    |
    | Supported: "required", "preferred", "discouraged".
    |
    | Use "required" to always ask verify, "preferred"
    | to ask when possible, and "discouraged" to just ask for user presence.
    |
    */

    'login_verify' => env('WEBAUTHN_USER_VERIFICATION', 'preferred'),


    /*
    |--------------------------------------------------------------------------
    | Userless (One touch, Typeless) login
    |--------------------------------------------------------------------------
    |
    | By default, users must input their email to receive a list of credentials
    | ID to use for authentication, but they can also login without specifying
    | one if the device can remember them, allowing for true one-touch login.
    |
    | If required or preferred, login verification will be always required.
    |
    | Supported: "null", "required", "preferred", "discouraged".
    |
    */

    'userless' => null,

    /*
    |--------------------------------------------------------------------------
    | Credential limit
    |--------------------------------------------------------------------------
    |
    | Authenticators can have multiple credentials for the same user account.
    | To limit one device per user account, you can set this to true. This
    | will force the attest to fail when registering another credential.
    |
    */

    'unique' => false,

    /*
    |--------------------------------------------------------------------------
    | Password Fallback
    |--------------------------------------------------------------------------
    |
    | When using the `eloquent-webauthn´ user provider you will be able to use
    | the same user provider to authenticate users using their password. When
    | disabling this, users will be strictly authenticated only by WebAuthn.
    |
    */

    'fallback' => false,

    /*
    |--------------------------------------------------------------------------
    | Device Confirmation
    |--------------------------------------------------------------------------
    |
    | If you're using the "webauthn.confirm" middleware in your routes you may
    | want to adjust the time the confirmation is remembered in the browser.
    | This is measured in seconds, but it can be overridden in the route.
    |
    */

    'confirm_timeout' => 10800, // 3 hours
];
