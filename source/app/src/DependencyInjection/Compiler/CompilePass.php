<?php

namespace App\DependencyInjection\Compiler;

use App\Domain\Contract\MarkdownProcessorContract;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CompilePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container){
        $definition = $container->findDefinition(MarkdownProcessorContract::class);

        // find all service IDs with the app.mail_transport tag
        $taggedServices = $container->findTaggedServiceIds('app.parser');

        foreach ($taggedServices as $id => $tags) {
            // add the transport service to the TransportChain service
            $definition->addMethodCall('addParser', [new Reference($id)]);
        }
    }
}