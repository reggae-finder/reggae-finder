package php

type PhpPackConfig struct {
    paths []string
    vendors string
    actions []string
}

func (c PhpPackConfig) GetPaths() []string {
    return c.paths
}

func (c PhpPackConfig) GetActions() []string {
    return c.actions
}
