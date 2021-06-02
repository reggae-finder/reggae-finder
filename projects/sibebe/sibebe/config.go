package sibebe

import (
    "github.com/spf13/viper"
)

type SibebeConfig interface {
    GetWorkDir() string
    GetLanguages() []string
    GetPaths(lang string) []string
    GetPackConfig(language string) map[string]interface{}
    IsVerbose() bool
}

type SibebeViperConfig struct {
    config *viper.Viper
}

func NewSibebeViperConfig(config *viper.Viper) SibebeConfig {
    return SibebeViperConfig{config: config}
}

func (svc SibebeViperConfig) GetWorkDir() string {
    return svc.config.GetString("work_dir")
}

func (svc SibebeViperConfig) GetLanguages() []string {
    return svc.config.GetStringSlice("languages")
}

func (svc SibebeViperConfig) GetPaths(language string) []string {
    return svc.config.GetStringSlice(language +".paths")
}

func (svc SibebeViperConfig) GetPackConfig(language string) map[string]interface{} {
    return svc.config.GetStringMap(language)
}

func (svc SibebeViperConfig) IsVerbose() bool {
    return svc.config.GetBool("verbose")
}
