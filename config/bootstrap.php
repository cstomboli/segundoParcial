<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Slim\Factory\AppFactory;
use Config\Database;
use Psr\Http\Message\ServerRequestInterface;

new Database();
$app= AppFactory::create();
$app->setBasePath("/segundoParcial/public");
$app->addRoutingMiddleware();

// Define Custom Error Handler
$customErrorHandler = function (
    ServerRequestInterface $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) use ($app) {

    $payload = ['error' => $exception->getMessage()];

    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write(
        json_encode($payload, JSON_UNESCAPED_UNICODE)
    );
    return $response;
};

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

// Register middleware
(require __DIR__ . '/middleware.php')($app);
// Register routes
(require __DIR__ . '/routes.php')($app);

return $app;