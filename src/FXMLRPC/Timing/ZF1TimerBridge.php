<?php
/**
 * Copyright (C) 2012
 * Lars Strojny, InterNations GmbH <lars.strojny@internations.org>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace FXMLRPC\Timing;

use Zend_Log;

class ZF1TimerBridge implements TimerInterface
{
    /**
     * @var Zend_Log
     */
    private $log;

    /**
     * @var integer
     */
    private $level;

    /**
     * @var string
     */
    private $messageTemplate;

    /**
     * @param \Zend_Log $log
     * @param integer $level
     * @param string $messageTemplate
     */
    public function __construct(Zend_Log $log, $level = null, $messageTemplate = null)
    {
        $this->log = $log;
        $this->level = $level ?: Zend_Log::DEBUG;
        $this->messageTemplate = $messageTemplate ?: 'FXMLRPC call took %01.10Fs';
    }

    /**
     * {@inheritdocs}
     */
    public function recordTiming($callTime, $method, array $arguments)
    {
        $this->log->log(
            sprintf($this->messageTemplate, $callTime),
            $this->level,
            array('xmlrpcMethod' => $method, 'xmlrpcArguments' => $arguments)
        );
    }
}