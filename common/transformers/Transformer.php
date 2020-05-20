<?php

namespace common\transformers;

interface Transformer
{
    /**
     * @param mixed $data
     * @return array
     */
    public function transform($data): array;
}
