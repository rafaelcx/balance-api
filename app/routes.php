<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
	$app->get('/balance', function (Request $request, Response $response, $args) {
		return (new \App\Http\BalanceController())->handle($request);
	});

	$app->post('/event', function (Request $request, Response $response, $args) {
		return (new \App\Http\EventController())->handle($request);
	});
};
