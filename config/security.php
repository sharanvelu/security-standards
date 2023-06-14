<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Security Options Master Switch
    |--------------------------------------------------------------------------
    |
    | This option may be used to disable all security features regardless
    | of their individual configuration.
    |
    */
    'enabled' => true,

    /*w
    |--------------------------------------------------------------------------
    | Other Standards for Laravel Application
    |--------------------------------------------------------------------------
    |
    | There are some standards that need to be taken care of in the application
    | level to improve the performance of the application.
    |
    */

    'standards' => [

        /*
        |--------------------------------------------------------------------------
        | Prevents Lazy Loading
        |--------------------------------------------------------------------------
        |
        | Preventing lazy loading in development can help you catch N+1 bugs
        | earlier on in the development process.
        |
        */

        'prevent_lazy_loading' => env('STANDARDS_PREVENT_LAZY_LOADING', true),

        /*
        |--------------------------------------------------------------------------
        | Force HTTPS
        |--------------------------------------------------------------------------
        |
        | Forcing asset files to be loaded in secure connection (HTTPS).
        | When the application is running in the production environment,
        | Force HTTPS will be enabled.
        | OR
        | For other environments, if the request is initiated via https protocol,
        | Then the application will be served over the https.
        |
        */

        'force_https' => env('STANDARDS_ENABLE_FORCE_HTTPS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Headers
    |--------------------------------------------------------------------------
    |
    | There are some headers that needed to be added to every response that
    | application sends to the client which ensure the security of the
    | application and data transmit between the client and server.
    |
    */

    'headers' => [

        /*
        |--------------------------------------------------------------------------
        | Strict-Transport-Security Header
        |--------------------------------------------------------------------------
        |
        | HTTP Strict Transport Security (HSTS) header tells a browser that a website
        | is only accessible using HTTPS. Set whether this header has to be added to
        | the response.
        |
        | Acceptable options : boolean (true, false)
        |
        | Reference : https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security
        |
        */

        'Strict-Transport-Security' => 'max-age=31536000',

        /*
        |--------------------------------------------------------------------------
        | Content-Security-Policy Header
        |--------------------------------------------------------------------------
        |
        | The HTTP Content-Security-Policy response header allows website
        | administrators to control resources the user agent is allowed to load
        | for a given page. With a few exceptions, policies mostly involve
        | specifying server origins and script endpoints.
        |
        | Available directives : child-src, connect-src, default-src, font-src,
        | frame-src, img-src, manifest-src, media-src, object-src, script-src,
        | script-src-elem, script-src-attr, style-src, style-src-elem,
        | style-src-attr, worker-src
        |
        | Keyword Values : 'none', 'self', 'strict-dynamic', 'report-sample'
        | Unsafe Keyword Values : 'unsafe-inline', 'unsafe-eval', 'unsafe-hashes'
        | Scheme Values : https:, http:, data:, ...
        | Host Values : example.com, www.example.com, *.example.com, https://example.com/file.js
        |
        | Reference : https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy
        |
        */

        'Content-Security-Policy' => [
            'default-src' => "*",
            'style-src' => "'self'",
            'script-src' => "'self'",
            'img-src' => "'self'",
            'font-src' => "'self'",
            'frame-src' => "'self'",
            'object-src' => "'self'",
        ],

        /*
        |--------------------------------------------------------------------------
        | Include Headers
        |--------------------------------------------------------------------------
        |
        | The headers that need to be included can be added here. These headers will
        | be included in the response.
        |
        | Example : header_key => header_value
        |
        */

        'includes' => [
            'Server' => 'None',

            'X-Frame-Options' => 'sameorigin',

            'X-Content-Type-Options' => 'nosniff',

            'Referrer-Policy' => 'no-referrer-when-downgrade',

            // ...
        ],
    ],
];
