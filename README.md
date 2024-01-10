## Symfony Htmx Bundle
[Htmx](https://htmx.org/) integration for Symfony
- [x] Symfony >=6.0
- [x] PHP >=8.0

### Install
```$ composer require seaworn/symfony-htmx-bundle```

### Setup
Add the following snippet to the front controller. This will allow Symfony to use a custom Request class
```php
/* public/index.php */

\Symfony\Component\HttpFoundation\Request::setFactory(function (...$args) {
    return new \Seaworn\HtmxBundle\Request\HtmxRequest(...$args);
});
```

### Usage
Extend your controller from `Seaworn\HtmxBundle\Controller\AbstractController` or use the `Seaworn\HtmxBundle\Controller\HtmxControllerTrait` trait
```php
// ...
use Seaworn\HtmxBundle\Request\HtmxRequest;
use Seaworn\HtmxBundle\Response\HtmxResponse;

class HelloController extends \Seaworn\HtmxBundle\Controller\AbstractController{}

// or

class HelloController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    use \Seaworn\HtmxBundle\Controller\HtmxControllerTrait;
}
```

#### [Request headers](https://htmx.org/docs/#request-headers)
```php
public function index(HtmxRequest $request): HtmxResponse
{
    // whether the request is made via htmx
    $request->isHtmxRequest();

    // whether the request is via an element using hx-boost attribute
    $request->isBoosted();
    
    // the current browser url
    $request->getCurrentUrl();
    
    // whether request is for history restoration after a miss in the local history cache
    $request->isHistoryRestoreRequest();
    
    // the user response to an hx-prompt
    $request->getPromptResponse();
    
    // the id of the target element if it exists
    $request->getTargetId();

    // the id of the triggered element if it exists
    $request->getTriggerId();
    
    // the name of the triggered element if it exists
    $request->getTriggerName();
    
    // ...
}
```

#### [Response headers](https://htmx.org/docs/#response-headers)
```php
public function index(HtmxRequest $request): HtmxResponse
{
    // ...

    return $this->htmxRender('index.html.twig') // or new HtmxResponse()
        // Optional headers
        ->setLocation(
            "/location", 
            [
              'source' => '',
              'event' => '',
              'handler' => '',
              'target' => '',
              'swap' => '',
              'select' => ''
              'values' => [],
              'headers' => [],
            ]
        )) // set HX-Location header
        ->setPushUrl('/push') // set HX-Push-Url header
        ->setReplaceUrl('/replace') // set HX-Replace-Url header
        ->setReswap('outerHTML') // set HX-Reswap header
        ->setRetarget('#target') // set HX-Retarget header
        ->setReselect('#select') // set HX-Reselect header
        ->setTriggers('event') // set HX-Trigger header (simple)
        ->setAfterSwapTriggers('event1,event2') // set HX-Trigger-After-Swap header (multiple)
        ->setAfterSettleTriggers(['event' => ['key' => 'value']]); // set HX-Trigger-After-Settle header (with detail)
}
```

#### Render  template block
```html
<!-- index.html.twig -->

{% extends 'base.html.twig' %}

{% block block1 %}
    <div id="block1"> 
        Sample content...
    </div>
{% endblock %}
```

```php
public function index(HtmxRequest $request): HtmxResponse
{
    return $this->htmxRenderBlock('index.html.twig', 'block1');
}
```

#### Redirect
```php
public function index(HtmxRequest $request): HtmxResponse
{
    return $this->htmxRedirect('https://htmx.org/');
}
```

#### Refresh
```php
public function index(HtmxRequest $request): HtmxResponse
{
    return $this->htmxRefresh();
}
```

#### Stop [polling](https://htmx.org/docs/#polling)
```html
<!-- index.html.twig -->

{% extends 'base.html.twig' %}

{% block content %}
    <div hx-get="/poll" hx-vals="js:{pollingIndex}" hx-trigger="every 2s"></div>
    <script type="text/javascript">
        var pollingIndex = 0;
        document.body.addEventListener("polling", function(e) {
            pollingIndex++;
            console.log("Polling Index:", pollingIndex);
        });
    </script>
{% endblock %}
```

```php
public function poll(HtmxRequest $request): HtmxResponse
{ 
    $index = $request->get('pollingIndex', 0);
    if ((int)$index >= 10) {
        return new HtmxStopPollingResponse();
    }
    return (new HtmxResponse())->setTriggers('polling');
}
```