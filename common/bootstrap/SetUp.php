<?php

namespace common\bootstrap;

/*use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Filesystem;
use site\cart\Cart;
use site\cart\cost\calculator\DynamicCost;
use site\cart\cost\calculator\SimpleCost;
use site\cart\storage\HybridStorage;
use site\dispatchers\AsyncEventDispatcher;
use site\dispatchers\DeferredEventDispatcher;
use site\dispatchers\EventDispatcher;
use site\dispatchers\SimpleEventDispatcher;
use site\entities\behaviors\FlySystemImageUploadBehavior;
use site\entities\Shop\Product\events\ProductAppearedInStock;
use site\jobs\AsyncEventJobHandler;
use site\listeners\Shop\Category\CategoryPersistenceListener;
use site\listeners\Shop\Product\ProductAppearedInStockListener;
use site\listeners\Shop\Product\ProductSearchPersistListener;
use site\listeners\Shop\Product\ProductSearchRemoveListener;
use site\listeners\User\UserSignupConfirmedListener;
use site\listeners\User\UserSignupRequestedListener;
use site\repositories\events\EntityPersisted;
use site\repositories\events\EntityRemoved;
use site\services\newsletter\MailChimp;
use site\services\newsletter\Newsletter;
use site\services\sms\LoggedSender;
use site\services\sms\SmsRu;
use site\services\sms\SmsSender;
use site\services\yandex\ShopInfo;
use site\services\yandex\YandexMarket;
use site\entities\User\events\UserSignUpConfirmed;
use site\entities\User\events\UserSignUpRequested;
use site\useCases\ContactService;
use yii\caching\Cache;
use yii\di\Container;
use yii\di\Instance;
use yiidreamteam\upload\ImageUploadBehavior;
use zhuravljov\yii\queue\Queue;*/
use common\modules\catalogManager\B2bPortal;
use site\services\user\UserManageService;
use yii\base\BootstrapInterface;
use yii\base\ErrorHandler;
use yii\mail\MailerInterface;
use yii\rbac\ManagerInterface;


class SetUp implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = \Yii::$container;



        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(ErrorHandler::class, function () use ($app) {
            return $app->errorHandler;
        });

        $container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->authManager;
        });

        $container->setSingleton(B2bPortal::class, function () use ($app) {
            return new B2bPortal(
                $app->params['b2bHost'],
                $app->params['b2bUser'],
                $app->params['b2bPass']
            );
        });


        /*        $container->setSingleton(Client::class, function () {
                    return ClientBuilder::create()->build();
                });

        $container->setSingleton(Queue::class, function () use ($app) {
            return $app->get('queue');
        });

        $container->setSingleton(Cache::class, function () use ($app) {
            return $app->cache;
        });

        $container->setSingleton(ContactService::class, [], [
            $app->params['adminEmail']
        ]);

        $container->setSingleton(Cart::class, function () use ($app) {
            return new Cart(
                new HybridStorage($app->get('user'), 'cart', 3600 * 24, $app->db),
                new DynamicCost(new SimpleCost())
            );
        });

        $container->setSingleton(YandexMarket::class, [], [
            new ShopInfo($app->name, $app->name, $app->params['frontendHostInfo']),
        ]);

        $container->setSingleton(Newsletter::class, function () use ($app) {
            return new MailChimp(
                new \DrewM\MailChimp\MailChimp($app->params['mailChimpKey']),
                $app->params['mailChimpListId']
            );
        });

        $container->setSingleton(SmsSender::class, function () use ($app) {
            return new LoggedSender(
                new SmsRu($app->params['smsRuKey']),
                \Yii::getLogger()
            );
        });

        $container->setSingleton(EventDispatcher::class, DeferredEventDispatcher::class);

        $container->setSingleton(DeferredEventDispatcher::class, function (Container $container) {
            return new DeferredEventDispatcher(new AsyncEventDispatcher($container->get(Queue::class)));
        });

        $container->setSingleton(SimpleEventDispatcher::class, function (Container $container) {
            return new SimpleEventDispatcher($container, [
                UserSignUpRequested::class => [UserSignupRequestedListener::class],
                UserSignUpConfirmed::class => [UserSignupConfirmedListener::class],
                ProductAppearedInStock::class => [ProductAppearedInStockListener::class],
                EntityPersisted::class => [
                    ProductSearchPersistListener::class,
                    CategoryPersistenceListener::class,
                ],
                EntityRemoved::class => [
                    ProductSearchRemoveListener::class,
                    CategoryPersistenceListener::class,
                ],
            ]);
        });

        $container->setSingleton(AsyncEventJobHandler::class, [], [
            Instance::of(SimpleEventDispatcher::class)
        ]);

        $container->setSingleton(Filesystem::class, function () use ($app) {
            return new Filesystem(new Ftp($app->params['ftp']));
        });

        $container->set(ImageUploadBehavior::class, FlySystemImageUploadBehavior::class);
        */
    }
}