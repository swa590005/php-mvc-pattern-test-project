<?php

namespace Unit;
use App\Exceptions\RouteNotFoundException;
use App\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;
    protected function setUp():void
    {
        parent::setUp();
        $this->router = new Router();
    }
    /** @test */
    public function it_registers_a_route():void
    {
        $this->router->register('get', '/users',['User', 'index']);

        $expected = [
            'get' =>[
                '/users' => ['User', 'index']
            ]
        ];

        //then we assert that the route is registered
        $this->assertEquals($expected, $this->router->getRoutes());
    }

    /** @test */
    public function it_registers_a_get_route():void
    {
        // when we register a route
        $this->router->get( '/users',['User', 'index']);

        $expected = [
            'get' =>[
                '/users' => ['User', 'index']
            ]
        ];

        //then we assert that the route is registered
        $this->assertEquals($expected, $this->router->getRoutes());
    }

    /** @test */
    public function it_registers_a_post_route():void
    {
        // when we register a route
        $this->router->post( '/users',['User', 'store']);

        $expected = [
            'post' =>[
                '/users' => ['User', 'store']
            ]
        ];

        //then we assert that the route is registered
        $this->assertEquals($expected, $this->router->getRoutes());
    }

    /** @test */
    public function there_are_no_route_when_router_is_created():void
    {
        $router = new Router();
        $this->assertEmpty($router->getRoutes());
    }

    /** @test
     * @dataProvider routeNotFoundCases
     * */
    public function it_throws_route_not_found_exception(string $requestUri, string $requestMethod):void
    {
        $user = new class(){
            public function delete(): bool
            {
                return true;
            }
        };
        $this->router->post('/users', [$user::class,'store']);
        $this->router->get('/users', ['User','index'] );

        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve($requestUri, $requestMethod);
    }

    public function routeNotFoundCases():array
    {
        return [
            ['/users', 'put'],//request-method not found
            ['/invoices', 'post'],//route not found
            ['/users', 'get'],//class not found
            ['/users', 'post'],//method not found
        ];
    }

    /** @test */
    public function it_resolves_a_route():void
    {
        //to check if the class and method are found
        $user = new class(){
            public function store(): array
            {
                return [1,2,3];
            }
        };
        $this->router->post('/users', [$user::class,'store']);
        $this->assertEquals([1,2,3], $this->router->resolve('/users', 'post'));
    }

    /** @test */
    public function it_resolves_a_route_with_a_closure():void
    {
        //to check if the closure(action) is callable
        $this->router->get('/users', fn()=>[1,2,3]);
        $this->assertEquals([1,2,3], $this->router->resolve('/users', 'get'));
    }

}