<?php

namespace Entanet\PubSubLaravel;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;
use Superbalist\PubSub\PubSubAdapterInterface;

class PubSub2ListenerCommand extends Command
{
    /**
     * The name and signature of the subscriber command.
     *
     * @var string
     */
    protected $signature = 'pubsub:consumer {topic}';

    /**
     * The subscriber description.
     *
     * @var string
     */
    protected $description = 'PubSub to listener consumer';

    /**
     * @var PubSubAdapterInterface
     */
    protected $pubsub;

    /**
     * @var Service
     */
    protected $service;

    /**
     * PubSub2ListenerCommand constructor.
     * @param PubSubAdapterInterface $pubsub
     */
    public function __construct(PubSubAdapterInterface $pubsub)
    {
        parent::__construct();

        $this->pubsub = $pubsub;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->pubsub->subscribe($this->argument('topic'), function ($message) {
            Event::dispatch($this->argument('topic'), array($message));
        });
    }
}
