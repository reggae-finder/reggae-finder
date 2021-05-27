package php

import (
    "strings"
)

func (p PhpPack) BuildMap(filename string, path string) (string, bool) {

    // USE THE CONFIG TO RESTRICT p.config.paths

    if filename == "composer.json" && !strings.Contains(path, "vendor") {
        return path, true
    }
    return "", false
}
