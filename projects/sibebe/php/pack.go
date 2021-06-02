package php

import (
    _"fmt"

    "github.com/ktom/sibebe/sibebe"
)

type PhpPack struct {
    config PhpPackConfig
    actions map[string]sibebe.Action
}
