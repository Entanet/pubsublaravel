# Pub Sub Laravel

Pub-sub-laravel streamlines using the pub-sub pattern in Laravel. It's based on 
[superbalist/laravel-pubsub](https://github.com/Superbalist/laravel-pubsub).

### Publishing to a topic overview

Pub-sub-laravel allows you to publish a message to an external queue via an event without having to add a listener to 
publish the message. It uses the PubSubEvent via alias/facade or a bit of tinkering with the Laravel global helper.

### Subscribing to a topic overview 

You can subscribe to a queue using the PubSub2ListenerCommand so that you don't need to create an event to trigger the 
target listeners. 

  

## Prerequisities


* [Laravel](https://laravel.com/) 5.6+
* [superbalist/laravel-pubsub](https://github.com/Superbalist/laravel-pubsub) 3.0+

Make sure you've included the laravel-pubsub service provider in config/app.php:

```
    'providers' => [
    ...
    Superbalist\LaravelPubSub\PubSubServiceProvider::class,
    ...
```


## Installing and setting up

Run the below in your Laravel project to install the library:

```
    composer require entanet/pub-sub-laravel
```

### Registering the service providers

To register the PubSubEventProvider and PubSub2ListenerProvider add the below line into the providers 
array in config/app.php in Laravel:

```
    'providers' => [
    ...
    
    \Entanet\PubSubLaravel\PubSubEventServiceProvider::class,
    \Entanet\PubSubLaravel\PubSub2ListenerProvider::class
    
    ...
```

### Add an alias to the PubSubEventFacade

To add an alias to the facade add the following to the alias array in config/app.php in Laravel:

```
    'aliases' => [
    ...
    'PubSubEvent' => \Entanet\PubSubLaravel\PubSubEventFacade::class,
    ...
    
```

Also you can alter the current event alias so that any current Event calls use the PubSubEvent:

Change:

```
    'aliases' => [
    ...
    'Event' =>  Illuminate\Support\Facades\Event::class,
    ...
    
```

To:

```
    'aliases' => [
    ...
    'Event' => \Entanet\PubSubLaravel\PubSubEventFacade::class,
    ...
    
```
 
### Overriding the Laravel global helper event
 
Laravel comes with a global helper [event](https://laravel.com/docs/5.6/helpers#method-event) which dispatches the given event so you don't have to use the facade. If you want to override 
that helper with the PubSubEvent you need to require the PubSubEventHelper.php file before the
 vendor/autoload.php. Here is an example, altering the public/index.php file in Laravel 5.6:
  
```
   // PubSubEventHelper.php is used to override the laravel global event helper.
   require __DIR__.'/../vendor/entanet/pub-sub-laravel/src/PubSubEventHelper.php';
   require __DIR__.'/../vendor/autoload.php';
     
```
 
### Set up the listeners for this topic for PubSub2ListenerCommand

 For each topic you are consuming add a mapping in Providers/EventServiceProvider.php
 
```
    protected $listen = [
    ...
         'test_topic' => [
            TestListener::class
        ]
   ...
   ]
```
 

## Using pub-sub-laravel

### Using PubSubEvent via the Alias/facade

Call dispatch from the facade and supply a relevant event containing the event data and topic (new \App\Events\PubEvent($data, 'topic_name'))   

```
    PubSubEvent::dispatch(new \App\Events\PubEvent($data), 'topic_name'); 
```

Or if you have altered the existing Event alias:

```
    Event::dispatch(new \App\Events\PubEvent($data), 'topic_name'); 
```

### Using PubSubEvent via event global helper

If you overridden the global helper:

```
    event(new \App\Events\PubEvent($data), 'topic_name');
```

### Using a PubSub2ListenerCommand to listen to a topic

run the following artisan command appended with the topic name, in this instance the topic is test_topic:

```
    php artisan pubsub:consumer test_topic
```

### Using PubSubTest

PubSubTest sets a mock of the PubSubInterface for you to use in your unit tests and also includes a handy invokeMethod
 which can be used to test protected/private functions. So If you had a privateMethod method in a TricksyClass you'd do something like this:
 
 ```
    $tricksyInstance = new TricksyClass();
    $response = $this->invokeMethod($tricksyInstance, 'privateMethod');
 ```
 
 If it took two variables $var1 and $var2:
 
 ```
     $var1 = 5;
     $var2 = 'Impossible!';
     $tricksyInstance = new TricksyClass();
     $response = $this->invokeMethod($tricksyInstance, 'privateMethod', [$var1, $var2]);
  ```