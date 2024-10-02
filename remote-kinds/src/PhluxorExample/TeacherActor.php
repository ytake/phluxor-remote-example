<?php

declare(strict_types=1);

namespace PhluxorExample;

use Phluxor\ActorSystem\Context\ContextInterface;
use Phluxor\ActorSystem\Message\ActorInterface;
use Phluxor\ActorSystem\Ref;
use Phluxor\Remote\Remote;
use PhluxorExample\Message\FinishTest;
use PhluxorExample\Message\PrepareTest;
use PhluxorExample\ProtoBuf\StartTest;
use PhluxorExample\ProtoBuf\SubmitTest;

class TeacherActor implements ActorInterface
{
    /** @var SubmitTest[] */
    private array $endOfTests = [];

    /**
     * @param string $subject
     * @param array $students
     * @param Ref $replyTo
     * @param Remote $remote
     */
    public function __construct(
        private readonly string $subject,
        private readonly array $students,
        private readonly Ref $replyTo,
        private readonly Remote $remote
    ) {
    }

    public function receive(ContextInterface $context): void
    {
        $msg = $context->message();
        switch (true) {
            case $msg instanceof PrepareTest:
                $context->logger()->info(
                    sprintf("Teacher has issued a %s test", $msg->subject)
                );
                foreach ($this->students as $student) {
                    $rp = $this->remote->spawnNamed(
                        'node1:50052',
                        sprintf('student-%d', $student),
                        'student',
                        10
                    );
                    $context->requestWithCustomSender(
                        new Ref($rp->getPid()),
                        new StartTest(['subject' => $msg->subject]),
                        $context->self()
                    );
                }
                break;
            case $msg instanceof SubmitTest:
                $this->endOfTests[] = $msg;
                if (count($this->endOfTests) === count($this->students)) {
                    $context->send($this->replyTo, new FinishTest($this->subject));
                    $context->poison($context->self());
                }
                break;
        }
    }
}
