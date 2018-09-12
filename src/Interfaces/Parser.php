<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 06/09/2018
 * Time: 15:51
 */

namespace Oberon\Quill\Render\Interfaces;

interface Parser
{

    /**
     * @param array $op
     * @param Renderer[] $renderers passed by reference, might be modified
     * @return boolean returns true if the op was fully handled, false otherwise
     */
    public function handleOp(array $op, array & $renderers);

}