<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# NO CHECKED-IN PROTOBUF GENCODE
# source: message.proto

namespace PhluxorExample\Metadata;

class Message
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            "\x0A\xA2\x01\x0A\x0Dmessage.proto\x12\x08protobuf\"\x1C\x0A\x09StartTest\x12\x0F\x0A\x07subject\x18\x01 \x01(\x09\"+\x0A\x0ASubmitTest\x12\x0F\x0A\x07subject\x18\x01 \x01(\x09\x12\x0C\x0A\x04name\x18\x02 \x01(\x09B4\xCA\x02\x17PhluxorExample\\ProtoBuf\xE2\x02\x17PhluxorExample\\Metadatab\x06proto3"
        , true);

        static::$is_initialized = true;
    }
}

