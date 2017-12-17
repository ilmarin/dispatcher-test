<?php

class DispatcherCest
{

    /**
     *
     * @var cls\Dispatcher
     */
    private $dispatcher;
    private $groupA;
    private $groupB;
    private $groupC;

    public function _before()
    {
        $this->dispatcher = new \cls\Dispatcher();
    }

    public function ensuresEightRowsInGroupA(UnitTester $I)
    {
        $this->groupA = $this->dispatcher->groupA();
        $I->assertCount(8, $this->groupA);
    }

    public function ensuresTwoRowsInGroupB(UnitTester $I)
    {
        // Ensures we have eight rows in first group
        $this->groupB = $this->dispatcher->groupB();
        $I->assertCount(2, $this->groupB);
    }

    public function ensuresTwoRowsInGroupC(UnitTester $I)
    {
        $this->groupC = $this->dispatcher->groupC();
        $I->assertCount(2, $this->groupC);
    }

    public function sendGroupAMessages(UnitTester $I)
    {
        $prepared = $this->dispatcher->getPreparedData($this->groupA, \cls\Dispatcher::GROUP_A);
        $this->dispatcher->sendMessages($prepared);
        $I->seeMessageInQueueContainsText(RABBITMQ_QUEUE, \cls\Dispatcher::GROUP_A . ';');
        $I->purgeQueue(RABBITMQ_QUEUE);
    }

    public function sendGroupBMessages(UnitTester $I)
    {
        $prepared = $this->dispatcher->getPreparedData($this->groupB, \cls\Dispatcher::GROUP_B);
        $this->dispatcher->sendMessages($prepared);
        $I->seeMessageInQueueContainsText(RABBITMQ_QUEUE, \cls\Dispatcher::GROUP_B . ';');
        $I->purgeQueue(RABBITMQ_QUEUE);
    }

    public function sendGroupCMessages(UnitTester $I)
    {
        $prepared = $this->dispatcher->getPreparedData($this->groupC, \cls\Dispatcher::GROUP_C);
        $this->dispatcher->sendMessages($prepared);
        $I->seeMessageInQueueContainsText(RABBITMQ_QUEUE, \cls\Dispatcher::GROUP_C . ';');
        $I->purgeQueue(RABBITMQ_QUEUE);
    }
}
