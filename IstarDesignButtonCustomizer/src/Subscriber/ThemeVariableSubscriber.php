<?php declare(strict_types=1);

namespace IstarDesign\ButtonCustomizer\Subscriber;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Event\ThemeCompilerEnrichScssVariablesEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ThemeVariableSubscriber implements EventSubscriberInterface
{
    private SystemConfigService $systemConfigService;

    public function __construct
    (
        SystemConfigService $systemConfigService
    )
    {
        $this->systemConfigService = $systemConfigService;
    }

    public static function getSubscribedEvents(): array
    {
        return [ThemeCompilerEnrichScssVariablesEvent::class => 'onAddVariables'];
    }

    public function onAddVariables(ThemeCompilerEnrichScssVariablesEvent $event): void
    {
        $buttonColor = $this->systemConfigService->get("IstarDesignButtonCustomizer.config.buttonCustomizerHexColor", $event->getSalesChannelId()) ?? "";
        if (!$buttonColor) {
            return;
        }
        $event->addVariable('sass-istar-design-button-color', $buttonColor);
    }
}