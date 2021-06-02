package php

import (
    _"fmt"
    "strings"

    "github.com/ktom/sibebe/sibebe"
)

func (p PhpPack) BuildMap(filename string, path string) (string, bool) {
    if filename != "composer.json" || strings.Contains(path, "vendor") {
        return "", false
    }

    workDir := sibebe.GetConfig().GetWorkDir()

    for _, configPath := range p.config.paths {
        if strings.HasPrefix(path, workDir+"/"+configPath) {
            return path, true
        }
    }

    return "", false
}
