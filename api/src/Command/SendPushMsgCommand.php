<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use BenTools\WebPushBundle\Model\Message\PushNotification;
use BenTools\WebPushBundle\Model\Subscription\UserSubscriptionManagerRegistry;
use BenTools\WebPushBundle\Sender\PushMessageSender;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: "app:send-push-msg", description: "Send push msg to user")]
class SendPushMsgCommand extends Command
{
    /**
     * @var UserSubscriptionManagerRegistry
     */
    private $userSubscriptionManager;
    /**
     * @var PushMessageSender
     */
    private $pushSender;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        UserRepository $userRepository,
        UserSubscriptionManagerRegistry $userSubscriptionManager,
        PushMessageSender $pushSender,
        $name = null
    ) {
        parent::__construct($name);
        $this->userSubscriptionManager = $userSubscriptionManager;
        $this->pushSender = $pushSender;
        $this->userRepository = $userRepository;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('user', InputArgument::REQUIRED, 'User\'s id to whom send test message.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var string $userId */
        $userId = $input->getArgument('user');
        /** @var User|null $user */
        $user = $this->userRepository->find($userId);

        if (null === $user) {
            $io->error(sprintf('User "%s" not exists', $userId));
        }
        $this->notifyUer($user);

        return Command::SUCCESS;
    }

    /**
     * Send push message to user
     *
     * @param User $user
     * @throws \ErrorException
     */
    private function notifyUer(User $user): void
    {
        $subscriptions = $this->userSubscriptionManager->findByUser($user);
        $notification = new PushNotification('Test push messages!', [
            PushNotification::BODY => 'Test push messages!',
        ]);
        $responses = $this->pushSender->push($notification->createMessage(), $subscriptions);

        foreach ($responses as $response) {
            if ($response->isExpired()) {
                $this->userSubscriptionManager->delete($response->getSubscription());
            }
        }
    }
}
