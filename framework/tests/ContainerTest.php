<?php

namespace Funbox\Framework\Tests;

use Funbox\Framework\Container\Container;
use Funbox\Framework\Exceptions\ContainerException;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    #[Test]
    #[TestDox("dependant class")]
    public function a_service_can_be_retrieved_from_the_container()
    {
        $container = new Container();
        $container->add('dependant-class', DependantClass::class);

        $this->assertInstanceOf(DependantClass::class, $container->get('dependant-class'));
    }

    #[Test]
    public function a_ContainerException_is_thrown_if_a_service_cannot_be_found()
    {
        $container = new Container();
        $this->expectException(ContainerException::class);
        $container->add('foobar');
    }

    #[Test]
    public function can_check_if_the_container_has_a_service()
    {
        $container = new Container();
        $container->add('dependant-class', DependantClass::class);
        $this->assertTrue($container->has('dependant-class'));
        $this->assertFalse($container->has('non-dependant-class'));
    }

    #[Test]
    public function services_can_be_recursively_autowired()
    {
        $container = new Container();
        $dependantService = $container->get(DependantClass::class);
        $dependencyService = $dependantService->getDependency();
        $this->assertInstanceOf(DependencyClass::class, $dependencyService);
        $this->assertInstanceOf(SubDependencyClass::class, $dependencyService->getSubDependency());
    }
}
