# Pub Sub Event

Wrapper for Laravel events so that an event can be published externally without using a listener.

## Prerequisities


* [Laravel](https://laravel.com/) 5.6+
* [superbalist/laravel-pubsub](https://github.com/Superbalist/laravel-pubsub) 3.0+


### Installing

Run the below in your Laravel project to install the library:

```
    composer require entanet/pub-sub-laravel
```

### Registering the service provider

To register the PubSubEventProvider add the below line into the providers array in config/app.php in Laravel:

```
    'providers' => [
    ...
    \Entanet\PubSubLaravel\PubSubEventServiceProvider::class
    ...
```

### Add an alias to the Pub Sub Event Facade

To add an alias to the facade add the following to the alias array in config/app.php in Laravel:

```
    'aliases' => [
    ...
    'PubSubEvent' => \Entanet\PubSubLaravel\PubSubEventFacade::class,
    ...
    
```

Also you can alter the current event alias so that any current Event calls use the Pub Sub Event:

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
 that helper with the Pub Sub Event you need to require the PubSubEventHelper.php file before the
  vendor/autoload.php. Here is an example, altering the public/index.php file in Laravel 5.6:
  
 ```
       // PubSubEventHelper.php is used to override the laravel global event helper.
        require __DIR__.'/../vendor/entanet/pub-sub-laravel/src/PubSubEventHelper.php';
        require __DIR__.'/../vendor/autoload.php';
     
 ```

### Using Pub Sub Event via the Alias/facade

Call dispatch from the facade and supply a relevant event contianing the event data and topic (new \App\Events\PubEvent($data, 'topic_name'))   

```
    PubSubEvent::dispatch(new \App\Events\PubEvent($data), 'topic_name'); 
```

Or if you have altered the existing Event alias:

```
    Event::dispatch(new \App\Events\PubEvent($data), 'topic_name'); 
```

### Using Pub Sub Event via event global helper

If you overridden the global helper:

```
    event(new \App\Events\PubEvent($data), 'topic_name');
```

### What does pub sub do with the topic?

Pub Sub Event will check for a topic and if it exists publish the json_encoded event object.