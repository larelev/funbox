<?php

namespace Tests\FlashMessage;

use App\Widgets\FlashMessage\Enums\FlashType;
use App\Widgets\FlashMessage\FlashMessage;
use Funbox\Framework\Session\Session;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

include dirname(__DIR__, 2) . DIRECTORY_SEPARATOR .  "bootstrap.php";
class FlashMessageTest extends TestCase
{
    protected function setUp(): void
    {
        $session = new Session();
        $session->delete();
        $session->start();
    }

    #[Test]
    public function setAndGetFlashTest()
    {
        $flash = new FlashMessage();
        $flash->set(FlashType::Success, "Great job!");
        $flash->set(FlashType::Error, "Bad luck!");
        $this->assertTrue($flash->hasFlash(FlashType::Success));
        $this->assertTrue($flash->hasFlash(FlashType::Error));
        $this->assertEquals(['Great job!'], $flash->get(FlashType::Success));
        $this->assertEquals([], $flash->get(FlashType::Warning));
    }
}
