package php

import (

)

type PhpPackConfig struct {
    paths []string
    actions []string
}

func (c PhpPackConfig) GetPaths() []string {
    return c.paths
}
