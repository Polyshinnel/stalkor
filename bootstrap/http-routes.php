<?php

use App\Middlewares\BasicAuthMiddleware;
use App\Pages\AuthPage;
use App\Pages\CategoryPage;
use App\Pages\GetProducts;
use App\Pages\IndexPage;
use App\Pages\ProductPage;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app): void {
    $app->get('/auth', [AuthPage::class, 'get']);
    $app->post('/authUser', [AuthPage::class, 'authorize']);


    $app->group('/',function (RouteCollectorProxy $group) {
        $group->get('',[IndexPage::class,'get']);
        $group->get('category/{id}',[CategoryPage::class,'get']);
        $group->get('products/{id}',[ProductPage::class,'get']);
    })->add(BasicAuthMiddleware::class);

    $app->post('/getProducts', [GetProducts::class, 'get']);
};